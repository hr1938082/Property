<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Illuminate\Http\JsonResponse;

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
        if($request->has('profile'))
        {
            if(File::exists($user->image))
            {
                unlink($user->image);
            }
            $upload = $request->file('profile');
            $upload = $upload->store('public/images');
            $path = "storage/".substr($upload,7);
        }
        else
        {
            $path = null;
        }
        if ($request->email !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $request->all());
        } else {

            if($path != null)
            {
                $user->forceFill([
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'address' => $request->address,
                    'image' => $path
                ])->save();
            }
            else
            {
                $user->forceFill([
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'address' => $request->address,
                ])->save();
            }
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
