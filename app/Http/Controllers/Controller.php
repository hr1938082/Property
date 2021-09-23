<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public static function senNotification($data)
    {
        $url = "https://fcm.googleapis.com/fcm/send";
        $token =  $data['app_token'];
        $serverKey = 'AAAAp1hI9rw:APA91bHg7BskFcpYQsjUkPbF-pJtgkhI033PEkPKoBwTdrRI6InbvsEqk9Je5XhsXQrbhSBPpXBnj43ukahRZgJvh61Gc287kpzQKh2ut6oWn5qnPele2i04FabHOD3g-ugXU1oo7sSM';
        $title = $data['title'];
        $body = $data['message'];
        $notification = array('title' => $title, 'body' => $body, 'sound' => 'default', 'badge' => '1');
        $arrayToSend = array('to' => $token, 'notification' => $notification, 'priority' => 'high');
        $json = json_encode($arrayToSend);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $serverKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //Send the request
        $response = curl_exec($ch);
        //Close request
        if ($response === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
    }
}
