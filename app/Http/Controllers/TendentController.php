<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Image;
use App\Models\Tendent;
use App\Models\Propety;
use App\Models\Rent;
use Exception;

class TendentController extends Controller
{
    // tedent_to_property tendent only approved
    public function tendent_only_approved(Request $request)
    {
        if ($request->expectsJson()) {
            if (Auth::user()->user_type_id == 1) {
                $select = Tendent::select(
                    'tendent_to_property.id',
                    'tendent_to_property.property_id',
                    'tendent_to_property.tendent_id',
                    'users.name',
                    'users.email',
                    'users.mobile',
                    'users.address',
                    'users.image',
                    'properties.property_name'
                )
                    ->join('properties', 'properties.id', '=', 'tendent_to_property.property_id')
                    ->join('users', 'users.id', 'tendent_to_property.tendent_id')
                    ->where([['properties.user_id', Auth::user()->id], ['is_live', 1]]);
                if ($request->property_id != "") {
                    $select = $select->where('properties.id', $request->property_id);
                }
                $select = $select->get();
                return response()->json(["data" => $select]);
            }
            return response()->json(["data" => [["unauthenticated"]]]);
        }
    }
    // tedent_to_property select
    public function select(Request $request)
    {
        $tendent_id = $request->input('tendent_id');
        $name = $request->input('name');
        $image = new Image();
        $data = [];
        $select = DB::table('preperty_request')
            ->select(
                'preperty_request.id AS id',
                'properties.id as property_id',
                'properties.property_name AS name',
                'properties.currency_id',
                'properties.rent AS rent',
                'address.city AS city',
                'address.state AS state',
            )
            ->join('properties', 'properties.id', 'preperty_request.property_id')
            ->join('address', 'address.id', 'properties.address_id');
        if ($tendent_id != "") {
            $select = $select->where('preperty_request.tendent_id', $tendent_id);
        }
        if ($name != "") {
            $select = $select->where('properties.property_name', 'LIKE', '%' . $name . '%');
        }
        $select = $select->orderByDesc('id')->get();
        $image = $image::all();
        $currency = DB::table('currency')->get();
        foreach ($select as $value) {
            $temp = [];
            $count = 0;
            foreach ($image as $row) {
                if ($value->property_id == $row->property_id && $count == 0) {
                    array_push($temp, ["id" => $row->id, "path" => $row->name_dir]);
                    $count++;
                }
            }
            $currencyVal = "";
            foreach ($currency as $row) {
                if ($row->id == $value->currency_id) {
                    $currencyVal = $row->currency;
                }
            }
            $rentval = $currencyVal ? "$value->rent $currencyVal" : $value->rent;
            array_push($data, [
                "id" => $value->id,
                "property_id" => $value->property_id,
                "name" => $value->name,
                "rent" => $rentval,
                "city" => $value->city,
                "state" => $value->state,
                "image" => $temp,
                "status" => "pending"
            ]);
        }
        $tendentselect = DB::table('tendent_to_property')
            ->select(
                'tendent_to_property.id AS id',
                'properties.id as property_id',
                'properties.property_name AS name',
                'properties.rent AS rent',
                'address.city AS city',
                'address.state AS state',
            )
            ->join('properties', 'properties.id', 'tendent_to_property.property_id')
            ->join('address', 'address.id', 'properties.address_id')
            ->where([['tendent_to_property.tendent_id', $request->input('tendent_id')], ['is_live', 1]]);
        if ($name != "") {
            $tendentselect = $tendentselect->where('properties.property_name', 'LIKE', '%' . $name . '%');
        }
        $tendentselect = $tendentselect->orderByDesc('id')->get();
        foreach ($tendentselect as $value) {
            $temp = [];
            $count = 0;
            foreach ($image as $row) {
                if ($value->property_id == $row->property_id && $count == 0) {
                    array_push($temp, ["id" => $row->id, "path" => $row->name_dir]);
                    $count++;
                }
            }
            array_push($data, [
                "id" => $value->id,
                "property_id" => $value->property_id,
                "name" => $value->name,
                "rent" => $value->rent,
                "city" => $value->city,
                "state" => $value->state,
                "image" => $temp,
                "status" => "approved"
            ]);
        }

        return response()->json(["data" => $data]);
    }
    // select specific method
    public function selectspecific(Request $request)
    {
        $check = DB::table('preperty_request')
            ->where([['tendent_id', $request->tendent_id], ['property_id', $request->property_id]])
            ->get();
        $check2 = DB::table('tendent_to_property')
            ->where(
                [
                    ['tendent_id', $request->tendent_id],
                    ['property_id', $request->property_id],
                    ['is_live', 1]
                ]
            )
            ->get();
        if (count($check) > 0 || count($check2) > 0) {
            return response()->json(["data" => true]);
        }
        return response()->json(["data" => false]);
    }
    public function selectone(Request $request)
    {
        $select = Tendent::select(
            'properties.property_name',
            'users.name as tendent_name',
            'currency.currency',
            'rent.amount as rent',
            'properties.year_build',
            'tendent_to_property.date'
        )
            ->join('properties', 'properties.id', '=', 'tendent_to_property.property_id')
            ->join('users', 'users.id', '=', 'tendent_to_property.tendent_id')
            ->join('currency', 'properties.currency_id', 'currency.id')
            ->join('rent', 'rent.property_id', 'properties.id')
            ->where('tendent_to_property.tendent_id', Auth::user()->id)
            ->where('is_live', 1)
            ->first();
        if ($select) {
            $data = [
                'property_name' => $select->property_name,
                'tendent_name' => $select->tendent_name,
                'rent' => $select->rent . " " . $select->currency ?? "AUD",
                'year_build' => $select->year_build,
                'date' => $select->date,
            ];
            return response()->json(["status" => true, "data" => [$data]]);
        }
        return response()->json(["status" => false]);
    }
    // tedent_to_property delete
    public function delete(Request $request)
    {
        $check = Tendent::find($request->input('id'));
        if ($check) {
            $update = ["is_live" => 0];
            $check->update($update);
            $find = Tendent::where([['property_id', $check->property_id], ['is_live', 0]])->get();
            if ($find && $find->count() > 0) {
                $tendent_on_property_count = $find->count();
            } else {
                $tendent_on_property_count = 1;
            }
            $property_rent = Propety::select('rent')
                ->where('id', $check->property_id)->first();
            if ($property_rent) {
                $rent = (int)ceil($property_rent->rent / $tendent_on_property_count);
            } else {
                return response()->json(["data" => [["tendent_to_property" => "property not found"]]]);
            }
            Rent::where('user_id', $check->tendent_id)->delete();
            if ($tendent_on_property_count > 1) {
                Rent::where('property_id', $check->property_id)
                    ->update(["amount" => $rent, 'split' => 1]);
            } else {
                Rent::where('property_id', $check->property_id)
                    ->update(["amount" => $rent, 'split' => 0]);
            }
            return response()->json(["data" => [["tendent_to_property" => "deleted"]]]);
        }
        return response()->json(["data" => [["error" => "not found"]]]);
    }
    public function tendent_on_property(Request $request)
    {
        $select = Tendent::select('users.id as user_id', 'users.name as user_name')
            ->join('users', 'users.id', '=', 'tendent_to_property.tendent_id')
            ->where([['tendent_to_property.property_id', $request->property_id], ['is_live', 1]])
            ->get();
        return response()->json(['status' => true, "data" => $select]);
    }
    public function tendent_lived_in_property(Request $request)
    {
        $select = Tendent::select(
            'tendent_to_property.tendent_id',
            'users.name',
            'users.email',
            'properties.property_name',
            'properties.bed_rooms',
            'properties.bath_rooms',
            'properties.description',
            'currency.currency',
            'properties.rent',
            'properties.year_build',
            'tendent_to_property.date'
        )
            ->join('properties', 'properties.id', '=', 'tendent_to_property.property_id')
            ->join('users', 'users.id', 'tendent_to_property.tendent_id')
            ->join('currency', 'properties.currency_id', 'currency.id')
            ->where([['tendent_id', $request->user_id], ['is_live', 0]])
            ->get();
        if ($select) {
            $data = [];
            foreach ($select as $value) {
                $data = [
                    'tendent_id' => $value->tendent_id,
                    'name' => $value->name,
                    'email' => $value->email,
                    'property_name' => $value->tendent_id,
                    'bed_rooms' => $value->bed_rooms,
                    'bath_rooms' => $value->tendent_id,
                    'description' => $value->description,
                    'rent' => $value->rent . " " . $value->currency ?? "AUD",
                    'year_build' => $value->year_build,
                    'date' => $value->date,
                ];
            }
            return response()->json(
                [
                    "status" => true,
                    "data" => [$data],
                ]
            );
        }
        return response()->json(
            [
                "status" => false
            ]
        );
    }
    public function ten_to_pro(Request $request)
    {
        $ptn = $request->ptn;
        $pts = $request->pts;
        $is_live = $request->is_live;
        $select = Tendent::select(
            'tendent_to_property.id as id',
            'users.name as tenants',
            'properties.property_name as property',
            'properties.rent',
            'tendent_to_property.is_live',
        )
            ->join('users', 'users.id', 'tendent_to_property.tendent_id')
            ->join('properties', 'properties.id', 'tendent_to_property.property_id');
        if ($request->ptn != "") {
            $select = $select->where($request->ptn, 'LIKE', '%' . $request->pts . '%');
        }
        if ($request->is_live != "") {
            $select = $select->where('is_live', $request->is_live);
        }
        $select = $select->orderbyDesc('id')
            ->paginate(6);

        if ($ptn) {
            $select = $select->appends(["ptn" => $ptn, "is_live" => $is_live, "pts" => $pts]);
        }
        return view('tenants.tenants', compact('select'));
    }

    public function tendentSelectOne(Request $request)
    {
        try {
            if ($request->id) {
                $row = Tendent::select(
                    'properties.id as property_id',
                    'properties.property_name'
                )
                    ->join('properties', 'properties.id', 'tendent_to_property.property_id')
                    ->where([['tendent_to_property.tendent_id', $request->id], ['is_live', 1]])
                    ->get();
                return response()->json(['status' => true, 'data' => $row]);
            }
            throw new Exception('id is required');
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'messages' => $e->getMessage()]);
        }
    }
}
