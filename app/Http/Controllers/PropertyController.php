<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Propety;
use App\Models\Image;
use App\Models\Address;
use App\Models\FeaturesToProperty;
use App\Models\Message;
use App\Models\Rent;
use App\Models\Task;
use App\Models\TaskAssign;
use App\Models\Tendent;
use App\Models\Utility;
use App\Models\UtilityPaid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    protected $property;
    protected $address;
    protected $image;
    public function __construct()
    {
        $this->property = new Propety();
        $this->address = new Address();
        $this->image = new Image();
    }
    // insert property
    public function index()
    {
        $date = (int)date('Y');
        return view('properties.add', compact('date'));
    }
    public function insert(Request $request)
    {
        if ($request->expectsJson()) {
            if (Auth::user()->user_type_id == 1) {
                $input = $request->all();
                $input += ["status" => 1];
                $this->address = $this->address->create($input);
                $input += ["address_id" => $this->address->id];
                $this->property = $this->property->create($input);
                if ($request->has('image')) {
                    foreach ($request->image as $upload_image) {
                        $image_name = explode('.', $upload_image["name"]);
                        $extension = end($image_name);
                        $image_data = base64_decode($upload_image["image"]);
                        $image_Name = (sha1(date('dmYhis') . microtime('true')));
                        $filename = "$image_Name.$extension";
                        file_put_contents(public_path("storage/images/$filename"), $image_data);
                        $dir = "storage/images/$filename";
                        $upload = ["property_id" => $this->property->id, "name_dir" => $dir];
                        $this->image = $this->image->create($upload);
                    }
                    return response()->json(["data" => [["property" => "inserted"]]]);
                } else {
                    return response()->json(["data" => [["property" => "inserted with out image"]]]);
                }
            }
            return response()->json(["data" => [["message" => "unauthenticated"], 401]]);
        } else {
            $upload = [
                "property_name" => $request->property_name,
                "bed_rooms" => $request->bed_rooms,
                "bath_rooms" => $request->bath_rooms,
                "description" => $request->description,
                "rent" => $request->rent,
                "year_build" => "$request->build_year-$request->build_month-$request->build_date",
                "city" => $request->city,
                "state" => $request->state,
                "street" => $request->street,
                "zip_code" => $request->zip_code,
            ];
            $this->address = $this->address->create($upload);
            $upload += [
                "address_id" => $this->address->id,
                "user_id" => Auth::user()->id,
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
            return redirect()->route('manage-properties');
        }
    }
    // update property
    public function update(Request $request)
    {
        $this->property = $this->property::find($request->input('id'));
        if ($this->property) {
            $update = [
                "property_name" => $request->input('property_name'),
                "bed_rooms" => $request->input('bed_rooms'),
                "bath_rooms" => $request->input('bath_rooms'),
                "description" => $request->input('description'),
                "user_id" => $request->input('user_id'),
                "rent" => $request->input('rent'),
                "year_build" => $request->input('year_build')
            ];
            if ($this->property::find($this->property->id)->update($update)) {
                $update = [
                    "city" => $request->input('city'),
                    "state" => $request->input('state'),
                    "street" => $request->input('street'),
                    "zip_code" => $request->input('zip_code')
                ];
                if ($this->address::find($this->property->address_id)->update($update)) {
                    return response()->json(["data" => [["property" => "updated"]]]);
                }
            }
        }
        return response()->json(["data" => [["property" => "not found"]]]);
    }

    public function editImages(Request $request)
    {
        $id = $request->id;
        $select = Image::select('id', 'name_dir')->where('property_id', $id)->get();
        return view('properties.editImages', compact('select', 'id'));
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
                    return redirect("properties/edit/images/$request->property_id")->with('status', 'Updated');
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
                    return redirect("properties/edit/images/$request->property_id")->with('status', 'Updated');
                }
            }
        } else {
            return redirect("properties/edit/images/$request->property_id")->with('status', 'Please pick an image');
        }
    }

    // delete property image
    public function selectimage(Request $request)
    {
        $this->image = $this->image::where('property_id', $request->input('property_id'))->get();
        return response()->json(["data" => $this->image]);
    }

    // delete property image
    public function deleteimage(Request $request)
    {
        $this->image = $this->image::find($request->input('id'));
        $property_id = $this->image->property_id;
        if ($this->image) {
            if (File::exists($this->image->name_dir)) {
                unlink($this->image->name_dir);
            }
            $this->image->delete();
            if ($request->expectsJson()) {
                return response()->json(["data" => ["image" => "deleted"]]);
            } else {
                return redirect("properties/edit/images/$property_id")->with('status', 'Deleted');
            }
        }
        if ($request->expectsJson()) {
            return response()->json(["data" => [["error" => "not found"]]]);
        } else {
            return redirect("properties/edit/images/$property_id");
        }
    }
    // select specific property
    public function selectspecific(Request $request)
    {
        $select = DB::table('properties')
            ->select(
                'properties.id AS id',
                'properties.property_name AS name',
                'properties.bed_rooms',
                'properties.bath_rooms',
                'properties.description',
                'properties.rent AS rent',
                'properties.year_build AS yearbuild',
                'users.name AS username',
                'users.email as user_email',
                'users.mobile as user_mobile',
                'users.image as user_image',
                'address.city AS city',
                'address.state AS state',
                'address.street AS street',
                'address.zip_code AS zipcode'
            )
            ->join('users', 'users.id', 'properties.user_id')
            ->join('address', 'address.id', 'properties.address_id')
            ->where('properties.id', $request->id)
            ->orderByDesc('id')->get();
        if ($select) {
            $image = $this->image::all();
            $features = DB::table('features_to_property')
                ->select('features_to_property.id', 'features_to_property.property_id', 'features.feature')
                ->join('features', 'features_to_property.features_id', 'features.id')
                ->get();
            $data = [];
            foreach ($select as $value) {
                $imgTemp = [];
                foreach ($image as $row) {
                    if ($value->id == $row->property_id) {
                        array_push($imgTemp, ["id" => $row->id, "path" => $row->name_dir]);
                    }
                }
                $featuresTemp = [];
                foreach ($features as $row) {
                    if ($value->id == $row->property_id) {
                        array_push($featuresTemp, ["id" => $row->id, "feature" => $row->feature]);
                    }
                }
                array_push($data, [
                    "id" => $value->id,
                    "name" => $value->name,
                    "bed_rooms" => $value->bed_rooms,
                    "bath_rooms" => $value->bath_rooms,
                    "description" => $value->description,
                    "rent" => $value->rent,
                    "year_build" => $value->yearbuild,
                    "user_name" => $value->username,
                    "user_email" => $value->user_email,
                    "user_mobile" => $value->user_mobile,
                    "user_image" => $value->user_image,
                    "city" => $value->city,
                    "state" => $value->state,
                    "street" => $value->street,
                    "zip_code" => $value->zipcode,
                    "features" => $featuresTemp,
                    "images" => $imgTemp
                ]);
            }

            if ($request->expectsJson()) {
                // dd($select);
                return response()->json(["property_data" => $data]);
            } else {
                return view('properties.edit', compact('data'));
            }
        }
    }

    // select property
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
        $select = DB::table('properties')
            ->select(
                'properties.id AS id',
                'properties.property_name AS name',
                'properties.rent AS rent',
                'address.city AS city',
                'address.state AS state',
                'properties.status as status'
            )
            ->join('address', 'address.id', 'properties.address_id');
        if ($request->expectsJson()) {
            if ($name != "") {
                $select = $select->where('property_name', 'LIKE', '%' . $name . '%');
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
                    array_push($data, [
                        "id" => $value->id,
                        "name" => $value->name,
                        "rent" => $value->rent,
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
                    if ($column == "property_name") {
                        $select = $select->where($column, 'LIKE', '%' . $search . '%');
                    } elseif ($column == "rent_min") {
                        $select = $select->where('rent', '>=', $search);
                    } elseif ($column == "rent_max") {
                        $select = $select->where('rent', '<=', $search);
                    } else {
                        $select = $select->where($column, $search);
                    }
                }
                if($request->status != "")
                {
                    $select = $select->where('properties.status',$request->status);
                }
                $select = $select->orderByDesc('id')->paginate('5');
                return view('properties.manage', compact('select'));
            }
            $status = "No Data Found";
            return view('properties.manage', compact('status'));
        }
    }

    // delete property
    public  function delete(Request $request)
    {
        $tenant_to_property = Tendent::where([
            ['property_id', $request->id],
            ['is_live',1]
        ])->get();
        if ($tenant_to_property->count() == 0) {
            $property = Propety::find($request->id);
            if($property)
            {
                if($property->status == 0)
                {
                    $rent = Rent::where('property_id',$property->id)->get();
                    if($rent->count() > 0)
                    {
                        foreach ($rent as  $value) {
                            $value->delete();
                        }
                    }
                    $property->status = 1;
                    $property->save();

                    if ($request->expectsJson()) {
                        return response()->json([
                            "status" => true,
                        ]);
                    } else {
                        return back()->with('status', "Enabled");
                    } 
                }
                else
                {
                    $property->status = 0;
                    $property->save();
                    if ($request->expectsJson()) {
                        return response()->json([
                            "status" => true,
                        ]);
                    } else {
                        return back()->with('status', "Disabled");
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
        if ($request->expectsJson()) {
            return response()->json([
                "status" => false,
                "message" => 'Please Remove Tenants first'
            ]);
        } else {
            return back()->with('status', "Please Remove Tenants first");
        }
    }
}
