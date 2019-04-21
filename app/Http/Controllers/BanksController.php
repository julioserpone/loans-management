<?php

namespace App\Http\Controllers;

use App\Banks;
use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BanksController extends Controller {

    private $rules = [
        'name' => 'required|max:255',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $banks = Banks::withTrashed()->get();
        return view('banks.grid', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $edit = false;
        return view('banks.create', compact('edit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $v = \Validator::make($request->all(), $this->rules);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $bank = Banks::where('name', 'like', '%' . $request->get('name') . '%')->get();

        if ($bank) {
            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.bank_already_exist'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);
            return redirect()->back()->withInput();
        }

        Banks::create($request->all());
        \Utility::setMessage([
            'messageTitle' => trans('globals.success_alert_title'),
            'message' => trans('globals.success_procces'),
            'messageIcon' => 'glyphicon glyphicon-ok-circle',
        ]);

        return redirect()->route('banks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $edit = true;
        $bank = Banks::withTrashed()->where('id', $id)->first();
        if (!$bank) {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.bank_not_exist'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);

            return redirect()->to('banks');
        }
        return view('banks.create', compact('edit', 'bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $v = \Validator::make($request->all(), $this->rules);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $bank = Banks::withTrashed()->where('id', $id)->first();
        $bank->name = $request->get('name');
        $bank->save();

        \Utility::setMessage([
            'messageTitle' => trans('globals.success_alert_title'),
            'message' => trans('globals.success_procces'),
            'messageIcon' => 'glyphicon glyphicon-ok-circle',
        ]);
        return redirect()->route('banks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $bank = Banks::find($id);
        $bank->delete();
        \Utility::setMessage([
            'messageTitle' => trans('globals.success_alert_title'),
            'message' => trans('globals.success_procces'),
            'messageIcon' => 'glyphicon glyphicon-ok-circle',
        ]);
        return redirect()->route('banks.index');

    }

    public function search(Request $request) {
        $q = trim($request->get('q'));
        $data = [];

        $query = Banks::select(['id', 'name']);

        if ($q != '') {
            $query->whereRaw("name like '%" . $q . "%'");
        }

        $banks = $query->orderBy('name', 'asc')->get();

        $banks->each(function ($item, $key) use (&$data) {
            $data[] = ['id' => $item->id, 'text' => $item->name];
        });

        return json_encode($data);
    }

    /**
     * Change status to bank
     */
    public function changeStatus($id,$status) {

        $bank = Banks::withTrashed()->where('id', $id)->first();
        if ($bank) {

            switch ($status) {
                case 'active':
                    //Inactivas
                    $deleted_at = \Carbon\Carbon::now();
                    $bank->status = 'inactive';

                    $bank->deleted_at = $deleted_at->toDateTimeString();
                    $bank->save();
                    break;
                case 'inactive':
                case 'delete':
                    //Activa
                    $bank->deleted_at = null;
                    $bank->status = 'active';
                    $bank->save();  
                    break;
                default:
                    //opciones cargadas a mano desde el explorador (denegadas)
                    \Utility::setMessage([
                        'messageTitle' => trans('globals.error_alert_title'),
                        'message' => trans('validation.request_invalid'),
                        'messageIcon' => 'glyphicon glyphicon-remove-circle',
                        'messageClass' => 'error',
                    ]);
                    break;
            }

            \Utility::setMessage([
                'messageTitle' => trans('globals.success_alert_title'),
                'message' => trans('globals.success_procces'),
                'messageIcon' => 'glyphicon glyphicon-ok-circle',
            ]);
        } else {
            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.bank_not_exist'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);
        }
        return redirect()->to('/banks');
    }
}
