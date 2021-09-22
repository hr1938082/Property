<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PaymentMethodsController extends Controller
{
    public function manage(Request $request)
    {
        if ($request->expectsJson() && Auth::user()->user_type_id == 1) {
            $select = PaymentMethod::select('id', 'name')
                ->where('status', 1)
                ->get();
            $select->pop();
            return response()->json([
                "status" => true,
                "data" => $select
            ]);
        }
        if (Auth::user()->user_type_id == 7) {
            $select = PaymentMethod::select('id', 'name', 'status')->get();
            return view('payment-methods.manage', compact('select'));
        }
    }
    private function detail($input)
    {
        $select = PaymentMethod::find($input);
        if ($select->name === "bank") {
            return redirect()->route('Bankdetails.select');
        }
        return view('payment-methods.detail', compact('select'));
    }
    public function authCheck(Request $request)
    {
        if (Hash::check($request->pass, Auth::user()->password)) {
            return $this->detail($request->id);
        }
        return back()->with('status', 'Password not matched');
    }
    public function softdel(Request $request)
    {
        $check = PaymentMethod::find($request->id);
        if ($check) {
            if ($check->update(["status" => $request->status])) {
                if ($check->status == 0) {
                    return redirect('payment/methods/manage')->with('status', "Disabled");
                } else {
                    return redirect('payment/methods/manage')->with('status', "Enabled");
                }
            }
            return redirect('payment/methods/manage')->with('status', "Not Disabled");
        }
        return redirect('payment/methods/manage')->with('status', "Not Found");
    }
    public function update(Request $request)
    {
        $check = PaymentMethod::find($request->id);
        if ($check) {
            if ($check->update($request->all())) {
                return redirect('payment/methods/manage')->with('status', "Update");
            }
            return redirect('payment/methods/manage')->with('status', 'Not Updated');
        }
        return redirect('payment/methods/manage')->with('status', 'Not Found');
    }
}
