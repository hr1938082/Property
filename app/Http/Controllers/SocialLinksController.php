<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SocialLinks;
use Exception;
use Illuminate\Http\Request;

class SocialLinksController extends Controller
{
    public function index()
    {
        return view('social.manage');
    }
    public function select(Request $request)
    {
        $social = SocialLinks::all();
        $socialLinks = [
            $social[0]->name => $social[0]->link,
            $social[1]->name => $social[1]->link,
            $social[2]->name => $social[2]->link,
            $social[3]->name => $social[3]->link,
        ];
        if ($request->expectsJson()) {
            return response()->json(["status" => true, "data" => $socialLinks]);
        } else {
            return view('social.manage', compact('social'));
        }
    }
    public function update(Request $request)
    {
        try {
            $Row = SocialLinks::find($request->id);
            if ($Row) {
                $upload = $request->all();
                if ($request->link) {
                    $Row->update($upload);
                    return back()->with('status', 'Updated');
                }
                return back()->with('status', 'link is required');
            }
            throw new Exception("Not Found");
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'messages' => $e]);
        }
    }
}
