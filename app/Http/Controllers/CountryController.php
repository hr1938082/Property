<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        return view('country.addCountry');
    }
    // store
    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required'
        ]);
        $upload = $request->all();
        $upload += ['status' => 1];
        if (Country::create($upload)) {
            return redirect()->route('Country.select');
        }
        return back()->with('status', 'Name is required');
    }

    public function select(Request $request)
    {
        if ($request->expectsJson()) {
            $select = Country::select('id', 'country')->where('status', 1)->get();
            return response()->json(['status' => true, 'data' => $select]);
        } else {
            $select = Country::paginate(6);
            return view('country.manageCountry', compact('select'));
        }
    }

    public function statUpdate(Request $request)
    {
        $row = Country::find($request->id);
        if ($row) {
            if ($row->status === 1) {
                $row->status = 0;
                $row->save();
                return back()->with('staus', 'Disabled');
            } else {
                $row->status = 1;
                $row->save();
                return back()->with('status', 'Enabled');
            }
        }
        return back()->with('status', 'Not Found');
    }
}
