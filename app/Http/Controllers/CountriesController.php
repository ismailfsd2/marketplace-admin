<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Countries;

class CountriesController extends InitController
{
    public function select(Request $request){
        $items = Countries::select('id','name');
        if($request->default_value){
            $items->where('id',$request->default_value);
        }
        else{
            $items->where('name','like','%'.$request->q.'%');
        }
        $items->limit(10);
        $response['status'] = true;
        $response['items'] = $items->get();
        return response()->json($response);
    }
}
