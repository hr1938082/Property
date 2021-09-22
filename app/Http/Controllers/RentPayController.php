<?php

namespace App\Http\Controllers;

use App\Models\Propety;
use App\Models\Rent;
use Illuminate\Http\Request;
use App\Models\RentPay;
use App\Models\Tendent;
use App\Models\Utility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RentPayController extends Controller
{
    // RentPay Add method
    public function add(Request $request)
    {
        $rent = Rent::where('user_id', $request->user_id)->select('id', 'amount', 'property_id')->first();
        if ($rent != null) {
            $find_last_date = RentPay::where('rent_id', $rent->id)
                ->orderbyDesc('id')
                ->get();

            $find_first_date = RentPay::where('rent_id', $rent->id)
                ->get();
            $rent_pay_count = $find_first_date->count();
            if ($rent_pay_count == 0) {
                $upload = [
                    "rent_id" => $rent->id,
                    "amount_paid" => $rent->amount,
                    "date" => strval(date('d-m-Y')),
                    "late" => 0
                ];
                if (RentPay::create($upload)) {
                    $Propety = Propety::find($rent->property_id);
                    $input = [
                        'user_id' => $Propety->user_id,
                        'property_id' => $Propety->id,
                        'description' => "Rent paid by user " . Auth::user()->name . " for Property " . $Propety->property_name,
                        'stt' => 1
                    ];
                    NotificationsController::insert($input);
                    return response()->json(["data" => ["status" => true]]);
                }
                return response()->json(["data" => ["status" => false]]);
            } else {
                $late = $this->differ_days($find_first_date[0]->date, $find_last_date[0]->date);
                if ($late != null) {
                    $upload = [
                        "rent_id" => $rent->id,
                        "amount_paid" => $rent->amount,
                        "date" => strval(date('d-m-Y')),
                        "late" => ((int)$late)
                    ];

                    if (RentPay::create($upload)) {
                        $Propety = Propety::find($rent->property_id);
                        $input = [
                            'user_id' => $Propety->user_id,
                            'property_id' => $Propety->id,
                            'description' => "Rent paid by user " . Auth::user()->name . " for Property " . $Propety->property_name,
                            'stt' => 1,
                            'stl' => 1
                        ];
                        NotificationsController::insert($input);
                        return response()->json(["status" => true]);
                    }
                    return response()->json(["status" => false]);
                }
                return response()->json(
                    [
                        "status" => false,
                        "data" => ["error" => "you have paid rent of this month"]
                    ]
                );
            }
        }
        return response()->json(
            [
                "status" => false,
                "data" => ["error" => "No Data Found in Rent Table"]
            ]
        );
    }
    // difference in dates
    public function differ_days($d, $my)
    {
        $last_date = substr($d, 0, 2);
        $last_month = (int) substr($my, 3, 2);
        $last_year = substr($my, 6, 4);
        $current_date = date_create(date('d-m-Y'));
        if ($last_year == (((int)date('Y')))) {
            $payable_month = ($last_month < date('m')) ? $last_month + 1 : null;
        } else {
            $payable_month = $last_month + 1;
        }
        if ($payable_month != null) {
            $last_dmy = date_create($last_date . "-" . $payable_month . "-" . $last_year);
            $diff = date_diff($last_dmy, $current_date);
            if ((int) $diff->format("%R%a") > 0) {
                return (int) $diff->format("%R%a");
            }
            return "0";
        }
        return "";
    }
    // RentPay select method
    public function select(Request $request)
    {
        if ($request->expectsJson()) {
            if (Auth::user()->user_type_id == 1) {
                $month = $request->month;
                $year = $request->year;
                $select = [];
                $check_select = RentPay::select(
                    'rent_pay.id as id',
                    'rent_id',
                    'rent.user_id as tendent_id',
                    'rent.property_id',
                    'properties.property_name',
                    'rent_pay.date',
                    'amount',
                    'split'
                )
                    ->join('rent', 'rent_pay.rent_id', '=', 'rent.id')
                    ->join('properties', 'properties.id', '=', 'rent.property_id')
                    ->where('properties.user_id', Auth::user()->id);
                if ($request->property_id != "") {
                    $check_select = $check_select->where('properties.id', $request->property_id);
                }
                if ($request->tendent_id != "") {
                    $check_select = $check_select->where('rent.user_id', $request->tendent_id);
                }
                $check_select = $check_select->orderbyDesc('id')->get();
                if (isset($check_select[0]->date)) {
                    $date_select = date_create($check_select[0]->date);
                    $current_date = date_create(date('Y-m-d'));
                    $diff_date = date_diff($date_select, $current_date);
                    $diff_month = $diff_date->m;
                }
                $check_select2 = Rent::select(
                    'users.id as user_id',
                    'users.name as user_name',
                    'properties.property_name',
                    'currency.currency',
                    'rent.amount',
                    'rent.split'
                )
                    ->join('users', 'users.id', 'rent.user_id')
                    ->join('properties', 'properties.id', 'rent.property_id')
                    ->join('currency', 'currency.id', 'properties.currency_id');
                if ($request->property_id != "") {
                    $check_select2 = $check_select2->where('properties.id', $request->property_id);
                }
                if ($request->tendent_id != "") {
                    $check_select2 = $check_select2->where('rent.user_id', $request->tendent_id);
                }
                $check_select2 = $check_select2
                    ->where('properties.user_id', Auth::user()->id)
                    ->get();
                $temp = [];
                foreach ($check_select as $value) {
                    if ($month != "" && $year != "") {
                        if ($month == substr($value->date, 3, 2) && $year == substr($value->date, 6)) {
                            array_push($temp, [
                                "user_id" => $value->tendent_id,
                                "month" => substr($value->date, 3, 2),
                                "year" => substr($value->date, 6),
                                "rent" => "paid",
                                "date" => $value->date
                            ]);
                        }
                    } else if ($month != "") {
                        if ($month == substr($value->date, 3, 2)) {
                            array_push($temp, [
                                "user_id" => $value->tendent_id,
                                "month" => substr($value->date, 3, 2),
                                "year" => substr($value->date, 6),
                                "rent" => "paid",
                                "date" => $value->date
                            ]);
                        }
                    } else if ($year != "") {
                        if ($year == substr($value->date, 6)) {
                            array_push($temp, [
                                "user_id" => $value->tendent_id,
                                "month" => substr($value->date, 3, 2),
                                "year" => substr($value->date, 6),
                                "rent" => "paid",
                                "date" => $value->date
                            ]);
                        }
                    } else {
                        array_push($temp, [
                            "user_id" => $value->tendent_id,
                            "month" => substr($value->date, 3, 2),
                            "year" => substr($value->date, 6),
                            "rent" => "paid",
                            "date" => $value->date
                        ]);
                    }
                }
                foreach ($check_select2 as $value) {
                    if (count($temp) > 0) {
                        foreach ($temp as $check) {
                            if ($check["user_id"] == $value->user_id) {
                                array_push($select, [
                                    'tendent_id' => $value->user_id,
                                    'tendent_name' => $value->user_name,
                                    'property_name' => $value->property_name,
                                    'amount' => $value->amount . " " . $value->currency ?? "AUD",
                                    'split' => $value->split,
                                    'rent' => 'paid',
                                    'date' => $check["date"]
                                ]);
                            } else {

                                $sel = Rent::select('rent_pay.date')
                                    ->join('rent_pay', 'rent.id', 'rent_pay.rent_id')
                                    ->where('rent.user_id', $value->user_id)->first();
                                if (!empty($sel->date)) {
                                    $day = substr($sel->date, 0, 2);
                                    $month = (string)((int)substr($sel->date, 3, 2)) + 1;
                                    $year = substr($sel->date, 6);
                                    if (strlen($month) == 1) {
                                        $month = "0" . $month;
                                    }
                                    $date = "$day-$month-$year";
                                } else {
                                    $date = "";
                                }

                                array_push($select, [
                                    'tendent_id' => $value->user_id,
                                    'tendent_name' => $value->user_name,
                                    'property_name' => $value->property_name,
                                    'amount' => $value->amount  . " " . $value->currency ?? "AUD",
                                    'split' => $value->split,
                                    'rent' => 'unpaid',
                                    'date' => $date,
                                ]);
                            }
                        }
                    } else {
                        array_push($select, [
                            'tendent_id' => $value->user_id,
                            'tendent_name' => $value->user_name,
                            'property_name' => $value->property_name,
                            'amount' => $value->amount  . " " . $value->currency ?? "AUD",
                            'split' => $value->split,
                            'rent' => 'unpaid',
                            'date' => ""
                        ]);
                    }
                }
            }
            if (Auth::user()->user_type_id == 2) {
                $select = RentPay::select(
                    'properties.property_name',
                    'amount_paid as paid',
                    'currency.currency',
                    'rent_pay.date',
                    'split'
                )
                    ->join('rent', 'rent_pay.rent_id', '=', 'rent.id')
                    ->join('properties', 'properties.id', '=', 'rent.property_id')
                    ->join('currency', 'currency.id', 'properties.currency_id')
                    ->where('rent.user_id', Auth::user()->id)
                    ->orderbyDesc('rent_pay.id')->get();
                $data = [];
                foreach ($select as $value) {
                    $data += [
                        'property_name' => $value->property_name,
                        'paid' => $value->paid . " " . $value->currency ?? "AUD",
                        'date' => $value->date,
                        'split' => $value->split,
                    ];
                }
                $select = $data;
            }
        } else {
            if (Auth::user()->user_type_id == 7) {
                $select = RentPay::select('rent_pay.id as id', 'rent_id', 'rent.property_id', 'properties.property_name', 'amount', 'split')
                    ->join('rent', 'rent_pay.rent_id', '=', 'rent.id')
                    ->join('properties', 'properties.id', '=', 'rent.property_id')
                    ->orderbyDesc('id')->get();
            }
        }

        if ($select != "") {
            return response()->json(
                [
                    "status" => true,
                    "data" => [$select]
                ]
            );
        }
    }
    // RentPay duedate method
    public function duedate(Request $request)
    {
        $select = null;
        $data = [];
        if ($request->expectsJson()) {
            if (Auth::user()->user_type_id == 1) {
                $select = Rent::select(
                    'rent.id',
                    'rent.user_id as tendent_id',
                    'rent.property_id',
                    'properties.property_name',
                    'currency.currency',
                    'rent.amount'
                )
                    ->join('properties', 'properties.id', '=', 'rent.property_id')
                    ->join('currency', 'currency.id', 'property.currecny_id')
                    ->where('properties.user_id', Auth::user()->id)
                    ->get();
                if ($select->count() > 0) {
                    $data = [];
                    foreach ($select as $value) {
                        $check = Tendent::where(
                            [
                                ['tendent_id', $value->tendent_id],
                                ['property_id', $value->property_id],
                                ['is_live', 1]
                            ]
                        )
                            ->first();
                        if ($check) {

                            $last_paid_date = RentPay::select('date')
                                ->where('rent_id', $value->id)
                                ->orderbyDesc('date')
                                ->get();
                            if ($last_paid_date) {
                                $first_paid_date = RentPay::select('date')
                                    ->where('rent_id', $value->id)
                                    ->first();
                                if ($first_paid_date) {
                                    $first_date = substr($first_paid_date->date, 0, 2);
                                    $last_month = (int)substr($last_paid_date[0]->date, 3, 2);
                                    $last_year = substr($last_paid_date[0]->date, 6, 4);
                                    $duedate = $first_date . "-" . ($last_month + 1) . "-" . $last_year;
                                    $late = $this->differ_days($first_paid_date->date, $last_paid_date[0]->date);
                                    array_push($data, [
                                        "tendent_id" => $value->tendent_id,
                                        "property_name" => $value->property_name,
                                        "amount" => $value->amount . " " . $value->currency ?? "AUD",
                                        "last_pay_date" => $last_paid_date[0]->date,
                                        "due_date" => $duedate,
                                        "late" => $late
                                    ]);
                                } else {
                                    array_push($data, [
                                        "property_name" => $value->property_name,
                                        "amount" => $value->amount . " " . $value->currency ?? "AUD",
                                        "last_paid_date" => "",
                                        "Payable_date" => "",
                                        "late" => "",
                                    ]);
                                }
                            }
                        }
                    }
                    return response()->json(["status" => true, "data" => $data]);
                }
                return response()->json(["status" => true, "data" => "No data Found"]);
            }
            if (Auth::user()->user_type_id == 2) {
                $select = Rent::select(
                    'properties.property_name',
                    'currency.currency',
                    'rent.amount',
                    'rent_pay.date as last_paid_date'
                )
                    ->join('properties', 'properties.id', '=', 'rent.property_id')
                    ->join('currency', 'currency.id', 'properties.currency_id')
                    ->join('rent_pay', 'rent_pay.rent_id', 'rent.id')
                    ->where('rent.user_id', Auth::user()->id)
                    ->orderbyDesc('last_paid_date')
                    ->get();
                $first_paid_date = RentPay::select('date')
                    ->join('rent', 'rent.id', '=', 'rent_pay.rent_id')
                    ->where('rent.user_id', Auth::user()->id)
                    ->first();
                if ($select->count() > 0) {
                    if ($first_paid_date->count() > 0) {
                        $late = $this->differ_days($first_paid_date->date, $select[0]->last_paid_date);
                        $date = substr($first_paid_date->date, 0, 2);
                        $month = (int)substr($select[0]->last_paid_date, 3, 2);
                        $year = substr($select[0]->last_paid_date, 6, 4);
                        $last_paid_date = "$date-" . ($month + 1) . "-$year";
                        $data = [
                            "property_name" => $select[0]->property_name,
                            "amount" => $select[0]->amount . " " . $select[0]->currency ?? "AUD",
                            "last_paid_date" => $select[0]->last_paid_date,
                            "Payable_date" => $last_paid_date,
                            "late" => $late
                        ];
                    }
                    return response()->json(["status" => true, "data" => $data]);
                } else {
                    $select = Rent::select(
                        'properties.property_name',
                        'currency.currency',
                        'rent.amount'
                    )
                        ->join('properties', 'rent.property_id', 'properties.id')
                        ->join('currency', 'currency.id', 'properties.currency_id')
                        ->where('rent.user_id', Auth::user()->id)
                        ->first();
                    if ($select) {
                        $data = [
                            "property_name" => $select->property_name,
                            "amount" => $select->amount . " " . $select->currency ?? "AUD",
                            "last_paid_date" => "",
                            "Payable_date" => "",
                            "late" => "",
                        ];
                        return response()->json(["status" => true, "data" => $data]);
                    }
                    return response()->json(["status" => true, "data" => "no data found"]);
                }
                return response()->json(["status" => false, "data" => [["not Found"]]]);
            }
        }
    }
    // RentPay duedate method
    public function upcomingrent(Request $request)
    {
        if ($request->expectsJson() && Auth::user()->user_type_id == 1) {
            $select = Rent::select(
                'rent.id',
                'rent.user_id as tendent_id',
                'rent.property_id',
                'properties.property_name',
                'rent.amount'
            )
                ->join('properties', 'properties.id', '=', 'rent.property_id')
                ->where('properties.user_id', Auth::user()->id)
                ->get();
            $data = [];
            foreach ($select as $value) {
                $check = Tendent::where(
                    [
                        ['tendent_id', $value->tendent_id],
                        ['property_id', $value->property_id],
                        ['is_live', 1]
                    ]
                )
                    ->first();
                if ($check) {
                    $find_first_date = RentPay::select('date')
                        ->where('rent_id', $value->id)
                        ->first();
                    if ($find_first_date) {
                        $find_last_date = RentPay::select('date')
                            ->where('rent_id', $value->id)
                            ->orderbyDesc('date')
                            ->get();
                        $first_date = substr($find_first_date->date, 0, 2);
                        $last_month = (int)substr($find_last_date[0]->date, 3, 2);
                        $last_year = substr($find_last_date[0]->date, 6);
                        $upcoming_paid_date = $first_date . "-" . ($last_month + 1) . "-" . $last_year;
                        $days_left = date_diff(date_create(date('d-m-Y')), date_create($upcoming_paid_date));
                        $days_left = (((int)$days_left->format('%R%a')) > 0) ? $days_left->format('%a') : "";
                        array_push($data, [
                            "property_name" => $value->property_name,
                            "amount" => $value->amount,
                            "Payable_date" => $upcoming_paid_date,
                            "days_left" => $days_left,
                        ]);
                    }
                }
            }
            return response()->json(["status" => true, "data" => $data]);
        }
        return response()->json(["status" => false, "data" => [["unauthenticated"]]]);
    }
    // RentPay duedate method
    public function rentAll(Request $request)
    {
        if ($request->expectsJson() && Auth::user()->user_type_id == 1) {
            $select = Rent::select(
                'properties.property_name',
                DB::raw('SUM(rent_pay.amount_paid) as sum_of_rent')
            )
                ->join('properties', 'properties.id', '=', 'rent.property_id')
                ->join('rent_pay', 'rent.id', '=', 'rent_pay.rent_id')
                ->where('properties.user_id', Auth::user()->id)
                ->groupBy('property_name')
                ->get();
            return response()->json(["status" => true, "data" => $select]);
        }
        return response()->json(["status" => false, "data" => [["unauthenticated"]]]);
    }
    // RentPay graph method
    public function YearlyDataMothWise(Request $request)
    {
        if ($request->expectsJson() && Auth::user()->user_type_id == 1) {
            $select = Rent::select('properties.property_name', 'rent_pay.amount_paid', 'rent_pay.date')
                ->join('properties', 'properties.id', '=', 'rent.property_id')
                ->join('rent_pay', 'rent.id', '=', 'rent_pay.rent_id')
                ->where('properties.user_id', Auth::user()->id)
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
                                "property_name" => $value->property_name,
                                "amoutn" => $value->amount_paid
                            ]);
                        }
                    }
                    $data += ["$value_month" => $temp];
                }
                ksort($data);
            }
            return response()->json(["status" => true, "data" => $data]);
        }
        return response()->json(["status" => false, "data" => [["unauthenticated"]]]);
    }
}
