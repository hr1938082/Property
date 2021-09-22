<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\PropertyMail;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{

    public static function mail($input)
    {
        $to_email = $input["email"];

        if(isset($input['from']))
        {
            $from = $input['from'];
        }
        else
        {
            $from = env('MAIL_USERNAME');
        }

        $data = [
            'subject' => $input["subject"],
            "name" => $input["name"],
            "body" => $input["body"],
            "from" => $from
        ];
        Mail::to($to_email)->send(new PropertyMail($data));

        return true;
    }
}
