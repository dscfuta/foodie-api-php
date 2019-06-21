<?php

namespace App\Http\Controllers;

use App\Cart;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    public function login(Request $request){
        $credentials = $request->only(['email', 'password']);

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return JsonRes(VALIDATION_ERROR_CODE, ['errors' => $errors], 'Validation Failed');
        }

        if(! $token = auth()->attempt($credentials)){
            return JsonRes(UNAUTHORIZED_CODE, ['error' => 'Unauthorized'], 'Failed');
        }

        return JsonRes(SUCCESS_CODE, ['token' => $token], 'Success');
    }


    /**
     * Registers a user
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:8|',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return JsonRes(VALIDATION_ERROR_CODE, ['errors' => $errors], 'Validation Failed');
        }

        $user = User::create($request->all());

        if ($user) {
            Cart::create([
                'user_id' => $user->id
            ]);

            $token = auth()->login($user);
            return JsonRes(SUCCESS_CODE, ['token' => $token], 'Success');
        } else {
            return JsonRes(SERVER_ERROR_CODE, [], 'Registration failed');
        }

    }
}
