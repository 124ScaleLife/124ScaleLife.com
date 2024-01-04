<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class ProviderController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(Request $request, $provider)
    {
        // Check for errors. If there are any, return back to the login page and display them.
        if ($request->has('error')) {
            return redirect()->route('login')->withErrors([
                'auth' => $request->input('error_description')
                    ?? $request->input('error')
            ]);
        }

        /* Socialite acts weird with LinkedIn as of 2024-01-04. The provider is 'linkedin-openid' but the callback
        returns 'linkedin'. When this happens, socialite blows up let's just fix it here for now and probably
        report this as a bug later. */
        if ($provider === 'linkedin') {
            $provider = $provider.'-openid';
        }

        // Grab the user's information so we can do things with it.
        $user = Socialite::driver($provider)->user();
        // TODO: Create the user
    }
}
