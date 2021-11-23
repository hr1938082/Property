<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\city;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    public function index()
    {
        $states = State::all();
        return view('city.addcity', compact('states'));
    }
    public function insert(Request $request)
    {
        $request->validate([
            'city' => 'required',
            'state_id' => 'required|numeric'
        ]);
        $data = $request->all();
        if (city::create($data)) {
            return redirect()->route('cityManage');
        } else {
            return back()->with('status', 'failed to insert');
        }
    }
    public function select(Request $request)
    {
        if (!$request->expectsJson() && Auth::user()->user_type_id == 7) {
            $select = city::select('cities.id as id', 'cities.city', 'states.state', 'country.country')
                ->join('states', 'states.id', 'cities.state_id')
                ->join('country', 'country.id', 'states.country_id')->paginate(6);
            return view('city.manageCity', compact('select'));
        } elseif ($request->expectsJson()) {
            $select = city::select('city')->join('states', 'states.id', 'cities.state_id')
                ->where([['states.state', $request->state_name], ['states.status', 1]])->get();
            return response()->json(["status" => true, "data" => $select]);
        }
    }
    public function selectWeb(Request $request)
    {
        $select = city::select('city')->join('states', 'states.id', 'cities.state_id')
            ->where([['states.state', $request->state_name], ['states.status', 1]])->get();
        return response()->json(["status" => true, "data" => $select]);
    }
    public function delete(Request $request)
    {
        $city = city::find($request->id);
        if ($city) {
            $city->delete();
            return back()->with('status', 'Deleted');
        }
        return back()->with('status', 'Not Found');
    }
}
