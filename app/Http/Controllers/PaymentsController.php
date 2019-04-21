<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Payment;
use App\User;
use App\Loan;
use App\Installment;
use App\Surcharge;
use App\Helpers\Utility;
use Carbon\Carbon;

class PaymentsController extends Controller
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

            \Redirect::to('payments')->send();
        }
    }

    private function rules($edit = false)
    {
        $data = [
            'paymentAmount' => 'required',
            'concept' => 'required',
            'paymentMethod' => 'required',
        ];

        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $balance = 0;
        $payments = Payment::with(['user', 'loan'])->where('status', 'active')->orderBy('created_at', 'desc')->get();

        $payments->each(function($payment, $key) use (&$data, &$balance){

            $installments = Installment::select(['id', 'total_amount'])->where('loan_id', $payment->loan->id)->get();

            if ($installments->count() > 0) {
                $installments->each(function($install) use (&$balance){
                    $balance += $install->total_amount;
                });
            }

            $data[$key]['id'] = $payment->id;
            $data[$key]['loan_id'] = $payment->loan->id;
            $data[$key]['user'] = $payment->user->fullName;
            $data[$key]['loan_amount'] = $payment->loan->amount;
            $data[$key]['balance'] = $balance;
            $data[$key]['created_at'] = $payment->created_at;
            $data[$key]['payment_amount'] = $payment->payment;
            $data[$key]['method'] = $payment->method;
            $data[$key]['type'] = $payment->type;
            $data[$key]['concept'] = $payment->concept;
            $data[$key]['installment_id'] = $payment->installment_id;
            $balance = 0;
            unset($installments);
        });

        return view('payments.grid', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($loan_id)
    {
        $loan = Loan::with('user')->with(['_installments' => function ($query){
            $query->orderBy('expired_date');
        }])->where('id', $loan_id)->first();

        $surcharges = Surcharge::select('id', 'concept', 'amount')->where([
            'loan_id' => $loan->id,
            'status' => 'pending'
        ])->get();

        $edit = false;

        $_interet =  isset($loan) ? ($loan->amount * $loan->interest_rate / 100) : 0;

        $_loans_amount = isset($loan) ? $loan->amount + $_interet : 0;

        return view('payments.create', compact('loan', 'edit', '_interet', '_loans_amount', '_payments', 'surcharges'));
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

        /**
         * $loan
         *
         * Contains the loan information requested by the user
         *
         * @var App\Loan
         */
        $loan = Loan::select(['id', 'user_id'])->with('user')->with(['_installments' => function($query) use ($request)
        {

            return $query->where('id', $request->get('selected_install'));

        }, 'surcharges' => function($query) use ($request){

            return $query->where('id', $request->get('surcharges'));

        }])->where('id', $request->get('loan_id'))->first();

        //validating loan request information
        if (!$loan || $loan == null) {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('loans.loan_not_valid'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);

            return redirect()->back()->withInput();
        }

        /**
         * $payment_type_error
         *
         * Verify id the amount sent is valid checking at loan installment information
         *
         * @var boolean
         */
        $payment_type_error = false;

        $tmp_amount = '';

        switch ($request->get('payment_type')) {
            case 'capital':
                if ($loan->_installments->count() > 0 && \Utility::numberFormat($request->get('paymentAmount')) != $loan->_installments[0]->amount) {
                    $payment_type_error = true;
                    $tmp_amount = $loan->_installments[0]->amount;
                }
            break;
            case 'interest':
                if ($loan->_installments->count() > 0 && \Utility::numberFormat($request->get('paymentAmount')) != $loan->_installments[0]->interest_amount) {
                    $payment_type_error = true;
                    $tmp_amount = $loan->_installments[0]->interest_amount;
                }
            break;
            case 'installment':
                if ($loan->_installments->count() > 0 && \Utility::numberFormat($request->get('paymentAmount')) != $loan->_installments[0]->total_amount) {
                    $payment_type_error = true;
                    $tmp_amount = $loan->_installments[0]->total_amount;
                }
            break;
        }

        if ($payment_type_error) {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('loans.payment_amount_not_valid', ['one' => \Utility::numberFormat($tmp_amount, false), 'two' => $request->get('paymentAmount')]),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);

            return redirect()->back()->withInput();
        }

        // Payment Body
        $payment = Payment::create([
            'user_id' => $loan->user_id,
            'debt_collector_id' => trim($request->get('debt_collector')) != '' ? $request->get('debt_collector') : \Auth::user()->id,
            'loan_id' => $loan->id,
            'installment_id' => $loan->_installments->count() > 0 ? $loan->_installments[0]->id : null,
            'surcharge_id' => $loan->surcharges->count() > 0 ? $loan->surcharges[0]->id : null,
            'method' => $request->get('paymentMethod'),
            'type' => trim($request->get('payment_type')) != '' ? $request->get('payment_type') : 'other',
            'concept' => $request->get('concept'),
            'payment' => Utility::numberFormat($request->get('paymentAmount')),
            'penalty_amount' => $request->get('penaltyRateCheck') ? Utility::numberFormat($request->get('penaltyRate')) : 0,
            'notes' => $request->get('paymentNotes')
        ]);

        $loan->status = 'process';
        $loan->save();

        // ----- Payment Details 

        //(Total fee payment) (Installment)
        if ($loan->_installments->count() > 0 && \Utility::numberFormat($request->get('paymentAmount')) == $loan->_installments[0]->total_amount) {

            $loan->_installments[0]->status = 'paid';
            $loan->_installments[0]->save();

        } elseif ($loan->_installments->count() > 0 && \Utility::numberFormat($request->get('paymentAmount')) != $loan->_installments[0]->total_amount){

            //Check if you had already made payments for "Capital" or "Interest"
            $payments = Payment::where('installment_id', $loan->_installments[0]->id)->get();
            if ($payments) {
                if (($payments->contains('type', 'capital') && $request->get('payment_type') == 'interest')  || ($payments->contains('type', 'interest') && $request->get('payment_type') == 'capital')) {
                    $loan->_installments[0]->status = 'paid';
                } else {
                    $loan->_installments[0]->status = 'process';
                }
            } else {
                $loan->_installments[0]->status = 'process';
            }
            $loan->_installments[0]->save();
        }

        if ($loan->surcharges->count() > 0) {
            $loan->surcharges[0]->status = 'paid'; 
            $loan->surcharges[0]->save();
        }

        //Verify if all installments is PAID
        $loan = Loan::with('_installments')->where('id', $request->get('loan_id'))->first();
        if ((!$loan->_installments->contains('status','pending')) && (!$loan->_installments->contains('status','reject')) && (!$loan->_installments->contains('status','process'))) {
            $loan->status = 'paid';
            $loan->save();
        } 

        \Utility::setMessage([
            'messageTitle' => trans('globals.success_alert_title'),
            'message' => trans('globals.success_procces'),
            'messageIcon' => 'glyphicon glyphicon-ok-circle'
        ]);

        return redirect()->to('/payments');
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
        $edit = true;

        $payment = Payment::with('debt_collector')->where('id', $id)->first();

        $surcharges = Surcharge::select('id', 'concept', 'amount')->where([
            'loan_id' => $payment->loan_id,
            'status' => 'pending'
        ])->get();

        $loan = Loan::with('user')->with(['_installments' => function ($query){
            $query->orderBy('expired_date');
        }])->where('id', $payment->loan_id)->first();

        $_interet =  isset($loan) ? ($loan->amount * $loan->interest_rate / 100) : 0;

        $_loans_amount = isset($loan) ? $loan->amount + $_interet : 0;

        /**
         * $hasPenalty
         *
         * Checking payments penalties fee
         *
         * @var array
         */

        $penaltyAmount = 0;

        if ($payment->penalty_amount == 0 && $payment->installment_id != '') {

            $penalty = Loan::select('id', 'penalty_rate')->with(['_installments' => function($query) use ($payment)
            {

                return $query->where('id', $payment->installment_id);

            }])->first();

            $install = $penalty->_installments->first();

            if ($install && time() > strtotime($install->expired_date)) {
                $penaltyAmount = ceil($install->interest_amount * $penalty->penalty_rate / 100) + $install->interest_amount;
            }
        }

        return view('payments.create', compact('payment', 'loan', 'edit', '_interet', '_loans_amount', 'surcharges', 'penaltyAmount'));
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
        $v = \Validator::make($request->all(), $this->rules(true));

        if ($v->fails()) {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => $v->errors()->all(),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);

            return redirect()->back()->withInput();
        }

        /**
         * $payment
         *
         * Contains the payment information requested by the user
         *
         * @var App\Payment
         */
        $payment = Payment::where('id', $id)->first();

        /**
         * $loan
         *
         * Contains the loan information requested by the user
         *
         * @var App\Loan
         */
        $loan = Loan::select(['id', 'user_id'])->with('user')->with(['_installments' => function($query) use ($request)
        {

            return $query->where('id', $request->get('selected_install'));

        }])->where('id', $payment->loan_id)->first();

        //validating loan request information
        if (!$loan || $loan == null) {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('loans.loan_not_valid'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);

            return redirect()->back()->withInput();
        }

        /**
         * $payment_type_error
         *
         * Verify id the amount sent is valid checking at loan installment information
         *
         * @var boolean
         */
        $payment_type_error = false;

        $tmp_amount = '';

        switch ($request->get('payment_type')) {
            case 'capital':
                if ($loan->_installments->count() > 0 && \Utility::numberFormat($request->get('paymentAmount')) != $loan->_installments[0]->amount) {
                    $payment_type_error = true;
                    $tmp_amount = $loan->_installments[0]->amount;
                }
            break;
            case 'interest':
                if ($loan->_installments->count() > 0 && \Utility::numberFormat($request->get('paymentAmount')) != $loan->_installments[0]->interest_amount) {
                    $payment_type_error = true;
                    $tmp_amount = $loan->_installments[0]->interest_amount;
                }
            break;
            case 'installment':
                if ($loan->_installments->count() > 0 && \Utility::numberFormat($request->get('paymentAmount')) != $loan->_installments[0]->total_amount) {
                    $payment_type_error = true;
                    $tmp_amount = $loan->_installments[0]->total_amount;
                }
            break;
        }

        if ($payment_type_error) {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('loans.payment_amount_not_valid', ['one' => \Utility::numberFormat($tmp_amount, false), 'two' => $request->get('paymentAmount')]),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);

            return redirect()->back()->withInput();
        }

        // Payment Body
        $payment->update([
            'user_id' => $loan->user_id,
            'debt_collector_id' => trim($request->get('debt_collector')) != '' ? $request->get('debt_collector') : $payment->debt_collector_id,
            'loan_id' => $loan->id,
            'installment_id' => $loan->_installments->count() > 0 ? $loan->_installments[0]->id : null,
            'method' => $request->get('paymentMethod'),
            'type' => trim($request->get('payment_type')) != '' ? $request->get('payment_type') : 'other',
            'concept' => $request->get('concept'),
            'payment' => Utility::numberFormat($request->get('paymentAmount')),
            'penalty_amount' => $request->get('penaltyRateCheck') ? Utility::numberFormat($request->get('penaltyRate')) : 0,
            'notes' => $request->get('paymentNotes')
        ]);

        // ----- Payment Details 

        //(Total fee payment) (Installment)
        if ($loan->_installments->count() > 0 && \Utility::numberFormat($request->get('paymentAmount')) == $loan->_installments[0]->total_amount) {

            $loan->_installments[0]->status = 'paid';
            $loan->_installments[0]->save();

        } elseif ($loan->_installments->count() > 0 && \Utility::numberFormat($request->get('paymentAmount')) != $loan->_installments[0]->total_amount){

            //Check if you had already made payments for "Capital" or "Interest"
            $payments = Payment::where('installment_id', $loan->_installments[0]->id)->get();
            if ($payments) {
                if (($payments->contains('type', 'capital') && $request->get('payment_type') == 'interest')  || ($payments->contains('type', 'interest') && $request->get('payment_type') == 'capital')) {
                    $loan->_installments[0]->status = 'paid';
                } else {
                    $loan->_installments[0]->status = 'process';
                }
            } else {
                $loan->_installments[0]->status = 'process';
            }
            $loan->_installments[0]->save();
        }

        \Utility::setMessage([
            'messageTitle' => trans('globals.success_alert_title'),
            'message' => trans('globals.success_procces'),
            'messageIcon' => 'glyphicon glyphicon-ok-circle'
        ]);

        return redirect()->to('/payments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $payment = Payment::select('id', 'loan_id', 'installment_id', 'surcharge_id', 'concept')
            ->where('id', $id)
            ->first();

        if ($request->user()->hasrole(['admin', 'supervisor']) && $payment)
        {

            $loan_id = $payment->loan_id;

            switch ($payment->concept) {

                case 'payment':
                    Installment::where('id', $payment->installment_id)->update(['status' => 'pending']);
                break;

                case 'surcharge':
                    Surcharge::where('id', $payment->surcharge_id)->update(['status' => 'pending']);
                break;
            }

            $payment->delete();

            $v = Payment::select('loan_id')->where('loan_id', $loan_id)->get();

            if ($v->count() == 0) {

                Loan::where('id', $loan_id)->update(['status' => 'pending']);

            }

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

        return redirect('/payments');
    }

    public function paymentSummary(Request $request)
    {
        $loan = Loan::where('id', $request->get('loan_id'));

        $install = Installment::select('id', 'amount', 'interest_amount', 'total_amount')->where('id', $request->get('selected_install'))->first();

        if ($loan && $install) {

            $hidden = [];
            $payments = Payment::where('installment_id', $install->id)->get();

            $data['out'] = 'ok';

            if (!$payments->contains('type', 'capital') || $request->get('edit')) {
                $data['capital'] =  Utility::numberFormat($install->amount, false);
                $data['_capital'] =  $install->amount;
            }

            if (!$payments->contains('type', 'interest') || $request->get('edit')) {
                $data['interest'] = Utility::numberFormat($install->interest_amount, false);
                $data['_interest'] = $install->interest_amount;
            }

            //Installment amount would be add if there is not payments to "capital" or "interest"
            if ( (!$payments->contains('type', 'installment') && !$payments->contains('type', 'capital') && !$payments->contains('type', 'interest')  ) || $request->get('edit')) {
                $data['installment'] = Utility::numberFormat($install->total_amount, false);
                $data['_installment'] = $install->total_amount;
            }

        } else {
            $data['out'] = 'notOk';
        }

        return json_encode($data);
    }

    public function penaltyRate(Request $request)
    {
        $data['hasPenalty'] = 'no';

        if (trim($request->get('selected_install')) != '') {

            $loan = Loan::select('id', 'penalty_rate')->with(['_installments' => function($query) use ($request)
            {

                return $query->where('id', $request->get('selected_install'));

            }])->first();

            $install = $loan->_installments->first();

            if ($install && time() > strtotime($install->expired_date)) {
                $data['hasPenalty'] = 'yes';
                $data['penalty_amount'] = ceil($install->interest_amount * $loan->penalty_rate / 100) + $install->interest_amount;
            }

        }

        return json_encode($data);
    }

    private function headerEdit($payment_id, &$payment, &$loan, &$installments, &$user)
    {
        $payment = Payment::where('id', $payment_id)->first();
        $loan = Loan::where('id', $payment->loan_id)->first();
        $installments = Installment::where('loan_id', $loan->id)->orderBy('status')->get();
        $user = User::select(['id', 'first_name', 'last_name'])->where('id', $loan->user_id)->first();
    }

}
