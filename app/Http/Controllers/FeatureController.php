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

    public function webStore(Request $req)
    {
        if ($req->feature) {
            $upload = $req->all();
            $upload['is_deleted'] =0;
            Feature::create($upload);
            return redirect()->back()->with('status','Created');
        }
        return redirect()->back()->with('status','empty');
    }

    public function webSelect()
    {
        $select = Feature::select('id','feature')->where('is_deleted',0)->orderByDesc('id')->paginate(5);
        return view('feature.manage',compact('select'));
    }

    public function webDelete(Request $req)
    {
        $feature = Feature::find($req->id);
        $feature->is_deleted = 1;
        $feature->save();
        return redirect()->back()->with('status','Deleted');
    }
}
