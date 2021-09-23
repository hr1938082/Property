<?php

namespace App\Http\Controllers;

use App\Models\BankApproval;
use App\Models\code;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\User_type;
use App\Models\usersubscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Tendent;
use Exception;

class UserController extends Controller
{
    protected $user;
    function __construct()
    {
        $this->user = new User();
    }
    // User Login Method
    public function login(Request $request)
    {
        $Login = $this->user::where([['email', $request->email], ['status', 1]])->first();
        if ($Login && Hash::check($request->password, $Login->password)) {
            $data = [
                "id" => $Login->id,
                "name" => $Login->name,
                "user_type_id" => $Login->user_type_id,
                "email" => $Login->email,
                "verified" => $Login->verified,
                "mobile" => $Login->mobile,
                "address" => $Login->address,
                "image" => $Login->image,
            ];
            $token = $Login->createToken('my-app-token')->plainTextToken;
            if ($Login->user_type_id == 1) {
                $select = usersubscription::where([
                    ['user_id', $Login->id],
                    ['status', 1]
                ])
                    ->first();
                if (!$select) {
                    $data += ['subscription' => 0];
                } else {
                    $data += ['subscription' => 1];
                }
                $select_approve = BankApproval::where([
                    ["user_id", $Login->id],
                ])
                    ->orderbyDesc('id')
                    ->get();
                if ($select_approve && $select_approve->count() > 0) {
                    if ($select_approve[0]->status == 1) {
                        $data += ['approval' => 'approved'];
                    } elseif ($select_approve[0]->status == 0) {
                        $data += ['approval' => 'pending'];
                    }
                } else {
                    $data += ['approval' => 'not applied'];
                }
            }
            if ($Login->user_type_id == 2) {
                $select = Tendent::select('properties.user_id')
                    ->join('properties', 'tendent_to_property.property_id', 'properties.id')
                    ->where([
                        ['tendent_id', $Login->id],
                        ['is_live', 1]
                    ])
                    ->first();
                if ($select) {
                    $check_subs = usersubscription::where([
                        ['user_id', $select->user_id],
                        ['status', 1]
                    ])
                        ->first();
                    if (!$check_subs) {
                        $data += ['subscription' => 0];
                    } else {
                        $data += ['subscription' => 1];
                    }
                }
            }
            return response()->json(["data" => $data, "token" => $token]);
        }
        return response()->json(["data" => [["error" => "Email or Password Does not match"]]]);
    }
    // User Add Method
    public function register(Request $request)
    {
        $Login = $this->user::where('email', $request->input('email'))->first();
        if (!$Login) {
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
            return response()->json(["data" => ["register" => "sucessfull"]]);
        }
        return response()->json(["data" => [["error" => "email already exists"]]]);
    }
    // User Stat Update
    public function userStatUpdate(Request $request)
    {
        $column = $request->column;
        $search = $request->search;
        $page = $request->page;
        $id = $request->id;
        $user = User::find($id);
        if ($user->status == 1) {
            $user->status = 0;
            $user->save();
        } else {
            $user->status = 1;
            $user->save();
        }
        return redirect("/user/manage?column=$column&search=$search&page=$page");
    }
    // User varificationcode send Method
    public function sendVerificationCode(Request $request)
    {
        $code = (int)substr(rand(), 0, 4);
        $data = [
            "email" => Auth::user()->email,
            "name" => Auth::user()->name,
            "subject" => "Varification Code",
            "body" => "Your Varification Code is: $code"
        ];
        if (Auth::user()->verified == 0 && Auth::user()->code_id == 0) {
            if (MailController::mail($data)) {
                $upload = [
                    "user_id" => Auth::user()->id,
                    "code" => $code,
                    'date_time' => Carbon::now(),
                    'status' => 1
                ];
                $user_code = code::create($upload);
                if ($user_code) {
                    $check = User::find(Auth::user()->id);
                    if ($check) {
                        $check->code_id = $user_code->id;
                        $check->save();
                        return response()->json([
                            "status" => true
                        ]);
                    }
                    return response()->json([
                        "status" => false,
                        "data" => [["error" => "Server Error"]]
                    ]);
                }
                return response()->json([
                    "status" => false,
                    "data" => [["error" => "Server Error"]]
                ]);
            }
            return response()->json([
                "status" => false,
                "data" => [["error" => "Email error"]]
            ]);
        } elseif (Auth::user()->verified == 0 && Auth::user()->code_id > 0) {
            $check = code::where('user_id', Auth::user()->id)->orderbyDesc('id')->get();
            if ($check->count() > 0) {
                $last_time = Carbon::parse($check[0]->date_time);
                $current_time = Carbon::now();
                $time_to_next_code = $last_time->addMinute(1);
                if ($current_time->gte($time_to_next_code)) {
                    if (MailController::mail($data)) {
                        $upload = [
                            "user_id" => Auth::user()->id,
                            "code" => $code,
                            'date_time' => Carbon::now(),
                            'status' => 1
                        ];
                        $user_code = code::create($upload);
                        if ($user_code) {
                            $check = User::find(Auth::user()->id);
                            if ($check) {
                                $check->code_id = $user_code->id;
                                $check->save();
                                return response()->json([
                                    "status" => true
                                ]);
                            }
                            return response()->json([
                                "status" => false,
                                "data" => [["error" => "Server Error"]]
                            ]);
                        }
                        return response()->json([
                            "status" => false,
                            "data" => [["error" => "Server Error"]]
                        ]);
                    }
                    return response()->json([
                        "status" => false,
                        "data" => [["error" => "Email error"]]
                    ]);
                }
                return response()->json([
                    "status" => false,
                    "data" => [["error" => "wait for " . $current_time->diffInSeconds($time_to_next_code) . " seconds"]]
                ]);
            }
        }
        return response()->json([
            "status" => false,
            "data" => [["error" => "Already Verified"]]
        ]);
    }
    // User varificationcode match Method
    public function matchVerificationCode(Request $request)
    {
        $check = code::find(Auth::user()->code_id);
        if ($check) {
            if ($request->code == $check->code) {
                $check = User::find(Auth::user()->id);
                $check->verified = 1;
                $check->save();
                return response()->json([
                    "status" => true,
                ]);
            }
            return response()->json([
                "status" => false,
                "data" => [["error" => "Not Match"]]
            ]);
        }
        return response()->json([
            "status" => false,
            "data" => [["error" => "Code Not Found"]]
        ]);
    }
    // User forgot password code Method
    public function forgotPasswordcode(Request $request)
    {
        $check_email = User::whereEmail($request->email)->first();
        if ($check_email) {
            $code = (int)substr(rand(), 0, 4);
            $data = [
                "email" => $check_email->email,
                "name" => $check_email->name,
                "subject" => "Verification Code",
                "body" => "Your Verification Code is: $code"
            ];
            if ($check_email->code_id == 0) {
                if (MailController::mail($data)) {
                    $upload = [
                        "user_id" => $check_email->id,
                        "code" => $code,
                        'date_time' => Carbon::now(),
                        'status' => 1
                    ];
                    $user_code = code::create($upload);
                    if ($user_code) {
                        $check_email->code_id = $user_code->id;
                        $check_email->save();
                        $request->session()->put('email', $check_email->email);
                        return response()->json([
                            "status" => true
                        ]);
                    }
                    return response()->json([
                        "status" => false,
                        "data" => [["error" => "Server Error"]]
                    ]);
                }
            } elseif ($check_email->code_id > 0) {
                $check = code::where('user_id', $check_email->id)->orderbyDesc('id')->get();
                if ($check->count() > 0) {
                    $last_time = Carbon::parse($check[0]->date_time);
                    $current_time = Carbon::now();
                    $time_to_next_code = $last_time->addMinute(1);
                    if ($current_time->gte($time_to_next_code)) {
                        if (MailController::mail($data)) {
                            $upload = [
                                "user_id" => $check_email->id,
                                "code" => $code,
                                'date_time' => Carbon::now(),
                                'status' => 1
                            ];
                            $user_code = code::create($upload);
                            if ($user_code) {
                                $check_email->code_id = $user_code->id;
                                $check_email->save();
                                $request->session()->put('email', $check_email->email);
                                return response()->json([
                                    "status" => true
                                ]);
                            }
                            return response()->json([
                                "status" => false,
                                "data" => [["error" => "Server Error"]]
                            ]);
                        }
                        return response()->json([
                            "status" => false,
                            "data" => [["error" => "Email error"]]
                        ]);
                    }
                    return response()->json([
                        "status" => false,
                        "data" => [["error" => "wait for " . $current_time->diffInSeconds($time_to_next_code) . " seconds"]]
                    ]);
                }
            }
        }
        return response()->json([
            "status" => false,
            'message' => 'Can not find your email'
        ]);
    }
    // User forgot password match Method
    public function forgotPasswordMatch(Request $request)
    {
        if ($request->session()->has('email')) {
            $email = $request->session()->get('email');
            $check = User::where('email', $email)->first();
            if ($check) {
                $check_code = code::find($check->code_id);
                if ($check_code) {
                    if ($check_code->code == $request->code) {
                        return response()->json([
                            'status' => true,
                            'message' => 'matched'
                        ]);
                    }
                    return response()->json([
                        'status' => false,
                        'message' => 'not matched'
                    ]);
                }
                return response()->json([
                    'status' => false,
                    'message' => 'Not found in code table'
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'not found in user table'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'empty email'
        ]);
    }
    public function forgotPasswordChange(Request $request)
    {
        if ($request->session()->has('email')) {
            $email = $request->session()->get('email');
            $check = User::whereEmail($email)->first();
            if ($check) {
                $password = Hash::make($request->password);
                $check->update(['password', $password]);
                $request->session()->forget('email');
                return response()->json([
                    'status' => true
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'not found in user Table'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'empty email'
        ]);
    }
    // User select Method
    public function select()
    {
        $select = DB::table('users')
            ->join('user_type', 'users.user_type_id', "=", 'user_type.id')
            ->select(
                'users.id',
                'users.name',
                'user_type.name as user_type_name',
                'users.email',
                'users.password',
                'users.mobile',
                'users.address'
            )
            ->orderBy('id', 'asc')
            ->get();
        if ($select) {
            return response()->json($select);
        }
        return response()->json(["data" => ["error" => "no data found"]]);
    }
    // User select specific Method
    public function selectspecific(Request $request)
    {
        $select = DB::table('users')
            ->join('user_type', 'users.user_type_id', "=", 'user_type.id')
            ->select(
                'users.id',
                'users.name',
                'user_type.name as user_type_name',
                'users.email',
                'users.mobile',
                'users.address',
                'users.image'
            )
            ->where('users.id', $request->id)
            ->get();
        if ($select) {
            return response()->json(["data" => $select]);
        }
        return response()->json(["data" => ["error" => "no data found"]]);
    }

    // User select admin method
    public function selectAdmin(Request $req)
    {
        // dd($req);
        $select = DB::table('users')
            ->join('user_type', 'users.user_type_id', "=", 'user_type.id')
            ->select('users.id', 'users.name', 'user_type.name as user_type_name', 'users.email', 'users.status');
        if ($req->input('search') != "" && $req->column != "none") {
            $select = $select->where('users.' . $req->input('column'), 'LIKE', '%' . $req->input('search') . '%')
                ->orderByDesc('users.id')
                ->paginate(6);
            $select = $select->appends(["column" => $req->column, "search" => $req->search]);
        } else {
            $select = $select->orderByDesc('users.id')
                ->paginate(6);
        }

        // ->paginate(7);
        return view('manage-user.manage', compact('select'));
    }
    // User update method
    public function update(Request $req)
    {
        $this->user = $this->user::find($req->input('id'));
        if ($this->user) {
            $get = User::where('email', $req->input('email'))->first();
            if (isset($get)) {
                if (!$get->email || $get->id == $this->user->id) {
                    $this->user->name = $req->input('name');
                    $this->user->email = $req->input('email');
                    $this->user->verified = 0;
                    $this->user->mobile = $req->mobile;
                    $this->user->address = $req->address;
                    $this->user->save();
                    return response()->json(["data" => $this->user]);
                } else {
                    return response()->json(["data" => ["Email not Availabe"]]);
                }
            } else {
                if ($req->email != Auth::user()->email) {
                    $this->user->name = $req->input('name');
                    $this->user->email = $req->input('email');
                    $this->user->verified = 0;
                    $this->user->mobile = $req->mobile;
                    $this->user->address = $req->address;
                    $this->user->save();
                    return response()->json(["data" => $this->user]);
                }
            }
        }
        return response()->json(["Error" => [["error" => "data not found"]]]);
    }
    // User updateimage method
    public function updateimage(Request $req)
    {
        $check = User::find($req->id);
        if ($check && $req->has('image')) {
            $image_name = explode('.', $req->image_name);
            $extension = end($image_name);
            $image_data = base64_decode($req->image);
            $image_Name = sha1(date("dmYhisA"));
            $file_name = $image_Name . '.' . $extension;
            $success = file_put_contents(public_path("storage/images/$file_name"), $image_data);
            $check->update(["image" => "storage/images/$file_name"]);
            return response()->json(["data" => [["image" => "updated"]]]);
        }
        return response()->json(["data" => [["error" => "not found"]]]);
    }
    // User Update Name Admin Method
    public function updateNameAdmin(Request $req)
    {
        $this->user = $this->user::find($req->input('id'));
        if ($this->user) {
            $this->user->name = $req->input('name');
            $this->user->save();
            return redirect()->route('edituser', ['id' => $req->input('id')]);
        }
    }
    // User Update Name Admin Method
    public function updateImageAdmin(Request $request)
    {
        $validator = $request->validate([
            'profile' => 'required|mimes:png,jpg'
        ]);
        $check = User::find($request->id);
        if ($validator && $check) {
            if (File::exists($check->image)) {
                unlink($check->image);
            }
            $upload = $request->file('profile');
            $upload = $upload->store('public/images');
            $upload = "storage/" . substr($upload, 7);
            $check->update(["image" => $upload]);
            return redirect()->route('edituser', ['id' => $request->input('id')]);
        }
    }
    // User Update mobile Admin Method
    public function updatemobileAdmin(Request $req)
    {
        $this->user = $this->user::find($req->input('id'));
        if ($this->user) {
            $this->user->mobile = $req->input('mobile');
            $this->user->save();
            return redirect()->route('edituser', ['id' => $req->input('id')]);
        }
    }
    // User Update address Admin Method
    public function updateaddressAdmin(Request $req)
    {
        $this->user = $this->user::find($req->input('id'));
        if ($this->user) {
            $this->user->address = $req->input('address');
            $this->user->save();
            return redirect()->route('edituser', ['id' => $req->input('id')]);
        }
    }
    // User Update UserType Method
    public function updateUserTypeAdmin(Request $req)
    {
        $this->user = $this->user::find($req->input('id'));
        if ($this->user) {
            $this->user->user_type_id = $req->input('user_type_id');
            $this->user->save();
            return redirect()->route('edituser', ['id' => $req->input('id')]);
        }
    }
    // User Update Email Admin Method
    public function updateEmailAdmin(Request $req)
    {
        $validator = $req->validate([
            "email" => "required|email"
        ]);
        if ($validator && !User::where('email', $req->input('email'))->first()) {
            $this->user = $this->user::find($req->input('id'));
            $this->user->email = $req->input('email');
            $this->user->verified = 0;
            $this->user->save();
            return redirect()->route('edituser', ['id' => $req->input('id'), 'email' => '1']);
        }
        return redirect()->route('edituser', ['id' => $req->input('id'), 'email' => '0']);
    }
    // User update password Method
    public function updatepassword(Request $req)
    {
        $this->user = $this->user::find($req->input('id'));
        if ($this->user) {
            if (Hash::check($req->input('current_password'), $this->user->password)) {
                $this->user->password = Hash::make($req->input('new_password'));
                $this->user->save();
                return response()->json(["data" => [["password_reset" => "sucessfull"]]]);
            }
            return response()->json(["data" => [["error" => "password not matched"]]]);
        }
        return response()->json(["data" => [["error" => "Data Not Found"]]]);
    }
    // User update password Admin Method
    public function updatepasswordAdmin(Request $req)
    {
        $validator = $req->validate(
            ["password" => "required|alpha_num|min:8"]
        );
        if ($validator) {
            $check = User::find($req->id);
            if ($check) {
                $check->password = Hash::make($req->input('password'));
                $check = $check->save();
                return redirect()->route('edituser', ['id' => $req->input('id'), 'password' => '1']);
            }
        }
    }
    // User Check password admin Method
    public function checkpasswordAdmin(Request $req)
    {
        $check = User::find($req->input('id'));
        if ($check && Hash::check($req->input('password'), $check->password)) {
            return "Password Correct";
        }
        return "Password Incorrect";
    }

    public function updateAdmin(Request $request)
    {
        $id = $request->input('id');
        $check = User::find($id);
        $name = User_type::find($check->user_type_id);
        $name = $name->name;
        $usertype = User_type::get();
        $email = $request->input('email');
        $password = $request->input('password');
        return view('manage-user.edit', compact('name', 'usertype', 'id', 'check', 'email', 'password'));
    }
    public function getusertype($id)
    {
        $select = User::select('user_type.name')
            ->join('user_type', 'users.user_type_id', '=', 'user_type.id')
            ->where('users.id', $id)
            ->get();
        return $select;
    }
    // User Logout Method
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(["data" => [["Logout" => "Sucessfully"]]]);
    }
    public function storeAppToken(Request $req)
    {
        try {
            $row = User::find(Auth::user()->id);
            if ($row) {
                $row->app_token = $req->app_token;
                $row->save();
                return response()->json(['status' => true]);
            }
            throw new Exception('Not Found');
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'messages' => $e->getMessage()]);
        }
    }
}
