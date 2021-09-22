<?php

namespace App\Http\Controllers;

use App\Models\Tendent;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UtilityPaid;
use Illuminate\Support\Facades\DB;

class UtilityPaidController extends Controller
{
    //add method
    public function add(Request $request)
    {
        if (Auth::user()->user_type_id == 2) {
            $check = Tendent::where([['tendent_id',Auth::user()->id],['is_live',1]])->first();
            if (isset($check)) {
                $check=UtilityPaid::select('date')->where([['user_id',Auth::user()->id],['utility_id',$request->utility_id]])
                ->orderbyDesc('date')
                ->get();
                if ($check->count()>0) {
                    $check_date = substr($check[0]->date,3);
                }
                else
                {
                    $check_date = [];
                }
                $current_date = date('m-Y');
                if (!empty($check_date)) {
                    if ($check_date != $current_date) {
                        $property_id=UtilityPaid::select('property_id as property')
                        ->join('utility','utility.id','=','utility_paid.utility_id')
                        ->where('utility.id',$request->utility_id)
                        ->first();
                        $tendent_in_property = Tendent::where(
                                [
                                    ['property_id',$property_id->property],
                                    ['is_live',1]
                                ]
                            )
                            ->get();
                        $upload = $request->all();
                        if ($tendent_in_property->count()>1) {
                            $upload+=[
                                "is_split"=>1,
                            ];
                        }
                        else
                        {
                            $upload+=[
                                "is_split"=>0,
                            ];
                        }
                        $upload+=[
                            "user_id"=>Auth::user()->id,
                            "date"=>date('d-m-Y'),
                        ];
                        UtilityPaid::create($upload);
                        return response()->json(["data"=>[["utility_paid"=>"added"]]]);
                    }
                    return response()->json(["data"=>[["utility_paid"=>"You have already paid of This Month"]]]);
                }
                else
                {
                    $property_id=Tendent::select('property_id as property')
                    ->where('tendent_id',Auth::user()->id)
                    ->first();
                    $tendent_in_property=Tendent::where(
                        [
                            ['property_id',$property_id->property],
                            ['is_live',1]
                        ]
                    )
                    ->get();
                    $upload = $request->all();
                    if ($tendent_in_property->count()>1) {
                        $upload+=[
                            "is_split"=>1,
                            "date"=>date('d-m-Y'),
                        ];
                    }
                    else{
                        $upload+=[
                            "is_split"=>0,
                            "date"=>date('d-m-Y'),
                        ];
                    }
                    $upload+=[
                        "user_id"=>Auth::user()->id,
                        "date"=>date('d-m-Y'),
                    ];
                    UtilityPaid::create($upload);
                    return response()->json(["data"=>[["utility_paid"=>"added"]]]);
                }
            }
            return response()->json(["data"=>[["message"=>"not belong to you"]]]);
        }
        return response()->json(["data"=>[["message"=>"unauthanticated"]]]);
    }
    //select method
    public function select(Request $request)
    {
        $select = UtilityPaid::join('utility','utility.id','=','utility_paid.utility_id')
        ->join('users','users.id','=','utility_paid.user_id')
        ->join('properties','properties.id','=','utility.property_id')
        ->select('utility_paid.id','utility.utility_name','users.name as user_name','properties.property_name',
            'utility_paid.total_amount','utility_paid.paid_by_user','utility_paid.is_split');
            if ($request->expectsJson()) {
                if (Auth::user()->user_type_id == 1) {
                    if ($request->property_id != "") {
                        $select = $select->where('utility.property_id',$request->property_id);
                    }
                    if ($request->utility_id) {
                        $select = $select->where('utility_paid.utility_id',$request->utility_id);
                    }
                    $select=$select->where('properties.user_id',Auth::user()->id);
                }
                elseif(Auth::user()->user_type_id == 2)
                {
                    $select = $select->where('utility_paid.user_id',Auth::user()->id);
                }
            }
        $select=$select->orderByDesc('utility_paid.id')
        ->get();
        return response()->json(["data"=>$select]);
    }
    public function utilityAll(Request $request)
    {
        if($request->expectsJson() && Auth::user()->user_type_id == 1)
        {
            $select = Utility::select('properties.property_name',
            DB::raw('AVG(utility_paid.total_amount) as avg_of_utility'))
            ->join('properties','properties.id','=','utility.property_id')
            ->join('utility_paid','utility.id','=','utility_paid.utility_id')
            ->where('properties.user_id',Auth::user()->id)
            ->groupBy('property_name')
            ->get();
            return response()->json(["status"=>true,"data"=>$select]); 
        }
        return response()->json(["status"=>false, "data"=>[["unauthenticated"]]]);
    }
}
