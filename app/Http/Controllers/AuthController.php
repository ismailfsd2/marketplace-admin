<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Session;
// use App\Http\Middleware\LoginAuthMiddleware;

class AuthController extends InitController
{
    public function login()
    {
        $this->data['page_title'] = "Login";
        return view('auth.login', $this->data);
    }
    public function auth_login(Request $request)
    {
        $valiate_option['email'] = "required|email|max:255";
        $valiate_option['password'] = "min:6|required";
        $validated = $request->validate($valiate_option);

        $response['status'] = false;

        $auth = User::where('email',$request->email)->first();
        if($auth){
            if (Hash::check($request->password, $auth->password)) {
                if($auth->status){
                    $request->session()->put('mp_auth_login', $auth->id);
                    $response['status'] = true;
                    $response['redirect'] = route('dashboard');
                    $response['message'] = "Login successful";
                }
                else{
                    $response['message'] = "Your account is blocked";
                }
            }
            else{
                $response['message'] = "Wrong Password";
            }
        }
        else{
            $response['message'] = "Invalid Email";
        }
        return response()->json($response);
    }

    public function logout(){
        Session::forget('mp_auth_login');
        return redirect()->route('auth.login');
    }

    public function forget_password()
    {
        $this->data['page_title'] = "Forget Password";
        return view('auth.forget-password', $this->data);
    }
}
