<?php

/**
 * Loans System - Loans Controller
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\InstallmentsController;
use App\Loan;
use App\User;
use App\Payment;
use App\PaymentFreq;
use App\Installment;
use App\Surcharge;
use Carbon\Carbon;

class LoansController extends Controller
{

    public function __construct()
    {
        if (\Auth::check() && \Auth::user()->role != 'admin') {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.not_section_allow'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);

            return redirect()->to('loans');
        }
    }

    private function rules($id = '')
    {
        return [
            'user' => 'required',
            'amount' => "required|regex:/^\d*(\.\d{1,2})?$/",
            'interest_rate' => 'required',
            'payment_freq' => 'required',
            'installments' => 'required',
            'first_payment' => 'required|date',
            'penalty_rate' => 'required'
        ];
    }

    public function index()
    {
        $data = $this->dataGrid();

        return view('loans.grid', compact('loans', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edit = false;
        $payments_freq = PaymentFreq::select(['id', 'description'])->where('status', 'active')->get();

        foreach ($payments_freq as $value) {
            $paymentsFreq[$value->id] = ucfirst($value->description);
        }

        return view('loans.create', compact('edit', 'paymentsFreq'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        $loan = Loan::create([
            'user_id' => $request->get('user'),
            'amount' => $request->get('amount'),
            'interest_rate' => $request->get('interest_rate'),
            'payment_freq_id' => $request->get('payment_freq'),
            'installments' => $request->get('installments'),
            'first_payment' => Carbon::parse($request->get('first_payment'))->format('Y-m-d'),
            'penalty_rate' => $request->get('penalty_rate')
        ]);

        $install = new InstallmentsController();

        $install->store(new Request([
            'loan_id' => $loan->id,
            'installments' => $loan->installments,
            'amount' => $loan->amount,
            'interest_rate' => $loan->interest_rate,
            'payment_freq_id' => $loan->payment_freq_id,
            'first_payment' => $loan->first_payment
        ]));

        \Utility::setMessage([
            'messageTitle' => trans('globals.success_alert_title'),
            'message' => trans('globals.success_procces'),
            'messageIcon' => 'glyphicon glyphicon-ok-circle'
        ]);

        return redirect()->to('/loans');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        if (!$this->canEdit($id)) {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.not_section_allow'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);

            return redirect()->to('loans');
        }

        $edit = true;

        $loan = Loan::with(['user', '_installments'])->where('id', $id)->first();

        if (!$loan) {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.not_section_allow'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);

            return redirect()->to('loans');
        }

        $payments_freq = PaymentFreq::select(['id', 'description'])->where('status', 'active')->get();

        foreach ($payments_freq as $value) {
            $paymentsFreq[$value->id] = ucfirst($value->description);
        }

        foreach (array_keys(trans('globals.loans_payment_status')) as $value) {
            $status[$value] = ucfirst($value);
        }

        $surcharges = Surcharge::with('user')->where('status', '!=', 'rejected')->where('loan_id', $id)->get();

        return view('loans.create', compact('loan', 'paymentsFreq', 'edit', 'status', 'surcharges'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$this->canEdit($id)) {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.not_section_allow'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);

            return redirect()->to('loans');
        }

        $v = \Validator::make($request->all(), $this->rules());

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $loan = Loan::with(['user', '_installments'])->where('id', $id)->first();
        $install = new InstallmentsController();

        if ($loan) {
            //Verify Payments active
            $payments = Payment::where('loan_id', $id)->where('status', 'active')->get();
            $first_payment = Carbon::parse($request->get('first_payment'))->format('Y-m-d');

            $loan->amount = $request->get('amount');
            $loan->interest_rate = $request->get('interest_rate');
            $loan->payment_freq_id = $request->get('payment_freq');
            $loan->installments = $request->get('installments');
            $loan->first_payment = $first_payment;
            $loan->penalty_rate = $request->get('penalty_rate');
            $loan->status = $request->get('status');
            
            //Adjust date payment in installments
            if (($payments) && ($loan->status == 'process')) {
                //Validate date from first payment
                $installments = Installment::with('payments')
                    ->where('loan_id', $id)
                    ->where('status', 'pending')
                    ->orderBy('expired_date', 'asc')
                    ->get();

                if ($first_payment < $installments->first()->expired_date) { 

                    \Utility::setMessage([
                        'messageTitle' => trans('globals.error_alert_title'),
                        'message' => trans('validation.first_payment_error'),
                        'messageIcon' => 'glyphicon glyphicon-remove-circle',
                        'messageClass' => 'error'
                    ]);

                    return redirect()->back()->withInput();

                } else {
                    //Process update
                    $loan->save();

                    $paymentFreq = PaymentFreq::select(['days'])->where('id', $request->get('payment_freq'))->first();

                    $date = \Utility::getValDate($request->get('first_payment'), $holyday);

                    //recorrido de cada installment
                    $installments->each(function($item) use (&$date, &$holyday, $paymentFreq) {

                        $item->holyday_id = ($holyday) ? $holyday : 0;
                        $item->expired_date = $date;
                        $item->save();
                        $date = strtotime("+".$paymentFreq->days." day", strtotime($date));
                        $date = \Utility::getValDate(date('Y-m-d',$date), $holyday);

                    });

                    \Utility::setMessage([
                        'messageTitle' => trans('globals.success_alert_title'),
                        'message' => trans('globals.success_procces'),
                        'messageIcon' => 'glyphicon glyphicon-ok-circle'
                    ]);
                }
            } else {

                $loan->save();
                
                $install->store(new Request([
                    'loan_id' => $loan->id,
                    'installments' => $loan->installments,
                    'amount' => $loan->amount,
                    'interest_rate' => $loan->interest_rate,
                    'payment_freq_id' => $loan->payment_freq_id,
                    'first_payment' => $loan->first_payment
                ]));

                \Utility::setMessage([
                    'messageTitle' => trans('globals.success_alert_title'),
                    'message' => trans('globals.success_procces'),
                    'messageIcon' => 'glyphicon glyphicon-ok-circle'
                ]);
            }   
        } else {
            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.not_section_allow'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);
        }

       return redirect()->to('/loans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeStauts(Request $request, $loan_id, $status)
    {
        if ($request->user()->hasrole(['admin', 'supervisor']))
        {
            $loan = Loan::select('id')->where('id', $loan_id)->update(['status' => $status]);

            /**
             * $surcharges
             *
             * Controls the loan surcharges dependencies status updates
             *
             * @var App\Surcharge
             */
            $surcharges = Surcharge::with('payments')->where('loan_id', $loan_id)->get();

            $surcharges->each(function($item) use ($status) {

                if ($item->payments->count() > 0) {

                    $item->payments->each(function($p) use ($status) {
                        $p->status = $status == 'rejected' ? 'inactive' : 'active';
                        $p->save();
                    });

                    $item->status = $status == 'rejected' ? 'rejected' : 'paid';
                    $item->save();

                }

            });

            /**
             * $installments
             *
             * Controls the loan installments dependencies status updates
             *
             * @var App\Installment
             */
            $installments = Installment::with('payments')->where('loan_id', $loan_id)->get();

            $installments->each(function($item) use ($status) {

                if ($item->payments->count() > 0) {

                    $item->payments->each(function($p) use ($status) {
                        $p->status = $status == 'rejected' ? 'inactive' : 'active';
                        $p->save();
                    });
                    $item->status = $status == 'rejected' ? 'rejected' : 'paid';

                } else {

                    $item->status = $status == 'rejected' ? 'rejected' : 'pending';

                }

                $item->save();

            });

            \Utility::setMessage([
                'messageTitle' => trans('globals.success_alert_title'),
                'message' => trans('globals.success_procces'),
                'messageIcon' => 'glyphicon glyphicon-ok-circle'
            ]);

        } else {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('globals.problem_processing_the_request'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);
        }

        \Redirect::to('loans')->send();
    }

    private function canEdit($loan_id)
    {
        $payments = Payment::select('id')
        ->where([

            'loan_id' => $loan_id,
            'concept' => 'other',
            'status' => 'active'

        ])->whereNull('installment_id')->whereNull('surcharge_id')->get();

        return $payments->count() == 0 ? true : false;
    }

    public function dataGrid($user_id = '')
    {
        $data = [];

        $loans = Loan::with(['user', 'paymentFreq'])->FromUser($user_id)->get();

        $loans->each(function ($item, $key) use (&$data)
        {
            $install = Installment::select(['total_amount', 'expired_date'])
                ->where('loan_id', $item->id)
                ->where('status', '!=', 'paid')
                ->orderBy('expired_date', 'asc')
                ->get();

            $data[$item->id]['id'] = $item->id;
            $data[$item->id]['role'] = $item->user->role;
            $data[$item->id]['user_id'] = $item->user->id;
            $data[$item->id]['user'] = $item->user->fullName;
            $data[$item->id]['amount'] = $item->amount;
            $data[$item->id]['balance'] = ($install) ? $install->sum('total_amount') : '';
            $data[$item->id]['interest_rate'] = $item->interest_rate;
            $data[$item->id]['frequency'] = $item->paymentFreq->description;
            $data[$item->id]['first_payment'] = $item->first_payment;
            $data[$item->id]['next_payment'] = ($install->count() > 0) ? $install->first()->expired_date : '';
            $data[$item->id]['status'] = $item->status;
            $data[$item->id]['canEdit'] = $this->canEdit($item->id);
        });

        return $data;
    }

}
