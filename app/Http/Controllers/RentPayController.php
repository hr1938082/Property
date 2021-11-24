<?php

namespace App\Http\Controllers;

use App\Models\Propety;
use App\Models\Rent;
use Illuminate\Http\Request;
use App\Models\RentPay;
use App\Models\Tendent;
use App\Models\Utility;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RentPayController extends Controller
{
    // RentPay Add method
    public function add(Request $request)
    {
        $rent = Rent::select('rent.id', 'amount', 'property_id', 'properties.rent_days')
            ->join('properties', 'properties.id', 'rent.property_id')
            ->where('rent.user_id', $request->user_id)
            ->first();
        if ($rent != null) {
            $find_last_date = RentPay::select('date', 'late')->where('rent_id', $rent->id)
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
                        'title' => 'Rent',
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
                $first_date = Carbon::parse($find_first_date[0]->date);
                $last_date = Carbon::parse($find_last_date[0]->date);
                $payable_date = Carbon::parse("$first_date->day-$last_date->month-$last_date->year")
                    ->addDays($rent->rent_days);
                $late = $payable_date->lt(Carbon::now()) ? $payable_date->diffInDays(Carbon::now()) : 0;
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
                            'title' => 'Rent',
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
                $month = (int)$request->month;
                $year = (int)$request->year;
                $check_select = RentPay::select(
                    'rent.user_id as tendent_id',
                    'users.name as tendent_name',
                    'properties.property_name',
                    'rent_pay.date',
                    'rent_pay.amount_paid',
                    'currency.currency',
                    'split'
                )
                    ->join('rent', 'rent_pay.rent_id', '=', 'rent.id')
                    ->join('users', 'users.id', 'rent.user_id')
                    ->join('properties', 'properties.id', '=', 'rent.property_id')
                    ->join('tendent_to_property', 'tendent_to_property.tendent_id', 'users.id')
                    ->join('currency', 'currency.id', 'properties.currency_id')
                    ->where('properties.user_id', Auth::user()->id);
                if ($request->property_id != "") {
                    $check_select = $check_select->where('properties.id', $request->property_id);
                }
                if ($request->tendent_id != "") {
                    $check_select = $check_select->where('rent.user_id', $request->tendent_id);
                }
                $check_select = $check_select->orderbyDesc('rent_pay.id')->get();

                $select = [];
                foreach ($check_select as $value) {
                    if ($month && $year) {
                        if ($month == Carbon::parse($value->date)->month && $year == Carbon::parse($value->date)->year) {
                            array_push($select, [
                                "tendent_id" => $value->tendent_id,
                                "tendent_name" => $value->tendent_name,
                                "Property_name" => $value->property_name,
                                'amount' => $value->amount_paid  . " " . $value->currency ?? "AUD",
                                "split" => $value->split,
                                "rent" => "Paid",
                                "date" => $value->date
                            ]);
                        }
                    } else if ($month) {
                        if ($month == Carbon::parse($value->date)->month) {
                            array_push($select, [
                                "tendent_id" => $value->tendent_id,
                                "tendent_name" => $value->tendent_name,
                                "Property_name" => $value->property_name,
                                'amount' => $value->amount_paid  . " " . $value->currency ?? "AUD",
                                "split" => $value->split,
                                "rent" => "Paid",
                                "date" => $value->date
                            ]);
                        }
                    } else if ($year) {
                        if ($year == Carbon::parse($value->date)->year) {
                            array_push($select, [
                                "tendent_id" => $value->tendent_id,
                                "tendent_name" => $value->tendent_name,
                                "Property_name" => $value->property_name,
                                'amount' => $value->amount_paid  . " " . $value->currency ?? "AUD",
                                "split" => $value->split,
                                "rent" => "Paid",
                                "date" => $value->date
                            ]);
                        }
                    }
                }
                if ($select) {
                    return response()->json(['status' => true, 'data' => $select]);
                } else {
                    $check_select2 = Rent::select(
                        'rent.id as id'
                    )
                        ->join('properties', 'properties.id', 'rent.property_id');
                    if ($request->property_id != "") {
                        $check_select2 = $check_select2->where('rent.property_id', $request->property_id);
                    }
                    if ($request->tendent_id != "") {
                        $check_select2 = $check_select2->where('rent.user_id', $request->tendent_id);
                    }
                    $check_select2 = $check_select2
                        ->where('properties.user_id', Auth::user()->id)
                        ->get();
                    foreach ($check_select2 as $value) {
                        $check = RentPay::where('rent_id', $value->id)->first();
                        if ($check) {
                            $rows = RentPay::select(
                                'rent.user_id as tendent_id',
                                'users.name as tendent_name',
                                'properties.property_name as property_name',
                                'rent_pay.amount_paid as amount',
                                'currency.currency',
                                'rent.split',
                                'rent_pay.date'
                            )
                                ->join('rent', 'rent.id', 'rent_pay.rent_id')
                                ->join('users', 'users.id', 'rent.user_id')
                                ->join('properties', 'properties.id', 'rent.property_id')
                                ->join('currency', 'currency.id', 'properties.currency_id')
                                ->where('rent_pay.rent_id', $check->rent_id)
                                ->orderbyDesc('rent.id')
                                ->get();
                            if ($rows->count() > 0) {
                                foreach ($rows as $row) {
                                    array_push($select, [
                                        'tendent_id' => $row->tendent_id,
                                        'tendent_name' => $row->tendent_name,
                                        'property_name' => $row->property_name,
                                        'amount' => $row->amount  . " " . $row->currency ?? "AUD",
                                        'split' => $row->split,
                                        'rent' => 'Paid',
                                        'date' => $row->date,
                                    ]);
                                }
                            }
                        } else {
                            $row = Rent::select(
                                'rent.user_id as tendent_id',
                                'users.name as tendent_name',
                                'properties.property_name as property_name',
                                'rent.amount',
                                'currency.currency',
                                'rent.split',
                            )
                                ->join('users', 'users.id', 'rent.user_id')
                                ->join('properties', 'properties.id', 'rent.property_id')
                                ->join('currency', 'currency.id', 'properties.currency_id')
                                ->where('rent.id', $value->id)
                                ->first();
                            array_push($select, [
                                'tendent_id' => $row->tendent_id,
                                'tendent_name' => $row->tendent_name,
                                'property_name' => $row->property_name,
                                'amount' => $row->amount  . " " . $row->currency ?? "AUD",
                                'split' => $row->split,
                                'rent' => 'Unpaid',
                                'date' => "",
                            ]);
                        }
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

        return response()->json(
            [
                "status" => true,
                "data" => $select
            ]
        );
    }
    // RentPay duedate method
    public function duedate(Request $request)
    {
        $select = null;
        $data = [];
        if ($request->expectsJson()) {
            if (Auth::user()->user_type_id == 1) {
                $select = DB::table('rent')
                    ->join('properties', function ($join) {
                        $join->on('properties.id', '=', 'rent.property_id');
                    })->join('currency', function ($join) {
                        $join->on('currency.id', '=', 'properties.currency_id');
                    })->where('properties.user_id', Auth::user()->id)
                    ->select(
                        'rent.id',
                        'rent.user_id as tendent_id',
                        'rent.property_id',
                        'properties.property_name',
                        'properties.rent_days',
                        'properties.currency_id',
                        'currency.currency',
                        'rent.amount',
                        // 'properties.currecny_id'
                    )->get();
                // dd($select);
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
                                    $first_date = Carbon::parse($first_paid_date->date);
                                    $last_date = Carbon::parse($last_paid_date[0]->date);
                                    $payable_date = Carbon::parse("$first_date->day-$last_date->month-$last_date->year")->addDays($value->rent_days);
                                    $duedate = $payable_date->format('d-m-Y');
                                    $late = Carbon::now()->gt($payable_date) ? $payable_date->diffInDays(Carbon::now()) : 0;
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
                    'properties.rent_days',
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
                        $first_date = Carbon::parse($first_paid_date->date);
                        $last_date = Carbon::parse($select[0]->last_paid_date);
                        $payable_date = Carbon::parse("$first_date->day-$last_date->month-$last_date->year")->addDays($select[0]->rent_days);
                        $late = $payable_date->lt(Carbon::now()) ? $payable_date->diffInDays(Carbon::now()) : 0;
                        $data = [
                            "property_name" => $select[0]->property_name,
                            "amount" => $select[0]->amount . " " . $select[0]->currency ?? "AUD",
                            "last_paid_date" => $select[0]->last_paid_date,
                            "Payable_date" => $payable_date->format('d-m-Y'),
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
                'properties.rent_days',
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
                        $first_date = Carbon::parse($find_first_date->date);
                        $last_date = Carbon::parse($find_last_date[0]->date);
                        $payable_date = Carbon::parse("$first_date->day-$last_date->month-$last_date->year")->addDays($value->rent_days);
                        $upcoming_paid_date = $payable_date->format('d-m-Y');
                        $days_left = $payable_date->diffInDays(Carbon::now());
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
                foreach ($month_data as $value_month) {
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
    public function rentNotification()
    {
        ini_set('max_execution_time', 82800);
        $select = Tendent::select(
            'rent.id',
            'properties.property_name',
            'properties.rent_days',
            'tendent_to_property.tendent_id',
            'tendent_to_property.property_id'
        )
            ->join('properties', 'properties.id', 'tendent_to_property.property_id')
            ->join('rent', 'rent.user_id', 'tendent_to_property.tendent_id')
            ->where('is_live', 1)
            ->get();
        $temp = 0;
        $data = [];
        foreach ($select as $value) {
            if ($temp !== $value->property_id) {
                array_push($data, [
                    "rent_id" => $value->id,
                    'property_name' => $value->property_name,
                    'user_id' => $value->tendent_id,
                    'property_id' => $value->property_id
                ]);
            }
            $temp = $value->property_id;
        }
        foreach ($select as $value) {
            $row2 = RentPay::select('date')->where('rent_id', $value->id)->orderbyDesc("id")->get();
            if ($row2->count() > 0) {
                $first_paid_date = RentPay::select('date')->where('rent_id', $value->id)->first();
                $last_paid_date = Carbon::parse($row2[0]->date);
                $payable_date = Carbon::parse($first_paid_date->date);
                $payable_date = Carbon::parse("$payable_date->day-$last_paid_date->month-$last_paid_date->year")->addDays($value->rent_days);
                $today_date = Carbon::now();
                if ($payable_date->gte($today_date)) {
                    if ($payable_date->diffInDays($today_date) == 1) {
                        foreach ($data as $row) {
                            if ($row['rent_id'] === $value->id) {

                                $input = [
                                    'title' => 'Rent',
                                    'user_id' => $row['user_id'],
                                    'property_id' => $row['property_id'],
                                    'description' => "Payable date for rent is " . $payable_date->format('d-m-Y') . " for Property " . $row['property_name'],
                                    'stt' => 1,
                                    'stl' => 1
                                ];
                                NotificationsController::ToAllByTendent($input);
                            }
                        }
                    }
                    if ($payable_date->diffInDays($today_date) == 0) {
                        foreach ($data as $row) {
                            if ($row['rent_id'] === $value->id) {
                                $input = [
                                    'title' => 'Rent',
                                    'user_id' => $row['user_id'],
                                    'property_id' => $row['property_id'],
                                    'description' => "Last date of paying rent for Property " . $row['property_name'],
                                    'stt' => 1,
                                    'stl' => 1
                                ];
                                NotificationsController::ToAllByTendent($input);
                            }
                        }
                    }
                }
                if ($payable_date->lt($today_date)) {
                    if ($payable_date->diffInDays($today_date) >= 1) {
                        foreach ($data as $row) {
                            if ($row['rent_id'] === $value->id) {
                                $input = [
                                    'title' => 'Rent',
                                    'user_id' => $row['user_id'],
                                    'property_id' => $row['property_id'],
                                    'description' => "Payable date for rent was " . $payable_date->format('d-m-Y') . " for Property " . $row['property_name'],
                                    'stt' => 1,
                                    'stl' => 1
                                ];
                                NotificationsController::ToAllByTendent($input);
                            }
                        }
                    }
                }
            }
        }
    }
}
