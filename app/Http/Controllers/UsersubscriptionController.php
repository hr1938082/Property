<?php

namespace App\Http\Controllers;

use App\Models\BankApproval;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\PaynetGateway;
use App\Models\subscription;
use App\Models\User;
use App\Models\usersubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersubscriptionController extends Controller
{
    public function addform(Request $request)
    {
        $id = $request->id;
        $select = subscription::select('id', 'name')
            ->where('status', 1)
            ->get();
        $select_pay = PaymentMethod::select('id', 'name')
            ->where('status', 1)
            ->get();
        $current_year = (int)date('Y');
        return view('user-subscription.add', compact('id', 'select', 'select_pay', 'current_year'));
    }
    public function fetchdetail(Request $request)
    {
        $select = User::select('users.id as id', 'users.name as user_name', 'users.email', 'user_type.name as type_name')
            ->join('user_type', 'user_type.id', '=', 'users.user_type_id')
            ->where('users.id', $request->id)
            ->first();
        if ($select) {
            $select_subs = usersubscription::select(
                'user_subscriptions.id',
                'subscriptions.name as subscription',
                'subscriptions.type',
                'subscriptions.period',
                'user_subscriptions.expiry_date',
                'user_subscriptions.status'
            )
                ->join('subscriptions', 'subscriptions.id', '=', 'user_subscriptions.subscription_id')
                ->where([
                    ['user_subscriptions.user_id', $request->id],
                    ['user_subscriptions.status', 1]
                ])
                ->orWhere('user_subscriptions.user_id', $request->id)
                ->orderbyDesc('id')
                ->get();
            if ($select_subs->count() > 0) {
                $current_date = date_create(date('d-m-Y'));
                $expiry_date = date_create($select_subs[0]->expiry_date);
                $expiry_diff = date_diff($current_date, $expiry_date);
                $expiry_diff = (int)$expiry_diff->format('%R%a');
                return view('user-subscription.userfetchdetail', compact('select', 'select_subs', 'expiry_diff'));
            }
            return view('user-subscription.userfetchdetail', compact('select', 'select_subs'));
        } else {
        }
    }
    public function add(Request $request)
    {
        if ($request->expectsJson() && Auth::user()->user_type_id == 1) {
            if (Auth::user()->user_type_id == 1) {
                if (Auth::user()->verified == 1) {
                    $check_enable = subscription::find($request->subs_id)->where('status', 1)->first();

                    if ($check_enable) {
                        $check = usersubscription::where(
                            [
                                ['user_id', Auth::user()->id],
                                ['status', 1]
                            ]
                        )
                            ->first();
                        if (!$check) {
                            $check_trail = subscription::where('name', 'trial')
                                ->orWhere('name', 'Trial')
                                ->orWhere('name', 'TRIAL')
                                ->first();
                            if ($check_trail && $request->subs_id == $check_trail->id) {
                                $check_trail_user = usersubscription::where([
                                    ['user_id', Auth::user()->id],
                                    ["subscription_id", $check_trail->id]
                                ])
                                    ->first();

                                if (!$check_trail_user) {
                                    $upload = [
                                        "user_id" => Auth::user()->id,
                                        "subscription_id" => $request->subs_id,
                                        "name" => "trial",
                                        "status" => 1
                                    ];
                                    if ($this->uploadmethod($upload)) {
                                        return response()->json(["status" => true]);
                                    }
                                    return response()->json(["status" => false]);
                                }
                                return response()->json(["data" => [["error" => "You arleady have availed trial cannot apply again!"]]]);
                            } else {
                                if ($request->pay_method == "stripe" || $request->pay_method == "Stripe" || $request->pay_method == "STRIPE") {

                                    $check_stripe = PaymentMethod::where([
                                        ['name', 'stripe'],
                                        ['status', 1]
                                    ])
                                        ->orWhere([
                                            ['name', 'Stripe'],
                                            ['status', 1]
                                        ])
                                        ->orWhere([
                                            ['name', 'STRIPE'],
                                            ['status', 1]
                                        ])
                                        ->first();
                                    if ($check_stripe) {
                                        $pay = PaymentController::stripePayment($request->all());
                                        if ($pay->original["status"]) {
                                            $upload = [
                                                "user_id" => Auth::user()->id,
                                                "name" => "stripe",
                                                "subscription_id" => $request->subs_id,
                                                "type" => "card",
                                                "amount" => $pay->original["payment"]["amount"],
                                                "key_id" => $pay->original["payment"]["key_id"],
                                                "key_secret" => $pay->original["payment"]["key_secret"],
                                                "status" => 1
                                            ];
                                            if ($this->uploadmethod($upload)) {
                                                return response()->json(["status" => true]);
                                            }
                                            return response()->json(["status" => false]);
                                        } else {
                                            return response()->json(["data" => [[
                                                "status" => $pay->original["status"],
                                                "error" => $pay->original["cart_details"]
                                            ]]]);
                                        }
                                    }
                                    return response()->json(["status" => false, "message" => "stripe is not enable now"]);
                                }
                                if ($request->pay_method == "bank" || $request->pay_method == "Bank" || $request->pay_method == "BANK") {

                                    $check_bank = PaymentMethod::where([
                                        ['name', 'bank'],
                                        ['status', 1]
                                    ])
                                        ->orWhere([
                                            ['name', 'Bank'],
                                            ['status', 1]
                                        ])
                                        ->orWhere([
                                            ['name', 'BANK'],
                                            ['status', 1]
                                        ])
                                        ->first();
                                    if ($check_bank) {
                                        $check_bank = BankApproval::where([
                                            ['user_id', Auth::user()->id],
                                            ['status', 0]
                                        ])->first();
                                        if (!$check_bank) {
                                            $image_name = explode('.', $request->image[0]["name"]);
                                            $extension = end($image_name);
                                            $image_data = base64_decode($request->image[0]["image"]);
                                            $image_Name = (sha1(date('dmYhis') . microtime('true')));
                                            $filename = "$image_Name.$extension";
                                            file_put_contents(public_path("storage/images/$filename"), $image_data);
                                            $image = "storage/images/$filename";
                                            $upload = [
                                                "user_id" => Auth::user()->id,
                                                "subscription_id" => $request->subs_id,
                                                "amount" => $request->amount,
                                                'image' => $image,
                                                'bank_info' => $request->bank_info,
                                                'status' => 0
                                            ];
                                            if (BankApproval::create($upload)) {
                                                return response()->json(["status" => true, "approval" => '0']);
                                            }
                                            return response()->json(["status" => false]);
                                        }
                                        return response()->json(["status" => true, 'message' => 'Can not send request again']);
                                    }
                                    return response()->json(["status" => false, "message" => "Bank is not enable now"]);
                                }
                            }
                        } else {
                            $check_trail = subscription::where('name', 'trial')
                                ->orWhere('name', 'Trial')
                                ->orWhere('name', 'TRIAL')
                                ->first();
                            if ($check->subscription_id == $check_trail->id) {
                                if ($request->subs_id != $check_trail->id) {
                                    if ($request->pay_method == "stripe" || $request->pay_method == "Stripe" || $request->pay_method == "STRIPE") {

                                        $check_stripe = PaymentMethod::where([
                                            ['name', 'stripe'],
                                            ['status', 1]
                                        ])
                                            ->orWhere([
                                                ['name', 'Stripe'],
                                                ['status', 1]
                                            ])
                                            ->orWhere([
                                                ['name', 'STRIPE'],
                                                ['status', 1]
                                            ])
                                            ->first();
                                        if ($check_stripe) {
                                            $pay = PaymentController::stripePayment($request->all());
                                            if ($pay->original["status"]) {
                                                $upload = [
                                                    "user_id" => Auth::user()->id,
                                                    "name" => "stripe",
                                                    "subscription_id" => $request->subs_id,
                                                    "type" => "card",
                                                    "amount" => $pay->original["payment"]["amount"],
                                                    "key_id" => $pay->original["payment"]["key_id"],
                                                    "key_secret" => $pay->original["payment"]["key_secret"],
                                                    "status" => 1
                                                ];
                                                if ($this->uploadmethod($upload)) {
                                                    $check->status = 0;
                                                    $check->save();
                                                    return response()->json(["status" => true]);
                                                }
                                                return response()->json(["status" => false]);
                                            } else {
                                                return response()->json(["data" => [[
                                                    "status" => $pay->original["status"],
                                                    "error" => $pay->original["cart_details"]
                                                ]]]);
                                            }
                                        }
                                        return response()->json(["status" => false, "message" => "stripe is not enable now"]);
                                    }
                                    if ($request->pay_method == "bank" || $request->pay_method == "Bank" || $request->pay_method == "BANK") {

                                        $check_bank = PaymentMethod::where([
                                            ['name', 'bank'],
                                            ['status', 1]
                                        ])
                                            ->orWhere([
                                                ['name', 'Bank'],
                                                ['status', 1]
                                            ])
                                            ->orWhere([
                                                ['name', 'BANK'],
                                                ['status', 1]
                                            ])
                                            ->first();
                                        if ($check_bank) {
                                            $check_bank = BankApproval::where([
                                                ['user_id', Auth::user()->id],
                                                ['status', 0]
                                            ])->first();
                                            if (!$check_bank) {
                                                $image_name = explode('.', $request->image[0]["name"]);
                                                $extension = end($image_name);
                                                $image_data = base64_decode($request->image[0]["image"]);
                                                $image_Name = (sha1(date('dmYhis') . microtime('true')));
                                                $filename = "$image_Name.$extension";
                                                file_put_contents(public_path("storage/images/$filename"), $image_data);
                                                $image = "storage/images/$filename";
                                                $upload = [
                                                    "user_id" => Auth::user()->id,
                                                    "subscription_id" => $request->subs_id,
                                                    "amount" => $request->amount,
                                                    'image' => $image,
                                                    'bank_info' => $request->bank_info,
                                                    'status' => 0
                                                ];
                                                if (BankApproval::create($upload)) {
                                                    $check->status = 0;
                                                    $check->save();
                                                    return response()->json(["status" => true, "approval" => '0']);
                                                }
                                                return response()->json(["status" => false]);
                                            }
                                            return response()->json(["status" => true, 'message' => 'Can not send request again']);
                                        }
                                        return response()->json(["status" => false, "message" => "Bank is not enable now"]);
                                    }
                                }
                                return response()->json(["data" => [["error" => "You arleady have availed trial cannot apply again!"]]]);
                            }
                        }
                        return response()->json(["data" => [["error" => "You already have " . $check->name ?? "N/A" . " subscription"]]]);
                    }
                    return response()->json(["data" => [["error" => "subscription not enabled"]]]);
                }
                return response()->json(["data" => [["error" => "verify your email"]]]);
            }
            return response()->json(["data" => [["error" => "Not a landlord"]]]);
        }
        if (Auth::user()->user_type_id == 7) {
            $check = User::find($request->id);
            if ($check->user_type_id == 1) {
                if ($check->verified == 1) {
                    $request->validate([
                        'subscription' => 'required'
                    ]);
                    $check_enable = subscription::find($request->subscription)
                        ->where('status', 1);
                    if ($check_enable) {
                        $check = usersubscription::where([
                            ['user_id', $request->id],
                            ['status', 1]
                        ])->first();
                        if (!$check) {
                            $check_trail = subscription::where('name', 'trail')
                                ->orWhere('name', 'Trail')
                                ->orWhere('name', 'TRAIL')
                                ->first();
                            if ($check_trail && $request->subscription == $check_trail->id) {
                                $check_trail_user = usersubscription::where([
                                    ['user_id', $request->id],
                                    ["subscription_id", $check_trail->id]
                                ])
                                    ->first();
                                if (!$check_trail_user) {
                                    $upload = [
                                        "user_id" => $request->id,
                                        "subscription_id" => $request->subscription,
                                        "name" => "trail",
                                        "status" => 1
                                    ];
                                    if ($this->uploadmethod($upload)) {
                                        return redirect()->route('user-subs-view');
                                    }
                                    return back()->with("status", 'Server Error');
                                }
                                return back()->with('status', 'Can not apply for trail');
                            } else {
                                $request->validate([
                                    'method' => 'required'
                                ]);
                                if ($request->method == "stripe" || $request->method == "Stripe" || $request->method == "STRIPE") {
                                    $check_stripe = PaymentMethod::where([
                                        ['name', 'stripe'],
                                        ['status', 1]
                                    ])
                                        ->orWhere([
                                            ['name', 'Stripe'],
                                            ['status', 1]
                                        ])
                                        ->orWhere([
                                            ['name', 'Stripe'],
                                            ['status', 1]
                                        ])
                                        ->first();
                                    if ($check_stripe) {
                                        $validator = Validator::make($request->all(), [
                                            'card_no' => 'required|min:16|numeric',
                                            'exp_month' => 'required|min:1|numeric',
                                            'exp_year' => 'required|min:4|numeric',
                                            'cvv' => 'required|min:3|numeric',
                                            'amount' => 'required|numeric'
                                        ]);
                                        if ($validator->fails()) {
                                            return back()->with("status", 'Fill card info correctly');
                                        }
                                        $pay = PaymentController::stripePayment($request->all());
                                        if ($pay->original["status"]) {
                                            $upload = [
                                                "user_id" => $request->id,
                                                "name" => "stripe",
                                                "subscription_id" => $request->subscription,
                                                "type" => "card",
                                                "amount" => $pay->original["payment"]["amount"],
                                                "key_id" => $pay->original["payment"]["key_id"],
                                                "key_secret" => $pay->original["payment"]["key_secret"],
                                                "status" => 1
                                            ];
                                            if ($this->uploadmethod($upload)) {
                                                return redirect()->route('user-subs-view');
                                            }
                                            return back()->with("status", 'Server Error');
                                        } else {
                                            return back()->with('status', $pay->original["cart_details"]);
                                        }
                                    }
                                    return back()->with('status', 'stripe is not enable');
                                }
                                if ($request->method == "bank" || $request->method == "Bank" || $request->method == "BANK") {
                                    $check_bank = PaymentMethod::where([
                                        ['name', 'bank'],
                                        ['status', 1]
                                    ])
                                        ->orWhere([
                                            ['name', 'Bank'],
                                            ['status', 1]
                                        ])
                                        ->orWhere([
                                            ['name', 'BANK'],
                                            ['status', 1]
                                        ])
                                        ->first();
                                    if ($check_bank) {
                                        $validator = Validator::make($request->all(), [
                                            'amount' => 'required|numeric',
                                            'bankinfo' => 'required',
                                        ]);
                                        if ($validator->fails()) {
                                            return back()->with("status", 'Fill bank info correctly');
                                        }
                                        if ($request->hasFile('image')) {
                                            $check_bank = BankApproval::where([
                                                ['user_id', $request->id],
                                                ['status', 0]
                                            ])->first();
                                            if (!$check_bank) {
                                                $image_name = sha1(date('dmYhis') . microtime('true'));
                                                $image_ext = $request->file('image')->getClientOriginalExtension();
                                                $image = $request->file('image')->move(public_path('storage/images/'), $image_name . '.' . $image_ext);
                                                $image = substr($image, 45);
                                                $upload = [
                                                    "user_id" => $request->id,
                                                    "subscription_id" => $request->subscription,
                                                    "amount" => $request->amount,
                                                    'image' => $image,
                                                    'bank_info' => $request->bankinfo,
                                                    'status' => 0
                                                ];
                                                if (BankApproval::create($upload)) {
                                                    return redirect()->route('user-subs-view');
                                                }
                                                return back()->with('status', 'Server Error');
                                            }
                                            return back()->with('status', 'Can not send request again');
                                        }
                                        return back()->with('status', 'Choose an Image');
                                    }
                                    return back()->with('status', 'Bank is not enable');
                                }
                                if ($request->method == "cash in office" || $request->method == "Cash in office" || $request->method == "Cash In Office" || $request->method == "CASH IN OFFICE") {
                                    $check_cash = PaymentMethod::where([
                                        ['name', 'cash in office'],
                                        ['status', 1]
                                    ])
                                        ->orWhere([
                                            ['name', 'Cash in office'],
                                            ['status', 1]
                                        ])
                                        ->orWhere([
                                            ['name', 'Cash In Office'],
                                            ['status', 1]
                                        ])
                                        ->orWhere([
                                            ['name', 'CASH IN OFFICE'],
                                            ['status', 1]
                                        ])
                                        ->first();
                                    if ($check_cash) {
                                        $validator = Validator::make($request->all(), [
                                            'amount' => 'required|numeric',
                                        ]);
                                        if ($validator->fails()) {
                                            return back()->with("status", 'Fill Cash info correctly');
                                        }
                                        $upload = [
                                            "user_id" => $request->id,
                                            "name" => "Cash",
                                            "subscription_id" => $request->subscription,
                                            "amount" => $request->amount,
                                            "status" => 1
                                        ];
                                        if ($this->uploadmethod($upload)) {
                                            return redirect()->route('user-subs-view');
                                        }
                                        return back()->with("status", 'Server Error');
                                    }
                                    return back()->with("status", 'cash is not enable');
                                }
                            }
                        }
                        return back()->with('status', 'Already Subscribed');
                    }
                    return back()->with('status', 'Subscripton is not Enable');
                }
                return back()->with('status', 'User email is not varified');
            }
            return back()->with('status', 'User is not Landlord');
        }
        return response()->json(["data" => [["error" => "unauthenticated"], 401]]);
    }
    public function manageBankApproval(Request $request)
    {
        $select = BankApproval::select(
            'bank_transfer_approval.id as id',
            'users.name as user_name',
            'subscriptions.name as subs_name',
            'bank_transfer_approval.status'
        )
            ->join('users', 'users.id', '=', 'bank_transfer_approval.user_id')
            ->join('subscriptions', 'subscriptions.id', '=', 'bank_transfer_approval.subscription_id');
        if ($request->status != "") {
            $select = $select->where('bank_transfer_approval.status', $request->status);
        }
        if ($request->search != "") {
            $select = $select->where('users.name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('subscriptions.name', 'LIKE', '%' . $request->search . '%');
        }
        $select = $select->orderbyDesc('id')
            ->paginate(5);
        return view('user-subscription.approval', compact('select'));
    }
    public function manageBankApprovalDetail(Request $request)
    {
        $select = BankApproval::select(
            'bank_transfer_approval.id as id',
            'users.name as name',
            'users.email as email',
            'subscriptions.name as subs_name',
            'subscriptions.period',
            'subscriptions.type',
            'bank_transfer_approval.amount',
            'bank_transfer_approval.image',
            'bank_transfer_approval.status',
            'bank_transfer_approval.bank_info'
        )
            ->join('users', 'users.id', 'bank_transfer_approval.user_id')
            ->join('subscriptions', 'subscriptions.id', 'bank_transfer_approval.subscription_id')
            ->where('bank_transfer_approval.id', $request->id)
            ->first();
        return view('user-subscription.approval-detail', compact('select'));
    }
    public function approve(Request $request)
    {
        $check = BankApproval::find($request->id);
        if ($check->status != 1) {
            $upload = [
                "user_id" => $check->user_id,
                "name" => "bank",
                "subscription_id" => $check->subscription_id,
                "amount" => $check->amount,
                "status" => 1
            ];
            if ($this->uploadmethod($upload)) {
                $check->status = 1;
                $check = $check->save();
                $user = User::find($upload['user_id']);
                $data = [
                    "email" => $user->email,
                    "name" => $user->name,
                    "subject" => "Request Approved",
                    "body" => "Your request is approved, Thanks you for choosing us."
                ];
                MailController::mail($data);
                return redirect()->route('user-subs-approval-view');
            }
            return back()->with("status", 'Server Error');
        }
        return back()->with('status', 'Already Approved');
    }
    public function select(Request $request)
    {
        if ($request->expectsJson() && Auth::user()->user_type_id == 1) {
            $select = usersubscription::join('subscriptions', 'subscriptions.id', 'user_subscriptions.subscription_id')
                ->where([
                    ['user_id', Auth::user()->id],
                    ['user_subscriptions.status', 1]
                ])
                ->first();
            if ($select) {
                $current_date = date_create(date('d-m-Y'));
                $expiry_date = date_create($select->expiry_date);
                $date = date_diff($current_date, $expiry_date);
                $data = [
                    "id" => $select->id,
                    "subscription" => $select->name,
                    "period" => "$select->period $select->type",
                    "expiry_date" => $select->expiry_date,
                    "days_left" => $date->format('%a'),
                ];
                return response()->json(["status" => true, "data" => [$data]]);
            }
            return response()->json(["data" => [["error" => "did not subscribe yet"]]]);
        }
        if (Auth::user()->user_type_id == 7) {
            $select = usersubscription::select(
                'user_subscriptions.id as id',
                'user_subscriptions.user_id as user_id',
                'users.name as name',
                'users.email',
                'subscriptions.name as subscription',
                'user_subscriptions.expiry_date',
                'user_subscriptions.status'
            )
                ->join('subscriptions', 'subscriptions.id', 'user_subscriptions.subscription_id')
                ->join('users', 'user_subscriptions.user_id', 'users.id')
                ->orderbyDesc('id');
            if ($request->column != "" && $request->search != "") {
                $select = $select->where($request->column, 'LIKE', '%' . $request->search . '%');
            }
            $select = $select->paginate(6);
            $current_date = date_create(date('d-m-Y'));
            $expiryDate = [];
            foreach ($select as $value) {
                $expiry_date = date_create($value->expiry_date);
                $expiry = date_diff($current_date, $expiry_date);
                array_push($expiryDate, [
                    "id" => $value->id,
                    "expiry_date" => (int)$expiry->format('%R%a')
                ]);
            }
            if ($select->count() <= 0) {
                $select = User::select(
                    'users.id as user_id',
                    'users.name as name',
                    'users.email'
                )
                    ->where($request->column, 'LIKE', '%' . $request->search . '%')
                    ->paginate(6);
            }
            return view('user-subscription.manage', compact('select', 'expiryDate'));
        }
        return response()->json(["data" => [["error" => "unauthenticated"], 401]]);
    }
    public function detail(Request $request)
    {
        $check = usersubscription::find($request->id);
        if ($check) {
            $select = usersubscription::select(
                'users.name as username',
                'users.email',
                'subscriptions.name as subscription',
                'subscriptions.type',
                'subscriptions.period',
                'payment_gateway.name',
                'user_subscriptions.status',
                'payment_gateway.type as gate_type',
                'payments.amount'
            )
                ->join('users', 'users.id', '=', 'user_subscriptions.user_id')
                ->join('subscriptions', 'subscriptions.id', '=', 'user_subscriptions.subscription_id')
                ->join('payments', 'payments.id', '=', 'user_subscriptions.payment_id')
                ->join('payment_gateway', 'payment_gateway.id', '=', 'payments.gateway_id')
                ->where('user_subscriptions.id', $request->id)
                ->first();
            if ($select) {
                return view('user-subscription.detail', compact('select'));
            }
            return back()->with('status', 'Not Found');
        }
    }
    public function softdelete(Request $request)
    {
        $check = usersubscription::find($request->id);
        if ($check) {
            $check->status = $request->val;
            if ($check->save()) {
                if ($check->status == 1) {
                    return back()->with('status', 'Enabled');
                }
                return back()->with('status', 'Disabled');
            }
            return back()->with('status', 'Can not updated');
        }
        return back()->with('status', 'Not Found');
    }
    public function update(Request $request)
    {
        $check = usersubscription::where("status", 1)
            ->get();
        if ($check) {
            $current_date = Carbon::now();
            foreach ($check as $value) {
                $expiry_date = Carbon::parse($value->expiry_date);
                $date_diff = $current_date->diffInDays($expiry_date);
                if ($date_diff == 10) {
                    $user = User::find($value->user_id);
                    $data = [
                        "email" => $user->email,
                        "name" => $user->name,
                        "subject" => "Reminder",
                        "body" => "Your package will be expire in $date_diff days"
                    ];
                    MailController::mail($data);
                }
                if ($date_diff == 1) {
                    $user = User::find($value->user_id);
                    $data = [
                        "email" => $user->email,
                        "name" => $user->name,
                        "subject" => "Reminder",
                        "body" => "Your package will be expire in $date_diff days"
                    ];
                    MailController::mail($data);
                }
                $compare_date = $current_date->gte($expiry_date);
                if ($compare_date) {
                    $user = User::find($value->user_id);
                    $data = [
                        "email" => $user->email,
                        "name" => $user->name,
                        "subject" => "Package Expired",
                        "body" => "Your package is expired please subscribe a new one"
                    ];
                    $value->status = 0;
                    $value->save();
                    $appr = BankApproval::where([
                        ['user_id', $value->user_id],
                        ['status', 1]
                    ])
                        ->update(['status', 0]);
                    MailController::mail($data);
                }
            }
        }
    }
    private function uploadmethod($input)
    {
        $select = subscription::find($input["subscription_id"]);
        $date = Carbon::now();
        if ($select) {
            if ($select->type == "days") {
                $date = $date->addDays($select->period);
                $date = $date->format('d-m-Y');
                $input += ["expiry_date" => $date];
            } elseif ($select->type == "month") {
                $date = $date->addMonthNoOverflow($select->period);
                $date = $date->format('d-m-Y');
                $input += ["expiry_date" => $date];
            }
            if ($gateway = PaynetGateway::create($input)) {
                $input += ["gateway_id" => $gateway->id];
                if ($pay = Payment::create($input)) {
                    $input += ["payment_id" => $pay->id];
                    if (usersubscription::create($input)) {
                        return true;
                    }
                    return false;
                }
                return false;
            }
            return false;
        }
    }
    public function approvalImage(Request $request)
    {
        $path = $request->path;
        return view('user-subscription.approval-img', compact('path'));
    }
}
