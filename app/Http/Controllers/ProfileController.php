<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        $profile = User::find(auth()->user()->id);
        return JsonRes(SUCCESS_CODE, ['profile' => $profile], 'Success');
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();

//        Don't validate for username, phone and email uniqueness if It's still the same
        if ($data['email'] == auth()->user()->email || $data['username'] == auth()->user()->username|| $data['phone'] == auth()->user()->phone) {
            $validator = Validator::make($data, [
                'username' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone' => 'required',
                'address' => 'required',
            ]);
        } else {
            $validator = Validator::make($data, [
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|unique:users',
                'address' => 'required',
            ]);
        }

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return JsonRes(VALIDATION_ERROR_CODE, ['errors' => $errors], 'Validation Failed');
        }


        $user = User::find(auth()->user()->id);
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->address = $data['address'];

        if ($user->save()) {
            return JsonRes(SUCCESS_CODE, ['user' => $user], 'Profile Updated');
        } else {
            return JsonRes(SERVER_ERROR_CODE, [], 'error');
        }

    }
}
