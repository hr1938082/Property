<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Propety;
use App\Models\Tendent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function getMessages(Request $request)
    {
        $select = Message::select(
            'messages.id as id',
            'messages.message as text',
            'messages.time',
            'messages.User_id',
            'users.name',
            'users.image',
            'messages.image_name',
            'messages.base64'
        )
            ->join('users', 'users.id', 'messages.User_id')
            ->where('messages.Property_id', $request->property_id)
            ->get();
        $data = [];
        if ($select) {
            foreach ($select as $value) {
                if ($value->text != "" && $value->image_name != "") {
                    array_push($data, [
                        "id" => $value->id,
                        "text" => $value->text,
                        "createdAt" => $value->time,
                        "user" => [
                            "id" => $value->User_id,
                            "name" => $value->name,
                            "avatar" => $value->image,
                        ],
                        "image" => $value->image_name
                    ]);
                } elseif ($value->image_name != "") {
                    array_push($data, [
                        "id" => $value->id,
                        "image_name" => $value->image_name,
                        "createdAt" => $value->time,
                        "user" => [
                            "id" => $value->User_id,
                            "name" => $value->name,
                            "avatar" => $value->image,
                        ],
                        "image" => $value->image_name
                    ]);
                } else {
                    array_push($data, [
                        "id" => $value->id,
                        "text" => $value->text,
                        "createdAt" => $value->time,
                        "user" => [
                            "id" => $value->User_id,
                            "name" => $value->name,
                            "avatar" => $value->image,
                        ]
                    ]);
                }
            }
        }

        return response()->json([
            "data" => $data
        ]);
    }
    public function PropertyUsers(Request $request)
    {
        try {
            if ($request->property_id) {
                if (Auth::user()->user_type_id == 1) {
                    $row = Tendent::select('users.id', 'users.name', 'users.image')
                        ->join('users', 'users.id', 'tendent_to_property.tendent_id')
                        ->where([['tendent_to_property.property_id', $request->property_id], ['is_live', 1]])
                        ->get();
                }
                if (Auth::user()->user_type_id == 2) {
                    $landlord = Propety::select('users.id', 'users.name', 'users.image')
                        ->join('users', 'users.id', 'properties.user_id')
                        ->where('properties.id', $request->property_id)
                        ->first();
                    $select = Tendent::select('users.id', 'users.name', 'users.image')
                        ->join('users', 'users.id', 'tendent_to_property.tendent_id')
                        ->where([
                            ['tendent_to_property.property_id', $request->property_id],
                            ['is_live', 1],
                            ['tendent_to_property.tendent_id', '!=', Auth::user()->id]
                        ])
                        ->get();
                    $row = collect($select);
                    $row->push($landlord);
                }
                return response(['status' => true, 'data' => $row]);
            }
            throw new Exception("Property id is requires");
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'messages' => $e->getMessage()]);
        }
    }
}
