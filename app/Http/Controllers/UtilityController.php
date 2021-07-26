<?php

namespace App\Http\Controllers;

use App\Models\Propety;
use App\Models\Tendent;
use Illuminate\Http\Request;
use App\Models\Utility;
use App\Models\UtilityPaid;
use Illuminate\Support\Facades\Auth;

class UtilityController extends Controller
{
    // add method
    public function add(Request $request)
    {
        if (Auth::user()->user_type_id == 1) {
            $check = Propety::find($request->property_id);
            if (Auth::user()->id == $check->user_id) {
                $upload = $request->all();
                Utility::create($upload);
                return response()->json(["data"=>[["utility"=>"added"]]]);
            }
            return response()->json(["data"=>[["error"=>"not belongs to you"]]]);
        }
        return response()->json(["data"=>[["error"=>"unauthenticated"],401]]);
    }

    // select method
    public function select(Request $request)
    {
        if ($request->expectsJson()) {
            if (Auth::user()->user_type_id == 1) {
                $check = Propety::find($request->property_id);
                if ($check && Auth::user()->id == $check->user_id) {
                    $select = Utility::join('properties','properties.id','=','utility.property_id')
                    ->select('utility.id','properties.property_name','utility.utility_name','utility.period')
                    ->where([['utility.property_id',$request->property_id],
                        ['properties.user_id',Auth::user()->id]])
                    ->get();
                    return response()->json(["data"=>$select]);
                }
                return response()->json(["data"=>[["error"=>"not belongs to you"]]]);
            }
            elseif(Auth::user()->user_type_id == 2)
            {
                $check = Tendent::where([['property_id',$request->property_id],['is_live',1]])
                ->first();
                if ($check && $check->tendent_id == Auth::user()->id) {
                    $select = Utility::select('utility.id','properties.property_name','utility.utility_name','utility.period')
                    ->where('utility.property_id',$check->property_id)
                    ->join('properties','properties.id','=','utility.property_id')
                    ->get();
                    return response()->json(["data"=>$select]);
                    
                }
                return response()->json(["data"=>[["error"=>"not belongs to you"]]]);
            }
        }
        return response()->json(["message"=>"not application/json"]);
    }

    // update method
    public function update(Request $request)
    {
        $check = Utility::find($request->input('id'));
        if($check)
        {
            $upload = $request->all();
            array_shift($upload);
            $check->update($upload);
            return response()->json(["data"=>[["utility"=>"updated"]]]);
        }
        return response()->json(["data"=>[["error"=>"not found"]]]);
    }

    // delete method
    public function delete(Request $request)
    {
        if ($request->expectsJson()) {
            $check1 = Utility::find($request->input('id'));
            if($check1)
            {
                $check = Propety::find($check1->property_id);
                if (Auth::user()->id == $check->user_id) 
                {
                    $check2 = UtilityPaid::where('utility_id',$check1->id)->get();
                    if($check2)
                    {
                        foreach ($check2 as $value) {
                            $value->delete();
                        }
                    }
                    $check1->delete();
                    return response()->json(["data"=>[["utility"=>"deleted"]]]);
                }
                return response()->json(["data"=>[["error"=>"not belongs to you"]]]);
            }
            return response()->json(["data"=>[["error"=>"not found"]]]);
        }
        return response()->json(["data"=>[["error"=>"unauthenticated"],401]]);
    }
}
