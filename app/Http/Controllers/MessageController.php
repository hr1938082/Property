<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function getMessages(Request $request)
    {
        $select = Message::select('messages.id as id','messages.message as text',
        'messages.time','messages.User_id','users.name','users.image',
        'messages.image_name','messages.base64')
        ->join('users','users.id','messages.User_id')
        ->where('messages.Property_id',$request->property_id)
        ->get();
        $data = [];
        if($select)
        {
            foreach ($select as $value) {
                if($value->text != "" && $value->image_name != "")
                {
                    array_push($data,[
                        "id"=>$value->id,
                        "text"=>$value->text,
                        "createdAt"=>$value->time,
                        "user" =>[
                            "id"=>$value->User_id,
                            "name"=>$value->name,
                            "avatar"=>$value->image,
                        ],
                        "image"=>$value->image_name
                    ]);
                }
                elseif($value->image_name != "")
                {
                    array_push($data,[
                        "id"=>$value->id,
                        "image_name"=>$value->image_name,
                        "createdAt"=>$value->time,
                        "user" =>[
                            "id"=>$value->User_id,
                            "name"=>$value->name,
                            "avatar"=>$value->image,
                        ],
                        "image"=>$value->image_name
                    ]);
                }
                else
                {
                    array_push($data,[
                        "id"=>$value->id,
                        "text"=>$value->text,
                        "createdAt"=>$value->time,
                        "user" =>[
                            "id"=>$value->User_id,
                            "name"=>$value->name,
                            "avatar"=>$value->image,
                        ]
                    ]);
                }
            }
        }

        return response()->json([
            "data"=>$data
        ]);
    }
}
