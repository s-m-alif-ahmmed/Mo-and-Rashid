<?php

namespace App\Http\Controllers\Web\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback( Request $request )
    {
       try {
//            Retrieve user information from the social provider
            $socialUser = Socialite::driver('google')->user();

            // Check if the user's email already exists in the database
            if (User::where('email', $socialUser->getEmail())->exists()) {
                return redirect()->back()->withErrors(['email' => 'This email uses a different method to login.']);
            }

            // Find or create a user based on the provider and provider ID
            $user = User::where([
                'provider' => 'google',
                'google_id' => $socialUser->getId()
            ])->first();

            if (!$user) {
                // Create a new user if one doesn't exist
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make('password'),
                    'provider' => 'google',
                    'google_id' => $socialUser->getId(),
                    'provider_token' => $socialUser->token,
                ]);
            }

            // Log in the user
            Auth::login($user);
            return redirect()->back(); // Replace 'home' with the desired redirect URL

       } catch (\Exception $e) {
           // Handle any exceptions that may occur during the process
           return redirect()->back()->withErrors(['message' => 'An error occurred. Please try again.']);
       }

    }

    public function check_auth()
    {
        if(Auth::check()){
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

}
