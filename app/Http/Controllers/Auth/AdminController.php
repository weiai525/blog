<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use App\Models\Auth\User;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Request;
use Validator;

class AdminController extends Controller
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
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }
     public function getLogin()
    {
        return tpl('auth.login');
    }
    public function postLogin(Request $request)
    {
        $data = Request::only('email', 'password');
        if (Auth::attempt($data, (boolean) Request::get('remember-me'))) {
            return redirect()->intended('/');
        }
        return $this->error(500201);
    }
    public function getRegister()
    {
        return tpl('auth.register');
    }
    public function postRegister()
    {
        return ;
        $validator = Validator::make(Request::all(), [
            'captchas' => 'required|captcha',
            'name' => 'required|max:255|min:5|unique:users',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return $this->error(500201,$validator->errors()->first());
        }
        $user = $this->create(Request::all());
        if (Auth::guard('web')->loginUsingId($user->id)) {
            return $this->success(['redirect'=>'']);
        }
        return $this->error(500505);
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
            'password' => 'required|min:6|confirmed',
        ]);
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
    /**
     * 注册保护
     * description
     * @author cuibo weiai525@outlook.com at 2016-10-06
     *
     * @return [type] [description]
     */
    protected function regieterProtect()
    {

    }
}
