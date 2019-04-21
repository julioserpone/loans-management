<?php

namespace App\Http\Controllers;

use App\Cities;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CitiesController extends Controller {

    private $rules = [
        'name' => 'required|max:255',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $cities = Cities::withTrashed()->get();
        return view('cities.grid', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $edit = false;
        return view('cities.create', compact('edit'));
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

        $city = Cities::where('name', 'like', '%' . $request->get('name') . '%')->get();

        if ($city) {
            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.city_already_exist'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);
            return redirect()->back()->withInput();
        }

        Cities::create($request->all());
        \Utility::setMessage([
            'messageTitle' => trans('globals.success_alert_title'),
            'message' => trans('globals.success_procces'),
            'messageIcon' => 'glyphicon glyphicon-ok-circle',
        ]);

        return redirect()->route('cities.index');
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
        $city = Cities::withTrashed()->where('id', $id)->first();
        if (!$city) {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.city_not_exist'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);

            return redirect()->to('cities');
        }
        return view('cities.create', compact('edit', 'city'));
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

        $city = Cities::withTrashed()->where('id', $id)->first();
        $city->name = $request->get('name');
        $city->save();

        \Utility::setMessage([
            'messageTitle' => trans('globals.success_alert_title'),
            'message' => trans('globals.success_procces'),
            'messageIcon' => 'glyphicon glyphicon-ok-circle',
        ]);
        return redirect()->route('cities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $city = Cities::find($id);
        $city->delete();
        \Utility::setMessage([
            'messageTitle' => trans('globals.success_alert_title'),
            'message' => trans('globals.success_procces'),
            'messageIcon' => 'glyphicon glyphicon-ok-circle',
        ]);
        return redirect()->route('cities.index');
    }

    public function search(Request $request) {
        $q = trim($request->get('q'));
        $data = [];

        $query = Cities::select(['id', 'name']);

        if ($q != '') {
            $query->whereRaw("name like '%" . $q . "%'");
        }

        $cities = $query->orderBy('name', 'asc')->get();

        $cities->each(function ($item, $key) use (&$data) {
            $data[] = ['id' => $item->id, 'text' => $item->name];
        });

        return json_encode($data);
    }

    /**
     * Change status to city
     */
    public function changeStatus($id,$status) {

        $city = Cities::withTrashed()->where('id', $id)->first();
        if ($city) {

            switch ($status) {
                case 'active':
                    //Inactivas
                    $deleted_at = \Carbon\Carbon::now();
                    $city->status = 'inactive';

                    $city->deleted_at = $deleted_at->toDateTimeString();
                    $city->save();
                    break;
                case 'inactive':
                case 'delete':
                    //Activa
                    $city->deleted_at = null;
                    $city->status = 'active';
                    $city->save();  
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
                'message' => trans('validation.city_not_exist'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);
        }
        return redirect()->to('/cities');
    }
}
