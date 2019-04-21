<?php
namespace App\Http\Controllers\Auth;
use Auth;
use Input;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    /**
    *   Rules Login
    **/
    private $rules = [
        'username' => 'required',
        'password' => 'required',
    ];
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logOut']);
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function postLogin(Request $request)
    {
        $v = \Validator::make($request->all(), $this->rules);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $credentials = [
            'username' => Input::get('username'),
            'password' => Input::get('password'),
            'status'   => 'active'
        ];

        if (Auth::attempt($credentials, Input::get('remember'))) {
            // Authentication passed...
            return redirect()->intended('home');
        } 
        else
        {
            return redirect()->back()->withErrors(trans('validation.credentials_invalid'))->withInput();
        }
    }

    public function logOut()
    {
        auth()->logout();
        return redirect()->to('auth/login');
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}