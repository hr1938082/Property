<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyRequest;
use App\Models\Tendent;
use App\Models\Rent;
use App\Models\Propety;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PropertyRequestController extends Controller
{
    // add method
    public function add(Request $request)
    {
        if (Auth::user()->user_type_id == 2) {
            $check = PropertyRequest::where([['tendent_id', $request->tendent_id], ['property_id', $request->property_id]])->get();
            if (!(count($check) > 0)) {
                $upload = $request->all();
                $upload += ["date" => date('d-m-Y')];
                if (PropertyRequest::create($upload)) {
                    $property = Propety::find($request->property_id);
                    $input = [
                        "user_id" => $request->tendent_id,
                        "property_id" => $request->property_id,
                        "description" => Auth::user()->name . " requested you for property " . $property->property_name,
                        'stt' => 0,
                        'stl' => 1
                    ];
                    NotificationsController::insert($input);
                }
                return response()->json(["data" => ["Property Request" => "inserted"]]);
            }
            return response()->json(["data" => ["error" => "can not request for same"]]);
        }
        return response()->json(["data" => ["error" => "unauthenticated"]]);
    }
    // approve method
    public function approve(Request $request)
    {
        if (Auth::user()->user_type_id == 1) {
            $check = PropertyRequest::find($request->input('id'));
            if ($check) {
                $check2 = Propety::where([['id', $check->property_id], ['user_id', Auth::user()->id]])->first();

                if (isset($check2)) {
                    $tendent_on_property = Tendent::where([
                        ['tendent_id', $check->tendent_id],
                        ['is_live', 1]
                    ])->first();
                    if (!$tendent_on_property) {
                        $tendent = new Tendent();
                        $tendent->tendent_id = $check->tendent_id;
                        $tendent->property_id = $check->property_id;
                        $tendent->date = date('d-m-Y');
                        $tendent->is_live = 1;
                        $tendent->save();
                        $find = Tendent::where([['property_id', $check->property_id], ['is_live', 1]])->get();
                        $tendent_on_property_count = $find->count();
                        $property_rent = Propety::select('property_name', 'rent')
                            ->where('id', $check->property_id)->first();
                        $rent = (int)ceil($property_rent->rent / $tendent_on_property_count);
                        $rent_ins = Rent::create([
                            "property_id" => $check->property_id,
                            "user_id" => $check->tendent_id,
                            "amount" => $rent,
                            "split" => 0
                        ]);
                        $user = User::select('name')->where('id', $tendent->tendent_id)->first();
                        $input = [
                            "user_id" => Auth::user()->id,
                            "property_id" => $check->property_id,
                            "description" => Auth::user()->name . " approved $user->name request for property " . $property_rent->property_name,
                            'stt' => 1,
                            "stl" => 0
                        ];
                        NotificationsController::insert($input);
                        $check->delete();
                        if ($tendent_on_property_count > 1) {
                            Rent::where('property_id', $check->property_id)
                                ->update(['amount' => $rent, 'split' => 1]);
                        }
                        return response()->json(["data" => ["Property Request" => "Approved"]]);
                    }
                    return response()->json(["data" => ["error" => "Tendent is already approved in any other property"]]);
                }
                return response()->json(["data" => ["error" => "not belongs to you"]]);
            }
            return response()->json(["data" => ["Property Request" => "Not Found"]]);
        }
        return response()->json(["data" => ["error" => "unauthenticated"]]);
    }
    // select method
    public function select(Request $request)
    {
        $select = PropertyRequest::select(
            'preperty_request.id',
            'preperty_request.tendent_id',
            'users.name',
            'users.email',
            'users.image',
            'properties.id as property_id',
            'properties.property_name'
        )
            ->join('properties', 'properties.id', '=', 'preperty_request.property_id')
            ->join('users', 'users.id', 'preperty_request.tendent_id')
            ->where('properties.user_id', $request->user_id)
            ->get();
        return response()->json(["data" => [$select]]);
    }
    // delete method
    public function delete(Request $request)
    {
        if (Auth::user()->user_type_id == 1) {
            $check = PropertyRequest::find($request->input('id'));
            if ($check) {
                $check->delete();
                return response()->json(["data" => ["Property Request" => "deleted"]]);
            }
            return response()->json(["data" => ["Property Request" => "Not Found"]]);
        }
    }
}
