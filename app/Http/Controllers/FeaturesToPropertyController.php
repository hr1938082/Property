<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FeaturesToProperty;
use App\Models\Propety;

class FeaturesToPropertyController extends Controller
{
    // insert method
    public function insert(Request $request)
    {
        if ($request->expectsJson()) {
            if (Auth::user()->user_type_id == 1) {
                $property = new Propety();
                $property = $property->find($request->property_id);
                if(Auth::user()->id == $property->user_id)
                {
                    $upload = $request->all();
                    FeaturesToProperty::create($upload);
                    return response()->json(["data"=>["status"=>"true"]]);
                }
                return response()->json(["data"=>["status"=>"false"]]);
            }
            else
            {
                return response()->json(["data"=>["status"=>"false","message"=>"unauthenticated"]]);
            }
        }
        return response()->json(["data"=>["status"=>"false","message"=>"unauthenticated"]]);
    }
    // select method
    public function select(Request $request)
    {
        $select = FeaturesToProperty::select('features_to_property.id as id',
         'properties.id as property_id','properties.property_name','features.id as feature_id',
         'features.feature')
        ->join('properties','features_to_property.property_id','=','properties.id')
        ->join('features','features_to_property.features_id','features.id');
            if($request->property_id != "")
            {
                $select=$select->where('property_id',$request->property_id);
            }
            if(Auth::user()->id == 1)
            {
                $select=$select->where('properties.user_id',Auth::user()->id);
            }
        $select=$select->get();
        return response()->json(["data"=>$select]);
    }
    // delete method
    public function delete(Request $request)
    {
        if ($request->expectsJson()) {
            if (Auth::user()->user_type_id == 1) 
            {
                $feature_to_property = FeaturesToProperty::find($request->id);
                if($feature_to_property)
                {
                    $check = Propety::find($feature_to_property->property_id);
                    if($check)
                    {
                        if(Auth::user()->id == $check->user_id)
                        {
                            $feature_to_property->delete();
                            return response()->json(["data"=>["status"=>"true"]]);
                        }
                        return response()->json(["data"=>["status"=>"false","message"=>"property not betons to you"]]);
                    }
                    return response()->json(["data"=>["status"=>"false","message"=>"property not found"]]);
                }
                return response()->json(["data"=>["status"=>"false","message"=>"not found"]]);
            }
            return response()->json(["data"=>["status"=>"false","message"=>"unauthenticated"]]);
        }
        return response()->json(["data"=>["status"=>"false","message"=>"unauthenticated"]]);
    }
}
