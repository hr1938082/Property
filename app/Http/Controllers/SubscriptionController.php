<?php

namespace App\Http\Controllers;

use App\Models\subscription;
use App\Models\usersubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function add(Request $request)
    {
        if(Auth::user()->user_type_id == 7)
        {
            $validator = $request->validate([
                'name' => 'required',
                'type' => 'required',
                'period' => 'required|numeric',
                'amount' => 'nullable|numeric',
                'feature' => 'nullable'
            ]);
            if($validator)
            {
                $upload = $request->all();
                $upload += ["status"=>"1"];
                
                $subs = subscription::create($upload);
                if($subs)
                {
                    return redirect()->route('subs-select-view');
                }
                return back()->with('status','Not inserted');
            }
        }
    }
    public function select(Request $request)
    {
        if(Auth::user()->user_type_id == 7)
        {
            $select = subscription::paginate(5);
            return view('subscription.manage',compact('select'));
        }
        if(Auth::user()->user_type_id == 1)
        {
            $select = subscription::where('status',1)->get();
            return response()->json(["status" => true, "data" => $select]);
        }
        return response()->json(["data"=>[["error"=>"unauthenticated"],401]]);
    }
    public function softdelete(Request $request)
    {
        if(Auth::user()->user_type_id ==7)
        {
            $check = subscription::find($request->id);
            if($check)
            {
                if($request->val == 0)
                {
                    $check->status = 0;
                    $update = $check->save();
                    if($update)
                    {
                        return back()->with('status','Disabled');
                    }
                }
                else
                {
                    $check->status = 1;
                    $update = $check->save();
                    if($update)
                    {
                        return back()->with('status','Enabled');
                    }
                    
                }
                return back()->with('status','error');
            }
            return back()->with('status','not found');
        }
    }
}
