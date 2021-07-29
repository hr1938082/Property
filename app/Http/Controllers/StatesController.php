<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatesController extends Controller
{
    public function index()
    {
        return view('State.addStates');
    }
    public function select(Request $request)
    {
        $select = State::all();
        if($request->expectsJson() && Auth::user()->user_type_id == 1)
        {
            return response()->json(["status"=> true, "data"=>$select]);
        }
        elseif( !$request->expectsJson() && Auth::user()->user_type_id == 7)
        {
            return view('State.manageState',compact('select'));
        }
    }
    public function insert(Request $request)
    {
        $request->validate([
            'state'=>'required|alpha'
        ]);
        $data =$request->all();
        if(State::create($data))
        {
            return redirect()->route('stateManage');
        }
        else
        {
            return back()->with('status',"failed to insert");
        }
    }
}
