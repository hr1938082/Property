<?php

namespace App\Http\Controllers;

use App\Models\subscription;
use App\Models\usersubscription;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
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
    public function edit(Request $request)
    {
        $id = $request->id;
        $subscription = subscription::find($id);
        return view('subscription.edit',compact('id','subscription'));
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'name' => "required|alpha",
            'type' => 'required|alpha',
            'period' => 'required|numeric',
            'amount' => 'nullable|numeric',
            'feature' => 'nullable'
        ]);
        $upload = [
            'name' => $request->name,
            'type' => $request->type,
            'period' => $request->period,
            'amount' => $request->amount,
            'feature' => $request->feature,
        ];
        $subscription = subscription::find($id);
        if($subscription->update($upload))
        {
            return redirect()->route('subs-select-view');
        }
        return back()->with('status','Error');
    }
}
