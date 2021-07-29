<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\city;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    public function index()
    {
        return view('city.addcity');
    }
    public function insert(Request $request)
    {
        $data = $request->all();
        if(city::create($data))
        {
            return redirect()->route('cityManage');
        }
        else
        {
            return back()->with('status','failed to insert');
        }
    }
    public function select(Request $request)
    {
        if(!$request->expectsJson() && Auth::user()->user_type_id == 7)
        {
            $select = city::select('cities.id as id', 'cities.city','states.state')->join('states','states.id','cities.state_id')->paginate(5);
            return view('city.manageCity',compact('select'));
        }
        elseif($request->expectsJson() && Auth::user()->user_type_id==1)
        {
            $select = city::select('city')->join('states','states.id','cities.state_id')->where('states.id',$request->state_id)->get();
            return response()->json(["status" => true, "data" => [$select]]);
        }
    }
}
