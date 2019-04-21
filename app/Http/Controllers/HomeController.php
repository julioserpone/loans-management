<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Loan;
use App\User;
use App\Payment;
use App\Installment;
use App\Surcharge;
use Carbon\Carbon;
use App\Helpers\Utility;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $data = [];
        $outstanding = 0;

        $loans = Loan::with([
            'user',
            '_installments' => function ($query){
                $query->where('status', '!=', 'paid');
                $query->where('status', '!=', 'rejected');
                $query->orderBy('expired_date');
                return $query;
            },
            'surcharges' => function ($query){
                $query->where('status', '!=', 'paid');
                $query->where('status', '!=', 'rejected');
                $query->orderBy('updated_at');
                return $query;
            }
        ])->get();

        $loans->each(function ($loan) use (&$data, &$outstanding){

            //Upcoming Installments
            $loan->_installments->each(function ($install) use (&$data, $loan, &$outstanding){

                $data['installments'][$install->id]['user_id'] = $loan->user->id;
                $data['installments'][$install->id]['user_name'] = ucfirst($loan->user->fullName);
                $data['installments'][$install->id]['user_role'] = $loan->user->role;
                $data['installments'][$install->id]['loan_id'] = $install->loan_id;
                $data['installments'][$install->id]['installment_num'] = $install->installment_num;
                $data['installments'][$install->id]['status'] = ucfirst($install->status);
                $data['installments'][$install->id]['expired_date'] = Carbon::parse($install->expired_date)->format('F j, Y');
                $data['installments'][$install->id]['amount'] = Utility::numberFormat($install->amount, false);
                $data['installments'][$install->id]['interest_amount'] = Utility::numberFormat($install->interest_amount, false);
                $data['installments'][$install->id]['total_amount'] = Utility::numberFormat($install->total_amount, false);
                $data['installments'][$install->id]['created_at'] = Carbon::parse($install->created_at)->format('F j, Y');
                $data['installments'][$install->id]['updated_at'] = Carbon::parse($install->updated_at)->format('F j, Y');
                $outstanding += $install->total_amount;

            });

            //Pending Surcharges
            $loan->surcharges->each(function ($surcharge) use (&$data, $loan, &$outstanding){

                $data['surcharge'][$surcharge->id]['user_id'] = $loan->user->id;
                $data['surcharge'][$surcharge->id]['user_name'] = ucfirst($loan->user->fullName);
                $data['surcharge'][$surcharge->id]['loan_id'] = $surcharge->loan_id;
                $data['surcharge'][$surcharge->id]['surcharge_num'] = $surcharge->id;
                $data['surcharge'][$surcharge->id]['status'] = ucfirst($surcharge->status);
                $data['surcharge'][$surcharge->id]['concept'] = ucfirst($surcharge->concept);
                $data['surcharge'][$surcharge->id]['amount'] = Utility::numberFormat($surcharge->amount, false);
                $data['surcharge'][$surcharge->id]['created_at'] = Carbon::parse($surcharge->created_at)->format('F j, Y');
                $data['surcharge'][$surcharge->id]['updated_at'] = Carbon::parse($surcharge->updated_at)->format('F j, Y');
                $outstanding += $surcharge->amount;

            });

        });

        // \Artisan::call('route:cache');

        return view('home', [
            'data' => $data,
            'outstanding' => Utility::numberFormat($outstanding, false)
        ]);
    }

    public function box(Request $request)
    {
        $output = '';

        switch ($request->get('box')) {

            case 'revenue':
                $output = Utility::numberFormat(Payment::select('payment')->where('status', 'active')->sum('payment'), false);
            break;

            case 'customers':
                $output = User::select('id')->where('role', 'customer')->count();
            break;

            case 'loans':
                $output = Loan::select('id')->where('status', '!=','rejected')->count();
            break;

        }

        return json_encode(['output' => $output]);

    }

}
