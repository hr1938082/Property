<?php

namespace App\Http\Controllers;

use App\Models\BankDetail;
use Illuminate\Http\Request;

class BankDetailController extends Controller
{
    public function select(Request $req)
    {
        $select=BankDetail::first();    
        return response()->json(["status"=> true, "data"=>[$select]]);
    }
}
