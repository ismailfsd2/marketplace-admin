<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Session;
use App\Models\User;

class InitController extends Controller
{
    public $data = array(); 
    
    function __construct(Request $request) {
        Artisan::call('migrate');
        if(Session::has('mp_auth_login')){
            $auth_id = Session::get('mp_auth_login');
            $this->data['auth'] = User::with(['employee'])->find($auth_id);
            return redirect()->route('dashboard');
        }
    }
}
