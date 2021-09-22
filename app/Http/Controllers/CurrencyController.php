<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    // Index
    public function index(Request $request)
    {
        return view('currency.add');
    }
    // insert
    public function insert(Request $request)
    {
        $request->validate([
            'currency' => 'required'
        ]);
        $upload = $request->all();
        $upload +=['status'=>1];
        if(currency::create($upload))
        {
            return redirect()->route('currencyManage');
        }
    }
    //  manage
    public function manage(Request $request)
    {
        $search = $request->search;
        $select = currency::where('currency','LIKE','%'.$search.'%')->paginate(6);
        return view('currency.manage',compact('select'));
    }
    // select
    public function select(Request $request)
    {
        $select = currency::where('status',1)->get();
        return  response()->json(['status'=> true, 'data'=>$select]);
    }
    // stat update
    public function statUpdate(Request $request)
    {
        $id = $request->id;
        $currency = currency::find($id);
        if($currency->status == 1)
        {

            $currency->status = 0;
            $currency->save();
            return redirect()->route('currencyManage');
        }
        else
        {
            $currency->status = 1;
            $currency->save();
            return redirect()->route('currencyManage');
        }
    }
    // edit
    public function edit(Request $request)
    {
        $id = $request->id;
        $currency = currency::find($id);
        return view('currency.edit',compact('id','currency'));
    }
    // update
    public function update(Request $request)
    {
        $request->validate([
            'currency' => 'required'
        ]);
        $id = $request->id;
        $currency = currency::find($id);
        $upload = $request->all();
        if($currency->update($upload))
        {
            return redirect()->route('currencyManage');
        }
        else
        {
            return back()->with('status','Error');
        }
    }
}
