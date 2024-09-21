<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends InitController
{
    public function login()
    {
        $this->data['page_title'] = "Login";
        return view('auth.login', $this->data);
    }
    public function forget_password()
    {
        $this->data['page_title'] = "Forget Password";
        return view('auth.forget-password', $this->data);
    }
}
