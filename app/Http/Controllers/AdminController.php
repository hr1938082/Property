<?php

namespace App\Http\Controllers;

use App\Models\RentPay;
use App\View\Components\auth\register;
use Illuminate\Http\Request;
use App\Models\User_type;
use App\Models\User;
use App\Models\UtilityPaid;
use App\Models\Rent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // admin index method
    public function index()
    {
        return view('admin_home');
    }

    // add user add method
    public function adduserform($email = null)
    {
        $email_error = $email;
        $user_type = User_type::all();
        return view('manage-user.add', compact('user_type', 'email_error'));
    }
    // add user add method
    public function register(Request $request)
    {
        $valitate = $request->validate([
            'name' => 'required|min:4|max:50',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'mobile' => 'required',
            'address' => 'required',
            'user_type_id' => 'required',
        ]);
        if ($valitate) {
            $check = User::where('email', $request->input('email'))->first();
            if (!$check) {
                $this->user->name = $request->input("name");
                $this->user->user_type_id = $request->input("user_type_id");
                $this->user->email = $request->input("email");
                $this->user->password = Hash::make($request->input("password"));
                $this->user->verified = 0;
                $this->user->code_id = 0;
                $this->user->mobile = $request->input("mobile");
                $this->user->address = $request->input("address");
                $this->user->status = 1;
                $this->user->save();
                return redirect()->route('manageuser');
            }
            return $this->adduserform("Email Already Exist");
        }
    }

    public function dashboard()
    {
        $rent = RentPay::select(DB::raw('SUM(amount_paid)as rent'))
            ->first();
        $utility = UtilityPaid::select(DB::raw('AVG(paid_by_user) as utility'))
            ->first();
        $select = RentPay::select('rent_pay.amount_paid', 'rent_pay.date')
            ->get();
        $month_data = [];
        $data = [];
        $current_month = (int)date('m');
        $current_year = (int)date('Y');
        if ($select) {
            foreach ($select as $value) {
                $year = (int)substr($value->date, 6);
                $month = (int)substr($value->date, 3, 2);
                if ($year == $current_year) {
                    array_push($month_data, $month);
                }
            }
            $month_data = array_unique($month_data);
            foreach ($month_data as $key => $value_month) {
                $temp = [];
                foreach ($select as $value) {
                    $year = (int)substr($value->date, 6);
                    $month = (int)substr($value->date, 3, 2);
                    if ($year == $current_year && $month == $value_month) {
                        array_push($temp, [
                            "amoutn" => $value->amount_paid
                        ]);
                    }
                }
                $data += ["$value_month" => $temp];
            }
            ksort($data);
        }
        $datas = [];
        foreach ($data as $key => $value) {
            $month = $key;
            $temps = 0;
            foreach ($value as $values) {
                $temps += (int)$values["amoutn"];
            }
            array_push($datas, ["month" => $month, "rent" => $temps]);
        }
        return view('dashboard', compact('rent', 'utility', 'datas'));
    }
}
