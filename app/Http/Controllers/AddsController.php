<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Adds;
use App\Models\AdsImages;
use App\Models\city;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\currency;
use App\Models\Image;
use App\Models\State;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AddsController extends Controller
{

    protected $property;
    protected $address;
    protected $image;
    public function __construct()
    {
        $this->property = new Adds();
        $this->address = new Address();
        $this->image = new AdsImages();
    }
    public function webselect()
    {
        $select = $this->property::select(
            'adds.id',
            'adds.rent',
            'currency.currency as currency_name',
            'adds.description',
            'adds.for_type',
            'adds.type'
        )->join('currency', 'adds.currency_id', 'currency.id')->paginate(6);
        $select_images = $this->image::all();
        return view('web.home', compact('select', 'select_images'));
    }
    public function indexrequestforad()
    {
        $date = (int)date('Y');
        $currency = currency::all();
        $state = State::select('state')->where('status', 1)->get();
        $country = Country::select('id', 'country')
            ->where('status', 1)
            ->get();

        return view('web.requestforad', compact('date', 'currency', 'state', 'country'));
    }
    public function webadsdetails(Request $request)
    {
        $select = $this->property::select(
            'adds.id',
            'adds.name as ad_name',
            'address.street',
            'adds.description',
            'adds.rent',
            'currency.currency as currency_name',
            'adds.bed_rooms',
            'adds.bath_rooms',
            'adds.toilets',
            'adds.year_build',
            'address.state',
            'address.city',
            'address.zip_code',
            'adds.owner',
            'adds.owner_email',
            'adds.owner_phone'
        )
            ->join('address', 'address.id', 'adds.address_id')
            ->join('currency', 'adds.currency_id', 'currency.id')
            ->where('adds.id', $request->id)
            ->first();
        $select_images = $this->image::all();
        return view('web.adds', compact('select', 'select_images'));
    }
    public function index(Request $request)
    {
        $date = (int)date('Y');
        $currency = currency::all();
        $country = Country::select('id', 'country')
            ->where('status', 1)
            ->get();
        $state = State::select('state')->where('status', 1)->get();
        return view('adds.add', compact('date', 'currency', 'state', 'country'));
    }
    public function store(Request $request)
    {
        $upload = [
            "name" => $request->property_name,
            "bed_rooms" => $request->bed_rooms,
            "bath_rooms" => $request->bath_rooms,
            "toilets" => $request->toilets,
            "description" => $request->description,
            "currency_id" => $request->currency_id,
            "rent" => $request->rent,
            "for_type" => $request->for,
            "year_build" => "$request->build_year-$request->build_month-$request->build_date",
            "type" => $request->type,
            'country' => $request->country,
            "city" => $request->city,
            "state" => $request->state,
            "street" => $request->street,
            "zip_code" => $request->zip_code,
            "owner" => $request->owner_name,
            "owner_email" => $request->owner_email,
            "owner_phone" => $request->owner_phone,
            "status" => 1,
            'approval' => 1
        ];
        $this->address = $this->address->create($upload);
        $upload += [
            "address_id" => $this->address->id,
        ];
        $this->property = $this->property->create($upload);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $value) {
                $image_name = sha1(date('dmYhis') . microtime('true'));
                $image_ext = $value->extension();
                $image_fullname = $image_name . "." . $image_ext;
                $value->move(public_path("storage/images"), $image_fullname);
                $dir = "storage/images/$image_fullname";
                $upload = [
                    "property_id" => $this->property->id,
                    "name_dir" => $dir,
                ];
                $this->image = $this->image->create($upload);
            }
        }

        return redirect()->route('add.manage');
    }

    public function webstore(Request $request)
    {
        $upload = [
            "name" => $request->property_name,
            "bed_rooms" => $request->bed_rooms,
            "bath_rooms" => $request->bath_rooms,
            "toilets" => $request->toilets,
            "description" => $request->description,
            "currency_id" => $request->currency_id,
            "rent" => $request->rent,
            "for_type" => $request->for,
            "year_build" => "$request->build_year-$request->build_month-$request->build_date",
            "type" => $request->type,
            "country" => $request->country,
            "city" => $request->city,
            "state" => $request->state,
            "street" => $request->street,
            "zip_code" => $request->zip_code,
            "owner" => $request->owner_name,
            "owner_email" => $request->owner_email,
            "owner_phone" => $request->owner_phone,
            "status" => 1,
            'approval' => 0
        ];
        $this->address = $this->address->create($upload);
        $upload += [
            "address_id" => $this->address->id,
        ];
        $this->property = $this->property->create($upload);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $value) {
                $image_name = sha1(date('dmYhis') . microtime('true'));
                $image_ext = $value->extension();
                $image_fullname = $image_name . "." . $image_ext;
                $value->move(public_path("storage/images"), $image_fullname);
                $dir = "storage/images/$image_fullname";
                $upload = [
                    "property_id" => $this->property->id,
                    "name_dir" => $dir,
                ];
                $this->image = $this->image->create($upload);
            }
        }
        return back()->with('status', 'Your request has been send');
    }
    public function select(Request $request)
    {
        $column = base64_decode($request->input('ptn'));
        $search = $request->input('pts');
        $name = $request->input('name');
        $rent_min = $request->input('rent_min');
        $rent_max = $request->input('rent_max');
        $city = $request->input('city');
        $state = $request->input('state');
        $zip_code = $request->input('zip_code');
        $user_id = $request->input('user_id');
        $select = DB::table('adds')
            ->select(
                'adds.id AS id',
                'adds.name AS name',
                'adds.currency_id',
                'adds.rent AS rent',
                'address.city AS city',
                'address.state AS state',
                'adds.status as status',
                'adds.approval as approval'
            )
            ->join('address', 'address.id', 'adds.address_id');
        $currency = DB::table('currency')->get();
        if ($request->expectsJson()) {
            if ($name != "") {
                $select = $select->where('name', 'LIKE', '%' . $name . '%');
            }
            if ($rent_min != "" && $rent_max != "") {
                $select = $select->whereBetween('rent', [$rent_min, $rent_max]);
            } else if ($rent_min != "") {
                $select = $select->where('rent', '>=', $rent_min);
            } else if ($rent_max != "") {
                $select = $select->where('rent', '<=', $rent_max);
            }
            if ($city != "") {
                $select = $select->where('city', '=', $city);
            }
            if ($state != "") {
                $select = $select->where('state', '=', $state);
            }
            if ($zip_code != "") {
                $select = $select->where('address.zip_code', '=', $zip_code);
            }
            if ($user_id != "") {
                $select = $select->where('user_id', '=', $user_id);
            }
            if (Auth::user()->user_type_id == 1) {
                $select = $select->where([
                    ['user_id', Auth::user()->id],
                    ['status', 1]
                ]);
            }
            if (Auth::user()->user_type_id == 2) {
                $select = $select->where('status', 1);
            }
            $select = $select->orderByDesc('id')->get();
            if ($select) {
                $image = $this->image::all();
                $data = [];
                foreach ($select as $value) {
                    $temp = [];
                    $count = 0;
                    foreach ($image as $row) {
                        if ($value->id == $row->property_id && $count == 0) {
                            array_push($temp, ["id" => $row->id, "path" => $row->name_dir]);
                            $count++;
                        }
                    }
                    $currencyVal = "";
                    foreach ($currency as  $row) {
                        if ($row->id == $value->currency_id) {
                            $currencyVal = $row->currency;
                        }
                    }
                    $rentval = $currencyVal ? "$value->rent $currencyVal" : "$value->rent AUD";
                    array_push($data, [
                        "id" => $value->id,
                        "name" => $value->name,
                        "rent" => $rentval,
                        "city" => $value->city,
                        "state" => $value->state,
                        "status" => $value->status,
                        "images" => $temp
                    ]);
                }
                return response()->json(["property_data" => $data]);
            }
            return response()->json(["error" => "no data found"]);
        } else {
            if ($select) {
                if ($column != "" && $search != "") {
                    if ($column == "name") {
                        $select = $select->where($column, 'LIKE', '%' . $search . '%');
                    } elseif ($column == "rent_min") {
                        $select = $select->where('rent', '>=', $search);
                    } elseif ($column == "rent_max") {
                        $select = $select->where('rent', '<=', $search);
                    } else {
                        $select = $select->where($column, $search);
                    }
                }
                if ($request->status != "") {
                    $select = $select->where('adds.status', $request->status);
                }
                $select = $select->orderByDesc('id')->paginate(6);
                return view('adds.manage', compact('select', 'currency'));
            }
            $status = "No Data Found";
            return view('adds.manage', compact('status'));
        }
    }

    // delete property
    public  function delete(Request $request)
    {
        $adds = Adds::find($request->id);
        if ($adds) {
            if ($adds->address_id) {
                $address = Address::find($adds->address_id);
                if ($address) {
                    $images = AdsImages::where('property_id', $adds->id)->get();
                    foreach ($images as $value) {
                        $value->delete();
                    }
                    $adds->delete();
                    $address->delete();

                    return back()->with('status', "Deleted");
                }
            }
        }
        if ($request->expectsJson()) {
            return response()->json([
                "status" => false,
                "message" => 'Not found'
            ]);
        } else {
            return back()->with('status', "Not Found");
        }
    }

    // delete property
    public  function approval(Request $request)
    {
        $property = Adds::find($request->id);
        if ($property) {
            if ($property->approval == 0) {
                $property->approval = 1;
                $property->save();

                if ($request->expectsJson()) {
                    return response()->json([
                        "status" => true,
                    ]);
                } else {
                    return back()->with('status', "Enabled");
                }
            }
        }
        if ($request->expectsJson()) {
            return response()->json([
                "status" => false,
                "message" => 'Not found'
            ]);
        } else {
            return back()->with('status', "Not Found");
        }
    }
    // select specific property
    public function selectspecific(Request $request)
    {
        $select = DB::table('adds')
            ->select(
                'adds.id AS id',
                'adds.name AS name',
                'adds.bed_rooms',
                'adds.bath_rooms',
                'adds.toilets',
                'adds.description',
                'adds.currency_id',
                'adds.rent AS rent',
                'adds.for_type as for',
                'adds.year_build AS yearbuild',
                'adds.type as type',
                'address.country as country',
                'address.city AS city',
                'address.state AS state',
                'address.street AS street',
                'address.zip_code AS zipcode',
                'adds.owner',
                'adds.owner_email',
                'adds.owner_phone'
            )
            ->join('address', 'address.id', 'adds.address_id')
            ->where('adds.id', $request->id)
            ->orderByDesc('id')->get();
        if ($select) {
            $image = $this->image::all();
            $features = DB::table('features_to_property')
                ->select('features_to_property.id', 'features_to_property.property_id', 'features.feature')
                ->join('features', 'features_to_property.features_id', 'features.id')
                ->get();
            $currency = DB::table('currency')->get();
            $data = [];
            foreach ($select as $value) {
                $imgTemp = [];
                foreach ($image as $row) {
                    if ($value->id == $row->property_id) {
                        array_push($imgTemp, ["id" => $row->id, "path" => $row->name_dir]);
                    }
                }
                $currencyVal = "";
                foreach ($currency as $row) {
                    if ($row->id == $value->currency_id) {
                        $currencyVal = $row->currency;
                    }
                }
                $rentval = $currencyVal ? "$value->rent $currencyVal" : "$value->rent AUD";
                if ($request->expectsJson()) {
                    array_push($data, [
                        "id" => $value->id,
                        "name" => $value->name,
                        "bed_rooms" => $value->bed_rooms,
                        "bath_rooms" => $value->bath_rooms,
                        "toilets" => $value->toilets,
                        "description" => $value->description,
                        "rent" => $rentval,
                        "for" => $value->for,
                        "currency" => $currencyVal,
                        "year_build" => $value->yearbuild,
                        "type" => $value->type,
                        "country" => $value->country,
                        "city" => $value->city,
                        "state" => $value->state,
                        "street" => $value->street,
                        "zip_code" => $value->zipcode,
                        "owner" => $value->owner,
                        "owner_email" => $value->owner_email,
                        "owner_phone" => $value->owner_phone,
                        "images" => $imgTemp
                    ]);
                    return response()->json(["property_data" => $data]);
                } else {
                    array_push($data, [
                        "id" => $value->id,
                        "name" => $value->name,
                        "bed_rooms" => $value->bed_rooms,
                        "bath_rooms" => $value->bath_rooms,
                        "toilets" => $value->toilets,
                        "description" => $value->description,
                        "rent" => $rentval,
                        "for" => $value->for,
                        "currency" => $currencyVal,
                        "year_build" => $value->yearbuild,
                        "type" => $value->type,
                        "country" => $value->country,
                        "city" => $value->city,
                        "state" => $value->state,
                        "street" => $value->street,
                        "zip_code" => $value->zipcode,
                        "owner" => $value->owner,
                        "owner_email" => $value->owner_email,
                        "owner_phone" => $value->owner_phone,
                        "images" => $imgTemp
                    ]);
                    return view('adds.edit', compact('data'));
                }
            }
        }
    }
    public function editImages(Request $request)
    {
        $id = $request->id;
        $select = $this->image::select('id', 'name_dir')->where('property_id', $id)->get();
        return view('adds.editImages', compact('select', 'id'));
    }
    // update property image
    public function updateimage(Request $request)
    {
        $this->image->property_id = $request->input('property_id');
        $result = $this->image::where('property_id', $this->image->property_id)->get();

        if ($request->has('images') || $request->expectsJson()) {
            $fetch = [];
            foreach ($result as $row) {
                array_push($fetch, $row->id);
            }
            $fetch_count = count($fetch);
            $image_count = count($request->images);
            if ($image_count > $fetch_count) {
                $update_result = [];
                for ($i = 0; $i < $image_count; $i++) {
                    if ($i < $fetch_count) {
                        if ($request->expectsJson()) {
                            $image_name = explode('.', $request->images[$i]["name"]);
                            $extension = end($image_name);
                            $image_data = base64_decode($request->images[$i]["image"]);
                            $image_Name = sha1(date('dmYhis') . microtime('true'));
                            $filename = "$image_Name.$extension";
                            $upload = file_put_contents(public_path("storage/images/$filename"), $image_data);
                            $dir = "storage/images/$filename";
                        } else {
                            $image_name = sha1(date('dmYhis') . microtime('true'));
                            $extension = $request->file('images')[$i]->getClientOriginalExtension();
                            $request->file('images')[$i]->move(public_path("storage/images"), "$image_name.$extension");
                            $dir = "storage/images/$image_name.$extension";
                        }
                        $this->image = $this->image::find($fetch[$i]);
                        $this->image->name_dir = $dir;
                        if (File::exists($this->image->name_dir)) {
                            unlink($this->image->name_dir);
                        }
                        $upload = $this->image->save();
                    } else {
                        if ($request->expectsJson()) {
                            $image_name = explode('.', $request->images[$i]["name"]);
                            $extension = end($image_name);
                            $image_data = base64_decode($request->images[$i]["image"]);
                            $image_Name = sha1(date('dmYhis') . microtime('true'));
                            $filename = "$image_Name.$extension";
                            $upload = file_put_contents(public_path("storage/images/$filename"), $image_data);
                            $dir = "storage/images/$filename";
                        } else {

                            $image_name = sha1(date('dmYhis') . microtime('true'));
                            $extension = $request->file('images')[$i]->getClientOriginalExtension();
                            $request->file('images')[$i]->move(public_path("storage/images"), "$image_name.$extension");
                            $dir = "storage/images/$image_name.$extension";
                        }
                        $upload = $this->image->create(["property_id" => $this->image->property_id, "name_dir" => $dir]);
                    }
                }
                if ($request->expectsJson()) {
                    return response()->json(["data" => ["status" => "true"]]);
                } else {
                    return redirect("ads/edit/images/$request->property_id")->with('status', 'Updated');
                }
            } else {
                for ($i = 0; $i < $fetch_count; $i++) {
                    if ($i < $image_count) {
                        if ($request->expectsJson()) {
                            $image_name = explode('.', $request->images[$i]["name"]);
                            $extension = end($image_name);
                            $image_data = base64_decode($request->images[$i]["image"]);
                            $image_Name = sha1(date('dmYhis') . microtime('true'));
                            $filename = "$image_Name.$extension";
                            $upload = file_put_contents(public_path("storage/images/$filename"), $image_data);
                            $dir = "storage/images/$filename";
                        } else {
                            $image_name = sha1(date('dmYhis') . microtime('true'));
                            $extension = $request->file('images')[$i]->getClientOriginalExtension();
                            $request->file('images')[$i]->move(public_path("storage/images"), "$image_name.$extension");
                            $dir = "storage/images/$image_name.$extension";
                        }
                        $this->image = $this->image::find($fetch[$i]);
                        if (File::exists($this->image->name_dir)) {
                            unlink($this->image->name_dir);
                        }
                        $this->image->name_dir = $dir;
                        $upload = $this->image->save();
                    } else {
                        $this->image = $this->image::find($fetch[$i]);
                        if (File::exists($this->image->name_dir)) {
                            unlink($this->image->name_dir);
                        }
                        $this->image->delete();
                    }
                }
                if ($request->expectsJson()) {
                    return response()->json(["data" => ["status" => "true"]]);
                } else {
                    return redirect("ads/edit/images/$request->property_id")->with('status', 'Updated');
                }
            }
        } else {
            return redirect("ads/edit/images/$request->property_id")->with('status', 'Please pick an image');
        }
    }
    public function editinfo(Request $request)
    {
        $id = $request->id;
        $property = Adds::find($id);
        $currency = currency::all();
        return view('adds.editinfo', compact('id', 'property', 'currency'));
    }
    // update property info
    public function updateinfo(Request $request)
    {
        $request->validate([
            'property_name' => 'required',
            'bed_rooms' => 'required|numeric',
            'bath_rooms' => 'required|numeric',
            'description' => 'required',
            'currency_id' => 'required|numeric',
            'rent' => 'required|numeric',
            'for' => 'required|alpha|min:4|max:4',
            'build_year' => 'required|numeric|min:4',
            'build_month' => 'required|numeric',
            'build_date' => 'required|numeric',
        ]);
        $upload = [
            "name" => $request->property_name,
            "bed_rooms" => $request->bed_rooms,
            "bath_rooms" => $request->bath_rooms,
            "description" => $request->description,
            "currency_id" => $request->currency_id,
            "rent" => $request->rent,
            "for_type" => $request->for,
            "year_build" => $request->build_year . "-" . $request->build_month . "-" . $request->build_date,
            "type" => $request->type
        ];
        $property = $this->property::find($request->id);
        if ($property->update($upload)) {
            return redirect()->route("adds.selectspecific", ["id" => $request->id]);
        }
    }

    // edit property address
    public function editaddress(Request $request)
    {
        $id = $request->id;
        $property_address = $this->property::select(
            'address.id as id',
            'address.country as country',
            'address.city as city',
            'address.state as state',
            'address.street as street',
            'address.zip_code as zip_code'
        )
            ->join('address', 'adds.address_id', 'address.id')
            ->where('adds.id', $id)
            ->first();

        $country = Country::select('id', 'country')
            ->where('status', 1)
            ->get();
        $state = State::select('id', 'state')->where('status', 1)->get();
        $city = city::select('city as city')->join('states', 'cities.state_id', 'states.id')->where('states.state', $property_address->state)->get();
        // dd($city);
        return view('adds.editaddress', compact('id', 'property_address', 'city', 'state', 'country'));
    }

    // update property address
    public function updateaddress(Request $request)
    {
        $request->validate([
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'street' => 'required',
            'zip_code' => 'required'
        ]);
        $upload = [
            'country' => $request->country,
            "state" => $request->state,
            "city" => $request->city,
            "street" => $request->street,
            "zip_code" => $request->zip_code,
        ];
        // dd($request->id);
        $property = $this->property::find($request->id);
        $property_address = $this->address::find($property->address_id);
        if ($property_address->update($upload)) {
            return redirect()->route("adds.selectspecific", ["id" => $request->id]);
        }
    }
    public function editowner(Request $request)
    {
        $id = $request->id;
        $ads_owner = $this->property::find($request->id);
        return view('adds.editowner', compact('id', 'ads_owner'));
    }
    public function updateowner(Request $request)
    {
        $ad_owner = $this->property::find($request->id);
        $upload = [
            "owner" => $request->owner_name,
            "owner_email" => $request->owner_email,
            "owner_phone" => $request->owner_phone,
        ];
        if ($ad_owner->update($upload)) {
            return redirect()->route("adds.selectspecific", ["id" => $request->id]);
        }
    }
}
