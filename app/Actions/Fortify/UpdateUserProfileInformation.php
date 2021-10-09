<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, Request $request)
    {
        // dd($request->all(), $user);
        // dd();
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'mobile' => ['required'],
            'address' => ['required'],
        ])->validateWithBag('updateProfileInformation');
        if ($request->has('profile')) {
            if (File::exists($user->image)) {
                unlink($user->image);
            }
            $upload = $request->file('profile');
            $upload = $upload->store('public/images');
            $path = "storage/" . substr($upload, 7);
        } else {
            $path = null;
        }
        if ($path != null) {
            $user->forceFill([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'image' => $path
            ])->save();
        } else {
            $user->forceFill([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => $request->address,
            ])->save();
        }
    }
}
