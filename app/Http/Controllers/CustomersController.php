<?php

namespace App\Http\Controllers;

use App\Banks;
use App\Cities;
use App\Customer;
use App\Document;
use App\Helpers\File;
use App\Installment;
use App\Loan;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class CustomersController extends Controller {
    public function __construct() {
        if (\Auth::check() && \Auth::user()->role != 'admin') {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.not_section_allow'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);

            \Redirect::to('home')->send();
        }
    }

    private function rules($id = '') {
        return [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'birth_date' => 'required|date',
            'cellphone_number' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $data = [];
        $customers = Customer::withTrashed()
            ->with(['user','bank','loans'])
            ->get();

        $customers->each(function ($item, $key) use (&$data)
        {
            $balance_pending = 0;
            //Saldo deudor en creditos
            $item->loans->each(function ($loan, $k) use (&$balance_pending) 
            {
                $installs_pending = Installment::select(['total_amount', 'expired_date'])
                    ->where('loan_id', $loan->id)
                    ->where('status', '!=', 'paid')
                    ->orderBy('expired_date', 'asc')
                    ->get();
                $balance_pending+=$installs_pending->sum('total_amount');
            });

            $data[$item->user_id]['user_id'] = $item->user->id;
            $data[$item->user_id]['identification'] = $item->user->identification;
            $data[$item->user_id]['full_name'] = $item->user->fullName;
            $data[$item->user_id]['cellphone_number'] = $item->user->cellphone_number;
            $data[$item->user_id]['balance'] = $balance_pending;
            $data[$item->user_id]['status'] = $item->user->status;
        });
        
        return view('customers.grid', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $gender = trans('globals.gender');
        $banks = Banks::orderBy('name')->lists('name', 'id');
        $cities = Cities::orderBy('name')->lists('name', 'id');
        $medellin = Cities::select('id')->where('name', 'LIKE', '%medellin%')->first();
        $contract_type = trans('globals.contract_type');
        $document_type = trans('globals.document_type');
        $affiliation_type = trans('globals.affiliation_type');
        $references_type = trans('globals.reference_type');
        $relationships = trans('globals.relationship');
        $eps = trans('globals.eps');
        $status = trans('globals.status');
        $step = 1;
        $edit = false;
        return view('customers.create', compact('gender', 'banks', 'cities', 'medellin', 'contract_type', 'document_type', 'affiliation_type', 'references_type', 'relationships', 'eps', 'status', 'edit', 'step'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules_step1 = [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'identification' => 'required|numeric',
            'birth_date' => 'required|date',
            'cellphone_number' => 'required',
            'email' => 'required|email',
        ];

        $v = \Validator::make($request->all(), $rules_step1);

        if ($v->fails()) {
            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => $v->errors()->all(),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);

            return redirect()->back()->withInput();
        }

        //Verificando que no exista el numero de identificacion
        if (User::existsIdentification($request->get('identification_type'), $request->get('identification'))->first()) {
            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.exists_identification'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);
            return redirect()->back()->withInput();
        }

        //Creamos el usuario desde el  modelo de customers
        $data['user'] = $request->all();
        $data['user']['role'] = "customer";
        $data['user']['password'] = bcrypt('123456');
        $data['card_number'] = $request->get('card_number');
        $data['card_key'] = $request->get('card_key');
        $data['city_id'] = $request->get('city_id');
        $data['company_city_id'] = $request->get('city_id');
        $data['reference_city_id'] = $request->get('city_id');
        $data['birth_date'] = Carbon::parse($request->get('birth_date'))->format('Y-m-d');
        $data['address'] = $request->get('address');
        $data['notes'] = $request->get('notes');
        $data['email'] = $request->get('email');

        $customer = Customer::create($data);

        \Utility::setMessage([
            'messageTitle' => trans('globals.success_alert_title'),
            'message' => trans('globals.success_procces'),
            'messageIcon' => 'glyphicon glyphicon-ok-circle',
        ]);

        return redirect()->route('customers.edit', [$customer->user_id, "2"]);
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
    public function edit($id, $tab, $document_id = null) {

        $customers = Customer::with(['user','bank','city'])
            ->where('user_id', $id)
            ->first();
        
        if (!$customers) {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.user_not_exist'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);

            return redirect()->to('customers');
        }

        //$loans = Loan::with('user')->where('user_id', $id)->get();
        $grid_documents = Document::where('user_id', $id)->get();
        $document = Document::find($document_id);
        $gender = trans('globals.gender');
        $banks = Banks::orderBy('name')->lists('name', 'id');
        $medellin = Cities::select('id')->where('name', 'LIKE', '%medellin%')->first();
        $cities = Cities::orderBy('name')->lists('name', 'id');
        $contract_type = trans('globals.contract_type');
        $document_type = trans('globals.document_type');
        $affiliation_type = trans('globals.affiliation_type');
        $references_type = trans('globals.reference_type');
        $relationships = trans('globals.relationship');
        $eps = trans('globals.eps');
        $status = trans('globals.status');
        $step = $tab;
        $edit = true;

        $_loans = new LoansController();
        $loans = $_loans->dataGrid($id);

        return view('customers.create', compact('customers', 'loans', 'grid_documents', 'document', 'gender', 'banks', 'cities', 'medellin', 'document_type', 'contract_type', 'affiliation_type', 'references_type', 'relationships', 'eps', 'status', 'edit', 'step'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $customer = Customer::with('user')
            ->with('bank')
            ->with('city')
            ->where('user_id', $id)
            ->first();

        $step = $request->get('step');
        $rules = [];

        switch ($step) {
        case 1:
            $rules = [
                'first_name' => 'required|alpha',
                'last_name' => 'required|alpha',
                'identification' => 'required|numeric',
                'birth_date' => 'required|date',
                'cellphone_number' => 'required',
                'email' => 'required|email',
                'photo' => 'mimes:jpeg,bmp,png',
            ];
            break;
        case 2:
            $rules = [
                'company' => 'required|alpha',
                'company_position' => 'required|alpha',
                'company_salary' => 'required|numeric',
            ];
            break;
        case 3:
            $rules = [
                'reference_identification_type' => 'required',
                'reference_identification' => 'required|numeric',
                'reference_first_name' => 'required|alpha',
                'reference_last_name' => 'required|alpha',
                'reference_cellphone' => 'required',
                'reference_address' => 'required',
            ];
            break;
        case 4:
            $rules = [
                'file' => 'required|mimes:jpeg,bmp,png,pdf',
            ];
            break;
        }

        $v = \Validator::make($request->all(), $rules);

        if ($v->fails()) {
            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => $v->errors()->all(),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);

            return redirect()->back()->withInput();
        }

        //Gestion de documentos
        if ($step == 4) {
            $fileuploaded = File::section('default')->setting(['code' => true])->upload($request->file('file'));
            if ($request->get('document_id')) {
                //update
                $document = Document::find($request->get('document_id'));
                File::deleteFile($document->document_url, true);
                $document->fill($request->all());
                $document->document_url = $fileuploaded;
                $document->save();
            } else {
                $document = Document::create([
                    'user_id' => $id,
                    'document_type' => $request->get('document_type'),
                    'document_description' => $request->get('document_description'),
                    'document_url' => $fileuploaded,
                ]);
            }
        }

        if ($step == 1) {
            $data_user = $request->except('email');
            $fileuploaded = File::section('profile_img')->setting(['code' => false])->upload($request->file('photo'));
            $data_user['pic_url'] = $fileuploaded;
            File::deleteFile($customer->user->pic_url, false);
            $customer->user->fill($data_user);
            $customer->user->save();
        }

        $customer->fill($request->all());
        $customer->user->birth_date = Carbon::parse($request->get('birth_date'))->format('Y-m-d');
        $customer->user->save();
        $customer->save();

        \Utility::setMessage([
            'messageTitle' => trans('globals.success_alert_title'),
            'message' => trans('globals.success_procces'),
            'messageIcon' => 'glyphicon glyphicon-ok-circle',
        ]);

        //Last Step
        return redirect()->route('customers.edit', [$customer->user_id, $step + (($step < 4) ? 1 : 0)]);

    }

    /**
     *   dowload file
     *   @param Resquest     file to upload
     *   @return string
     */
    public function downloadDocument($document_id) {
        $document = Document::find($document_id);
        return response()->download(storage_path() . '/files/' . $document->document_url);
    }

    /**
     *   delete file
     *   @param Resquest     file to upload
     *   @return string
     */
    public function deleteDocument($document_id) {
        $document = Document::find($document_id);
        if ($document) {
            File::deleteFile($document->document_url);
            $document->delete();

            \Utility::setMessage([
                'messageTitle' => trans('globals.success_alert_title'),
                'message' => trans('globals.success_procces'),
                'messageIcon' => 'glyphicon glyphicon-ok-circle',
            ]);
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = User::find($id);
        if ($user) {
            $deleted_at = \Carbon\Carbon::now();
            $user->status = 'delete';

            $user->deleted_at = $deleted_at->toDateTimeString();
            $user->save();

            \Utility::setMessage([
                'messageTitle' => trans('globals.success_alert_title'),
                'message' => trans('globals.success_procces'),
                'messageIcon' => 'glyphicon glyphicon-ok-circle',
            ]);
        } else {
            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.user_not_exist'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);
        }

        return redirect()->to('/customers');
    }

    /**
     * Change status to customer
     */
    public function changeStatus($id,$status) {

        $user = User::find($id);
        if ($user) {

            switch ($status) {
                case 'active':
                    //Inactivas
                    $deleted_at = \Carbon\Carbon::now();
                    $user->status = 'inactive';

                    $user->deleted_at = $deleted_at->toDateTimeString();
                    $user->save();
                    break;
                case 'inactive':
                case 'delete':
                    //Activa
                    $user->deleted_at = null;
                    $user->status = 'active';
                    $user->save();  
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
                'message' => trans('validation.user_not_exist'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);
        }
        return redirect()->to('/customers');
    }

}
