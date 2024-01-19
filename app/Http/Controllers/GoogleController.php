<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    //
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleLogin()
    {
        $googleUser = Socialite::driver('google')->user();

        // Check if the user with this email already exists in the database
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            auth()->login($user);
            return redirect('/');
        } else {
            return redirect('/login')->with('err_google', 'This google account is not registered.')->with('status', 'danger');
        }
    }
}
