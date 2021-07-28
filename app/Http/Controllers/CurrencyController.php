<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    // select
    public function select(Request $request)
    {
        $select = currency::all();
        return response()->json(['status'=> true, 'data'=>$select]);
    }
}
