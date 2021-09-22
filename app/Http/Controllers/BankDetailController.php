<?php

namespace App\Http\Controllers;

use App\Models\BankDetail;
use Illuminate\Http\Request;

class BankDetailController extends Controller
{
    public function select(Request $req)
    {
        if ($req->expectsJson()) {
            $select = BankDetail::first();
            return response()->json(["status" => true, "data" => [$select]]);
        } else {
            $select = BankDetail::first();
            return view('payment-methods.bankdetails', compact('select'));
        }
    }
    public function update(Request $request)
    {
        $row = BankDetail::find($request->id);
        if ($row) {
            $upload = $request->all();
            $row->update($upload);
            return back()->with('status', 'Updated');
        }
        return back()->with('status', 'Not Found');
    }
}
