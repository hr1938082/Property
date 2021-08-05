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
        if($request->expectsJson() && Auth::user()->user_type_id == 1)
        {
            $select = State::where('status',1)->get();
            return response()->json(["status"=> true, "data"=>$select]);
        }
        elseif( !$request->expectsJson() && Auth::user()->user_type_id == 7)
        {
            $select = state::paginate(5);
            return view('State.manageState',compact('select'));
        }
    }
    public function insert(Request $request)
    {
        $request->validate([
            'state'=>'required'
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
    public function statUpdate(Request $request)
    {
        $state = State::find($request->id);
        if($state)
        {
            if($state->status == 1)
            {
                $state->status = 0;
                $state->save();

            return back()->with('status','Disabled');
            }
            else
            {
                $state->status = 1;
                $state->save();
                return back()->with('status','Enabled');
            }
        }
        return back()->with('status','Not Found');
    }
}
