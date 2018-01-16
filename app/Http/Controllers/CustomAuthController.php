<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Validator;

class CustomAuthController extends Controller
{
    public function showLoginPage()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users',
            'password' => 'required',
        ], [
            'email.exists' => 'The :attribute you entered does not match any account.',
            'email.email' => 'Make sure you entered a valid :attribute',
        ]);

        if ($validator->passes() && Auth::attempt($request->only(['username', 'password']))) {
            return redirect(route('home'));
        } else {
            $validator->errors()->add('password', 'You entered an incorrect password');
        }

        return redirect()
            ->back()
            ->withInput()
            ->withErrors($validator);
    }

    public function showRegistrationPage()
    {
        return view('login');
    }

    public function doRegister($value = '')
    {
        # code...
    }
}
