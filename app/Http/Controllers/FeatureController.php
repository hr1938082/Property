<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Feature;
use App\Models\FeaturesToProperty;

class FeatureController extends Controller
{
    // insert method
    public function insert(Request $request)
    {
        $upload = $request->all();
        // print_r($upload);
        if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id ==7) {
            if(Feature::create($upload))
            {
                return response()->json(["data"=>["status"=>true]]);
            }
        }
        else
        {
            return response()->json(["data"=>["status"=>false,"message"=>"unauthenticated"]]);
        }
        return response()->json(["data"=>["status"=>false]]);
    }

    // select method
    public function select(Request $request)
    {
        if (Auth::user()->user_type_id==1 || Auth::user()->user_type_id == 7) {
            $select = Feature::all();
            if($select)
            {
                return response()->json(["data"=>$select]);
            }
        }
        else
        {
            return response()->json(["status"=>false,"message"=>"unauthenticated"]);
        }
    }
}
