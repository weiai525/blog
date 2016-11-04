<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
//use 

class UeditorController extends Controller
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


    /**
     * Create a new password controller instance.
     *
     * @return void
     *//*
    public function __construct()
    {
        $this->middleware('guest');
    }*/
    public function index()
    {
        return  captcha_src();
        return captcha();
    }
}
