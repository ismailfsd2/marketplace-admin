<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Countries;

class CountriesController extends InitController
{
    public function select(Request $request){
        $items = Countries::select('id','name');
        $items->where('name','like','%'.$request->q.'%');
        $response['status'] = true;
        $response['items'] = $items->get();
        return response()->json($response);
    }
}
