<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cities;

class CitiesController extends InitController
{
    public function select(Request $request){
        $items = Cities::select('id','name');
        $items->where('name','like','%'.$request->q.'%');
        if($request->parent){
            $items->where('state_id',$request->parent);
        }
        $response['status'] = true;
        $response['items'] = $items->get();
        return response()->json($response);
    }
}
