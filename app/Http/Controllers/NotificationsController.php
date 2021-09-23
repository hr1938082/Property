<?php

namespace App\Http\Controllers;

use App\Models\NotificationReadUnread;
use App\Models\notifications;
use App\Models\Tendent;
use App\Http\Controllers\MailController;
use App\Models\Propety;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public static function insert($input)
    {
        notifications::create($input);
        if (Auth::user()->user_type_id == 1) {
            $select = Tendent::select('users.name', 'users.email', 'users.app_token')
                ->join('users', 'users.id', 'tendent_to_property.tendent_id')
                ->where([['property_id', $input['property_id']], ['is_live', 1]])->get();
            if ($select) {
                foreach ($select as $tendents) {
                    $data = [
                        "email" => $tendents->email,
                        "name" => $tendents->name,
                        "subject" => "Notification",
                        "body" => $input['description']
                    ];
                    MailController::mail($data);
                    Controller::senNotification([
                        'app_token' => $tendents->app_token,
                        'title' => $input['title'],
                        'message' => $input['description']
                    ]);
                }
            }
        }

        if (Auth::user()->user_type_id == 2) {
            $select = Propety::select('users.name', 'users.email', 'users.app_token')
                ->join('users', 'users.id', 'properties.user_id')
                ->where('properties.user_id', $input['user_id'])
                ->first();
            $data = [
                'email' => $select->email,
                'name' => $select->name,
                'subject' => "Notification",
                'body' => $input['description']
            ];
            MailController::mail($data);
            Controller::senNotification([
                'app_token' => $select->app_token,
                'title' => $input['title'],
                'message' => $input['description']
            ]);
        }
        return response()->json(["status" => true]);
    }
    public static function ToAllByTendent($input)
    {
        notifications::create($input);
        $tendents = Tendent::select('users.name', 'users.email', 'users.app_token')
            ->join('users', 'users.id', 'tendent_to_property.tendent_id')
            ->where([['property_id', $input['property_id']], ['is_live', 1]])->get();
        $landlord = Propety::select('users.name', 'users.email', 'users.app_token')
            ->join('users', 'users.id', 'properties.user_id')
            ->where('properties.user_id', $input['user_id'])
            ->first();
        $data = collect($tendents);
        $data->push($landlord);
        if ($data) {
            foreach ($data as $user) {
                $data = [
                    "email" => $user->email,
                    "name" => $user->name,
                    "subject" => "Notification",
                    "body" => $input['description']
                ];
                MailController::mail($data);
                Controller::senNotification([
                    'app_token' => $user->app_token,
                    'title' => $input['title'],
                    'message' => $input['description']
                ]);
            }
            return response()->json(['status' => true]);
        }
    }
    public function select()
    {
        if (Auth::user()->user_type_id == 1) {
            $select = notifications::select('notifications.id', 'user_id', 'notifications.description')
                ->where([['user_id', Auth::user()->id], ['stl', 1]])->get();
            $data = [];
            foreach ($select as $value) {
                $select_read_unread = NotificationReadUnread::select('user_id')
                    ->where('notification_id', $value->id)->get();
                $status = 0;
                if ($select_read_unread) {
                    foreach ($select_read_unread as $value1) {
                        if ($value->user_id == $value1->user_id) {
                            $status = 1;
                        }
                    }
                }
                if ($status == 0) {
                    array_push($data, [
                        'id' => $value->id,
                        'description' => $value->description,
                        'status' => $status
                    ]);
                }
            }
            return response()->json(["status" => true, "data" => $data]);
        }
        if (Auth::user()->user_type_id == 2) {
            $check = Tendent::select('property_id')->where([['tendent_id', Auth::user()->id], ['is_live', 1]])->first();
            if ($check) {
                $select = notifications::select('notifications.id', 'user_id', 'notifications.description')
                    ->where([['property_id', $check->property_id], ['stt', 1]])
                    ->get();
                $data = [];
                foreach ($select as $value) {
                    $select_read_unread = NotificationReadUnread::select('user_id')
                        ->where('notification_id', $value->id)
                        ->get();
                    if ($select_read_unread) {
                        $status = 0;
                        foreach ($select_read_unread as $value1) {
                            if ($value->property_id == $value1->property_id) {
                                $status = 1;
                            }
                        }
                    }
                    if ($status == 0) {
                        array_push($data, [
                            'id' => $value->id,
                            'description' => $value->description,
                            'status' => $status
                        ]);
                    }
                }
                return response()->json(["status" => true, "data" => $data]);
            }
            return response()->json(["status" => true, "message" => "not found"]);
        }
        return response()->json(["status" => true, "message" => "unauthorized"]);
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
