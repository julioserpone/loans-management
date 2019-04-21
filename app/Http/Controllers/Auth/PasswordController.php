<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\User;
use Faker\Factory as Faker;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

     public function postEmail(Request $request)
    {
        $user = User::select(['id', 'first_name', 'last_name', 'email'])->where('email', $request->get('email'))->first();

        if ($user) {

            $faker = Faker::create();
            $password = strtolower(str_replace(' ', '', $faker->text(20)));
            $user->where('id', $user->id)->update(['password' => \Hash::make($password)]);

            // email process

            $data = [
                'name' => $user->first_name.' '.$user->last_name,
                'email' => $user->email,
                'password' => $password,
                'title' => trans('email.forgot_pass.msg_01'),
            ];

            //Confirmation email
            \Mail::queue('emails.forgotPass',
            [
                'data' => $data
            ],
            function ($message) use ($data)
            {
                $message->to($data['email'])->subject(trans('email.forgot_pass.msg_01'));
            });

            \Session::put('messageTitle', trans('globals.success_alert_title'));
            \Session::put('message', trans('passwords.sent'));
            \Session::put('messageIcon', 'glyphicon glyphicon-ok-circle');

        }else {
            \Session::put('message', trans('passwords.user'));
            \Session::put('messageClass', 'error');
            \Session::put('messageTitle', trans('globals.error_alert_title'));
            \Session::put('messageIcon', 'glyphicon glyphicon-remove-circle');
        }

        \Session::save();
        return redirect('password/email');
    }
}
