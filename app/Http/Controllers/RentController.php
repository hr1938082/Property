<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rent;

class RentController extends Controller
{
    // select method
    public function select(Request $request)
    {
        // echo $request->input('property_id');
        $select = Rent::join('properties','properties.id','=','rent.property_id')
        ->join('users','users.id','=','rent.user_id');
        if($request->input('property_id') != "")
        {
            $select = $select->where('rent.property_id','=',$request->input('property_id'));
        }
        $select = $select->select('rent.id','properties.property_name','users.name as user_name','rent.amount','rent.split')->orderByDesc('rent.id')->get();
        return response()->json(["data"=>$select]);
    }
}
