<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Loan;
use App\Surcharge;
use App\Payment;
use App\Helpers\Utility;

class SurchargesController extends Controller
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

            \Redirect::to('home')->send();
        }
    }

    private function rules($id = '')
    {
        return [
            'loan_id' => 'required',
            'surchargeAmount' => "required",
            'surchargeConcept' => 'required'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * $loans
         *
         * Check if there is a least one loan created in order for surcharges can be created
         *
         * @var [type]
         */
        $loans = Loan::select('id')->where('status', '!=', 'rejected')->take(1)->get();

        $surcharges = Surcharge::with(['user','loan'])->where('status', '!=', 'rejected')->get();

        return view('surcharges.grid', compact('surcharges', 'loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param [integer] $loan_id
     *
     * @return \Illuminate\Http\Response
     */
    public function create($loan_id)
    {
        $edit = false;

        $loan = Loan::with('surcharges')->where('id', $loan_id)->first();

        return view('surcharges.create', compact('loan', 'edit'));
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

        Surcharge::create([
            'user_id' => \Auth::user()->id,
            'loan_id' => $request->get('loan_id'),
            'concept' =>  $request->get('surchargeConcept'),
            'amount' =>  $request->get('surchargeAmount')
        ]);

        \Utility::setMessage([
            'messageTitle' => trans('globals.success_alert_title'),
            'message' => trans('globals.success_procces'),
            'messageIcon' => 'glyphicon glyphicon-ok-circle'
        ]);

        return redirect()->to('/surcharges');
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

        $surcharge = Surcharge::where('id', $id)->first();

        return view('surcharges.create', compact('surcharge', 'edit'));
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

        Surcharge::where('id', $id)->update([
            'user_id' => \Auth::user()->id,
            'loan_id' => $request->get('loan_id'),
            'concept' =>  $request->get('surchargeConcept'),
            'amount' =>  $request->get('surchargeAmount')
        ]);

        \Utility::setMessage([
            'messageTitle' => trans('globals.success_alert_title'),
            'message' => trans('globals.success_procces'),
            'messageIcon' => 'glyphicon glyphicon-ok-circle'
        ]);

        return redirect()->to('/surcharges');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $surcharge = Surcharge::select('id')->where('id', $id)->first();

        if ($request->user()->hasrole(['admin', 'supervisor']) && $surcharge) {

            $payments = Payment::select('id')->where('status', 'active')->get();

            if ($payments->count() > 0 ) {

                \Utility::setMessage([
                    'messageTitle' => trans('globals.error_alert_title'),
                    'message' => trans('payments.surcharges_associated_payments_msj'),
                    'messageIcon' => 'glyphicon glyphicon-remove-circle',
                    'messageClass' => 'error'
                ]);

            } else {

                $surcharge->status = 'rejected';
                $surcharge->save();

                \Utility::setMessage([
                    'messageTitle' => trans('globals.success_alert_title'),
                    'message' => trans('globals.success_procces'),
                    'messageIcon' => 'glyphicon glyphicon-ok-circle'
                ]);
            }

        } else {

            \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('globals.problem_processing_the_request'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
            ]);
        }

        return redirect()->to('/surcharges');
    }
}
