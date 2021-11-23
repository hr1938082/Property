<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatesController extends Controller
{
    public function index()
    {
        $country = Country::select('id', 'country')->get();
        // dd($country);
        return view('State.addStates', compact('country'));
    }
    public function select(Request $request)
    {
        if (!$request->expectsJson() && Auth::user()->user_type_id == 7) {
            $select = state::select('states.id', 'country.country', 'states.state')
                ->join('country', 'states.country_id', 'country.id')
                ->paginate(6);
            return view('State.manageState', compact('select'));
        } else if ($request->expectsJson()) {
            $select = State::where('status', 1)->get();
            return response()->json(["status" => true, "data" => $select]);
        }
    }
    public function insert(Request $request)
    {
        $request->validate([
            'state' => 'required',
            'country_id' => 'required|integer',
        ]);
        $data = $request->all();
        $data += ['status' => 1];
        if (State::create($data)) {
            return redirect()->route('stateManage');
        } else {
            return back()->with('status', "failed to insert");
        }
    }
    public function statUpdate(Request $request)
    {
        $state = State::find($request->id);
        if ($state) {
            if ($state->status == 1) {
                $state->status = 0;
                $state->save();

                return back()->with('status', 'Disabled');
            } else {
                $state->status = 1;
                $state->save();
                return back()->with('status', 'Enabled');
            }
        }
        return back()->with('status', 'Not Found');
    }

    public function selectWeb(Request $request)
    {
        $select = State::select('state')->join('country', 'country.id', 'states.country_id')
            ->where([['country.country', $request->country_name], ['country.status', 1]])->get();
        return response()->json(["status" => true, "data" => $select]);
    }
}
