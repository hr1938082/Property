<?php

namespace App\Http\Controllers;

use App\Models\NotificationReadUnread;
use App\Models\notifications;
use App\Models\Tendent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public static function insert($input)
    {
        notifications::create($input);
        return response()->json(["status"=>true]);
    }
    public function select(Request $request)
    {
        if(Auth::user()->user_type_id == 1)
        {
            $select = notifications::select('notifications.id','user_id','notifications.description')
            ->where([['user_id',Auth::user()->id],['stl',1]])->get();
            $data = [];
            foreach ($select as $value) {
                $select_read_unread = NotificationReadUnread::select('user_id')
                ->where('notification_id',$value->id)->get();
                $status = 0;
                if($select_read_unread)
                {
                    foreach ($select_read_unread as $value1) {
                        if($value->user_id == $value1->user_id)
                        {
                            $status = 1;
                        }
                    }
                }
                if($status == 0)
                {
                    array_push($data,[
                        'id'=>$value->id,
                        'description'=>$value->description,
                        'status'=>$status
                    ]);
                }
            }
            return response()->json(["status" => true, "data"=>$data]);
        }
        if(Auth::user()->user_type_id == 2)
        {
            $check = Tendent::select('property_id')->where([['tendent_id',Auth::user()->id],['is_live',1]])->first();
            if($check)
            {
                $select = notifications::select('notifications.id','user_id','notifications.description')
                ->where([['property_id',$check->property_id],['stt',1]])
                ->get();
                $data = [];
                foreach($select as $value)
                {
                    $select_read_unread = NotificationReadUnread::select('user_id')
                    ->where('notification_id',$value->id)
                    ->get();
                    if($select_read_unread)
                    {
                        $status = 0;
                        foreach($select_read_unread as $value1)
                        {
                            if($value->property_id == $value1->property_id)
                            {
                                $status = 1;
                            }
                        }
                    }
                    if($status == 0)
                    {
                        array_push($data,[
                            'id'=>$value->id,
                            'description'=>$value->description,
                            'status'=>$status
                        ]);
                    }
                }
                return response()->json(["status" => true, "data"=>$data]);
            }
            return response()->json(["status" => true, "message"=>"not found"]);
        }
        return response()->json(["status" => true, "message"=>"unauthorized"]);
    }
    public function update(Request $request)
    {
        $input = [
                'user_id' => Auth::user()->id,
                'notification_id' => $request->id,
            ];
            NotificationReadUnread::create($input);
        return response()->json(["status" => true,]);
    }
}
