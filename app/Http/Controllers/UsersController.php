<?php

/**
 * Loans System - Users Controller
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

namespace App\Http\Controllers;

use App\Helpers\File;
use App\Http\Controllers\Controller;
use App\User;
use App\Loan;
use App\Installment;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use Hash;

class UsersController extends Controller {

    public function __construct() {

    }

    private function rules($id = '', $key = '') {
        $rules = [
            'username' => 'required|alpha|unique:users,username,'.$id,
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'birth_date' => 'required|date',
            'cellphone_number' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'photo' => 'mimes:jpeg,bmp,png',
        ];
        //Si no hay clave, es nuevo registro
        if (!$key) array_push($rules, ['password' => 'required']);
        return $rules;
    }

    public function index() {
        //$users = User::where('status', '!=', 'delete')->where('role', '!=', 'customer')->get();

        $data = [];
        $users = User::with(['loans'])
            ->where('role', '!=', 'customer')
            ->get();

        $users->each(function ($item, $key) use (&$data)
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

            $data[$item->id]['id'] = $item->id;
            $data[$item->id]['identification'] = $item->identification;
            $data[$item->id]['full_name'] = $item->fullName;
            $data[$item->id]['age'] = $item->age;
            $data[$item->id]['cellphone_number'] = $item->cellphone_number;
            $data[$item->id]['homephone_number'] = $item->homephone_number;
            $data[$item->id]['balance'] = $balance_pending;
            $data[$item->id]['status'] = $item->status;
        });
        return view('employees.grid', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $edit = false;
        $this->dropDownLists($gender, $verified, $status, $roles);
        return view('employees.create', compact('gender', 'verified', 'status', 'roles', 'edit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $v = \Validator::make($request->all(), $this->rules());

        if ($v->fails()) {
            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => $v->errors()->all(),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);

            return redirect()->back()->withInput();
        }

        if ($this->existsIdentification($request->get('identification_type'), $request->get('identification'))) {
            \Utility::setMessage(['message' => trans('validation.exists_identification')]);
            return redirect()->back()->withInput();
        }

        $data = $request->except([
            'language',
            'remember_token',
            'updated_at',
            'disabled_at',
            'deleted_at',

        ]);

        $data['birth_date'] = Carbon::parse($request->get('birth_date'))->format('Y-m-d');

        User::create($data);

        \Utility::setMessage([
            'messageTitle' => trans('globals.success_alert_title'),
            'message' => trans('globals.success_procces'),
            'messageIcon' => 'glyphicon glyphicon-ok-circle',
        ]);

        return redirect()->to('/employees');
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
    public function edit($id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.not_section_allow'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);

            return redirect()->to('employees');
        }

        $edit = true;

        $this->dropDownLists($gender, $verified, $status, $roles);

        $_loans = new LoansController();

        $loans = $_loans->dataGrid();

        return view('employees.create', compact('user', 'gender', 'verified', 'status', 'roles', 'edit', 'loans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $v = \Validator::make($request->all(), $this->rules($id, $request->get('key')));

        if ($v->fails()) {
            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => $v->errors()->all(),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);

            return redirect()->back()->withInput();
        }

        if ($this->existsIdentification($request->get('identification_type'), $request->get('identification'), $id)) {
            \Utility::setMessage(['message' => trans('validation.exists_identification')]);
            return redirect()->back()->withInput();
        }

        $data = $request->except([
            'language',
            'remember_token',
            'disabled_at',
            'deleted_at',
        ]);

        $user = User::where('id', $id)->first();

        if ($user) {

            $data['birth_date'] = Carbon::parse($request->get('birth_date'))->format('Y-m-d');
            if ($request->get('password')) $data['password'] = \Hash::make($request->get('password'));

            //Upload image
            if ($request->file('photo')) {
                $fileuploaded = File::section('profile_img')->setting(['code' => false])->upload($request->file('photo'));
                $data['pic_url'] = $fileuploaded;
                File::deleteFile($user->pic_url, false);
            }
            $user->update($data);

            \Utility::setMessage([
                'messageTitle' => trans('globals.success_alert_title'),
                'message' => trans('globals.success_procces'),
                'messageIcon' => 'glyphicon glyphicon-ok-circle',
            ]);
        } else {
            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.not_section_allow'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);
        }

        return redirect()->to(($request->get('isprofile')) ? 'home':'employees');

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
                'message' => trans('validation.not_section_allow'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);
        }

        return redirect()->to('/employees');
    }

    /**
     * Change status to user
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
        return redirect()->to('/employees');
    }

    /**
     * Get information for edit profile
     */
    public function profile() {

        $user = User::where('id', \Auth::user()->id)->first();

        if (!$user) {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.not_section_allow'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);

            return redirect()->to('home');
        }
        
        $edit = true;
        $profile = true;
        $this->dropDownLists($gender, $verified, $status, $roles);
        return view('employees.create', compact('user', 'gender', 'verified', 'status', 'roles', 'edit', 'profile'));
    }

    private function dropDownLists(&$gender, &$verified, &$status, &$roles) {
        foreach (array_keys(trans('globals.gender')) as $value) {
            $gender[$value] = ucfirst($value);
        }

        foreach (array_keys(trans('globals.verification')) as $value) {
            $verified[$value] = ucfirst($value);
        }

        foreach (array_keys(trans('globals.type_status')) as $value) {
            $status[$value] = ucfirst($value);
        }

        foreach (array_keys(trans('globals.roles')) as $value) {
            $roles[$value] = ucfirst($value);
        }
    }

    /**
     * existsIdentification
     *
     * checking Identification numbers in the table, in order to guarantee its unique value
     *
     * @param  [string] $type Identification type
     * @param  [string] $iden Identification string
     * @param  [string] $id User id in md5 format
     * @return boolean]
     */
    private function existsIdentification($type, $iden, $id = '') {
        $query = User::select(['id'])
            ->where('identification_type', $type)
            ->where('identification', $iden)
            ->where(function ($query) use ($id) {
                if ($id != '') {
                    $query->whereRaw("id != '" . $id . "'");
                }
            })
            ->get();

        return count($query) == 0 ? false : true;
    }

    public function search(Request $request) {
        $q = trim($request->get('q'));
        $data = [];

        $users = User::select(['id', 'first_name', 'last_name'])
        ->where('verified', 'yes')
        ->where('status', 'active')
        ->where('role', '!=', 'admin');

        if ($q != '') {
            $users->whereRaw("CONCAT (first_name, ' ', last_name) like '%" . $q . "%'");
        }

        $users = $users->get();

        $users->each(function ($item, $key) use (&$data) {
            $data[] = ['id' => $item->id, 'text' => $item->first_name . ' ' . $item->last_name];
        });

        return json_encode($data);
    }

    public function byLoans(Request $request) {
        $q = trim($request->get('q'));
        $data = [];

        $users = Loan::has('installments')->with(['user' => function ($query) use ($q){
            $query->select(['id', 'first_name', 'last_name']);
            $query->where('verified', 'yes');
            $query->where('status', 'active');
            $query->where('role', '!=', 'admin');
            if ($q != '') {
                $query->whereRaw("CONCAT (first_name, ' ', last_name) like '%" . $q . "%'");
            }
            return $query;
        }])->where('status', '!=', 'paid')->groupBy('user_id')->get();

        $users->each(function ($item, $key) use (&$data) {
            if ($item->user)
                $data[] = ['id' => $item->user->id, 'text' => $item->user->first_name . ' ' . $item->user->last_name];
        });

        return json_encode($data);
    }
}
