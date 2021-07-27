<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialLinksController extends Controller
{
    public function select(Request $request)
    {
        $socialLinks = [
            "facebook" => "https://m.facebook.com",
            "insta" => "https://www.instagram.com/",
            "twitter" => "https://mobile.twitter.com",
            "linkedin" => "https://www.linkedin.com/signup",
        ];
        return response()->json(["status" => true, "data" => $socialLinks]);
    }
}
