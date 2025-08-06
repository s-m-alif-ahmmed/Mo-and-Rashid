<?php

namespace App\Http\Controllers\Web\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    public function update($id, Request $request) {
        // Validate the request

        // After successful login
        if (session()->has('selected_country')) {
            $user = Auth::user();
            $user->country_id = session('selected_country');
            $user->save();

            session()->forget('selected_country'); // Clear the session
        }else{
            $request->validate([
                'country' => 'required|exists:countries,id',
            ]);

            // Find the user and update the country_id
            $user = User::findOrFail($id);
            $user->country_id = $request->country; // Assuming `country_id` is the field in your users table
            $user->save();

            // Return a JSON response
            return response()->json();
        }

    }

    public function store(Request $request) {
        $request->validate([
            'country' => 'required|exists:countries,id',
        ]);

        // Store the selected country in the session
        session(['selected_country' => $request->country]);

        return response()->json();
    }


}
