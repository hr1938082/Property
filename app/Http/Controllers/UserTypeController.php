<?php

namespace App\Http\Controllers;

use App\Models\User_type;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    private $user_type;

    public function __construct()
    {
        $this->user_type = new User_type();
    }
    // User Type Select Method
    public function select(Request $request)
    {
        $select = $this->user_type::all();
        if($request->expectsJson())
        {
            $select->pop();
            return response()->json(["data"=>$select]);
        }
        else
        {
            return view('user-type.manage',compact('select'));
        }
    }
}
