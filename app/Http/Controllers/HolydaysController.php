<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Holyday;
use App\Installment;

class HolydaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $is_holyday = true;
        $holydays = Holyday::with('user')->get();
        $ref = trans('globals.section_title.calendar_holydays');
        return view('partials.fullcalendar', compact('ref', 'is_holyday', 'holydays'));
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
        $holyday = Holyday::select(['id'])->where('holyday', $request->get('date'))->first();

        $data = [
            'responsable_id' => \Auth::user()->id,
            'holyday' => $request->get('date')
        ];

        if ($holyday) {
            $holyday->update($data);
        } else {
            $holyday = Holyday::create($data);
        }

        return json_encode([
            'holyday_id' => $holyday->id,
            'date' => \Carbon\Carbon::parse($request->get('date'))->format('F j, Y'),
            'updated_at' => \Carbon\Carbon::parse($holyday->updated_at)->format('F j, Y'),
            'responsable' => \Auth::user()->first_name.' '.\Auth::user()->last_name,
        ]);
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
        $holyday = Holyday::find($id);
        if ($holyday) {

            $installments = Installment::where('holyday_id', $id)->get();

            if (!$installments) {
                $holyday->delete();
                \Utility::setMessage([
                    'messageTitle' => trans('globals.success_alert_title'),
                    'message' => trans('globals.success_procces'),
                    'messageIcon' => 'glyphicon glyphicon-ok-circle'
                ]);
            } else {
                \Utility::setMessage([
                'messageTitle' => trans('globals.error_alert_title'),
                'message' => trans('validation.holyday_associated'),
                'messageIcon' => 'glyphicon glyphicon-remove-circle',
                'messageClass' => 'error'
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

        return redirect()->to('/calendar/holydays');
    }
}
