<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class InitController extends Controller
{
    public $data = array(); 
    
    function __construct(Request $request) {
        Artisan::call('migrate');
    }
}
