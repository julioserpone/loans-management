<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Installment;
use App\Loan;
use Carbon\Carbon;
use App\PaymentFreq;
use Debugbar;

class InstallmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $installments = $request->get('installments') > 0 ? $request->get('installments') : 1;

        $amount = ceil( $request->get('amount') / $installments );

        $interest = ceil($request->get('amount') * $request->get('interest_rate') / 100);

        $paymentFreq = PaymentFreq::select(['days'])->where('id', $request->get('payment_freq_id'))->first();

        //deleting loan installments
        Installment::where('loan_id', $request->get('loan_id'))->delete();

        //Installment due date
        $date = \Utility::getValDate($request->get('first_payment'), $holyday);

        for ($i = 1; $i <= $installments; $i++)
        {
            Installment::create([
                'loan_id' => $request->get('loan_id'),
                'holyday_id' => ($holyday) ? $holyday : 0,
                'installment_num' => $i,
                'status' => 'pending',
                'expired_date' => $date,
                'amount' => $amount,
                'interest_amount' => ceil($interest / $installments),
                'total_amount' => $amount + ceil($interest / $installments)
            ]);

            //Installment due date
            $date = strtotime("+".$paymentFreq->days." day", strtotime($date));
            $date = \Utility::getValDate(date('Y-m-d',$date), $holyday);
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $install = Installment::with('loan')->find($id);

        if (isset($install) && $install->status != 'paid' && $install->status != 'onhold' && $install->loan->installments > 1) {

            $installments_count = $install->loan->installments - 1;
            $loan_id = $install->loan->id;
            $installments = $install->loan->_installments()
                ->where('status', '!=', 'paid')
                ->where('status', '!=', 'onhold')
                ->where('id', '!=', $id)
                ->orderBy('installment_num', 'asc')->get();

            $amount = ceil($install->loan->amount / $installments_count);
            $interest = ceil(($install->loan->amount * $install->loan->interest_rate) / 100) / $installments_count;
            $payment_freq = $install->loan->paymentFreq()->first();
            $date = new Carbon($install->expired_date);
            $installment_num = $install->installment_num;

            foreach ($installments as $installment) {
 
                //ajuste de monto en cuotas
                if ($installment->installment_num > $installment_num) {
                    $installment->installment_num = $installment_num;
                    $installment_num++;
                }
                $installment->expired_date = $date;
                $installment->amount =  $amount;
                $installment->interest_amount = $interest;
                $installment->total_amount = $amount + $interest;
                $installment->save();
                
                $date = $date->addDays($payment_freq->days);
            }

            $install->loan->update(['installments' => $installments_count]);
            $install->delete();

            //Verify if all installments is status PAID
            $loan = Loan::with('_installments')->where('id', $loan_id)->first();

            if ((!$loan->_installments->contains('status','pending')) && (!$loan->_installments->contains('status','reject')) && (!$loan->_installments->contains('status','process'))) {
                $loan->status = 'paid';
                $loan->save();
            }

            \Utility::setMessage([
                'messageTitle' => trans('globals.success_alert_title'),
                'message' => trans('globals.success_procces'),
                'messageIcon' => 'glyphicon glyphicon-ok-circle',
            ]);

        } elseif (isset($install) && $install->status != 'paid' && $install->status != 'onhold' && $install->loan->installments == 1) {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.loan_required_installment'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);

        } elseif ($install === NULL){

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.installment_not_exist'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error',
            ]);

        }

        return redirect()->back();
    }
    
    public function installmentsByLoan(Request $request)
    {
        $installments = Installment::where('loan_id', $request->get('loan'))->orderBy('updated_at', 'desc')->get()->toArray();

        return json_encode([
            'loan' => $request->get('loan'),
            'installments' => $installments
        ]);
    }
}
