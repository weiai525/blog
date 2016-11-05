<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\AdminUser;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
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
        return tpl('auth.login-admin');
    }
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'captcha' => 'required|captcha',
            'email' => 'required|email|max:255|exists:admin_users,email',
            'password' => 'required|min:6',
        ]);
        $data = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($data, (boolean) $request->input('remember-me'))) {
            return $this->success(['redirect_url' => $request->input('redirect_url', config('app.url'))]);
        }
        return $this->error(500201);
    }
    public function getRegister()
    {
        return tpl('auth.register');
    }
    public function postRegister()
    {
        $validator = Validator::make(Request::all(), [
            'captcha' => 'required|captcha',
            'name' => 'required|max:255|min:5|unique:users',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return $this->error(500201, $validator->errors()->first());
        }
        $user = $this->create(Request::all());
        if (Auth::guard('admin')->loginUsingId($user->id)) {
            return $this->success(['redirect_url' => Request::input('redirect_url', config('app.url'))]);
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
        return AdminUser::create([
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
