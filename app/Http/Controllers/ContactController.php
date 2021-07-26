<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact(Request $request)
    {
        $mail = [
            "email" => "property371@gmail.com",
            "name" => $request->name,
            "subject" => $request->subject,
            "body" => $request->message,
            "from" => $request->email
        ];
        if(MailController::mail($mail))
        {
            return back()->with('status','Message has been sent');
        }
        return back()->with('status','Message did not send');
    }
}
