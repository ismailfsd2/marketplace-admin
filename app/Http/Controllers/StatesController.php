<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\States;

class StatesController extends InitController
{
    public function select(Request $request){
        $items = States::select('id','name');
        if($request->default_value){
            $items->where('id',$request->default_value);
        }
        else{
            $items->where('name','like','%'.$request->q.'%');
            if($request->parent){
                $items->where('country_id',$request->parent);
            }
        }
        $items->limit(10);
        $response['status'] = true;
        $response['items'] = $items->get();
        return response()->json($response);
    }
}
