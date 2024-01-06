<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Str;

class ProviderController extends Controller
{
    public function callback(Request $request, $provider)
    {
        // Check for errors. If there are any, return back to the login page and display them.
        if ($request->has('error')) {
            return redirect()->route('login')->withErrors([
                'auth' => $request->input('error_description')
                    ?? $request->input('error')
            ]);
        }

        $username = null;

        if ($provider === 'linkedin') {
            $provider = $provider.'-openid'; // redirect returns 'linkedin' and not 'linkedin-openid' like it should
            $username = Str::random(15); // linkedin doesn't have a username, this is required for our codebase
        }

        if ($provider === 'facebook') {
            $username = Str::random(15); // facebook doesn't have a username, this is required for our codebase
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
            $user = User::where([
                'provider' => $provider,
                'provider_id' => $socialUser->getId()
            ])->first();

            if (!$user) {
                $name = explode(' ', $socialUser->getName());
                $user = User::create([
                    'username' => $username ?? $socialUser->getNickname(),
                    'first_name' => $name[0],
                    'last_name' => $name[1],
                    'display_name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => bcrypt(Str::random(15)),
                    // random password, we don't need it since we're using socialite
                    'provider_id' => $socialUser->getId(),
                    'provider' => $provider,
                    'provider_token' => $socialUser->token,
                    'email_verified_at' => now(),
                ]);

                $user->save();
            }

            if ($user) {
                Auth::login($user);
            } else {
                if (User::where('email', $socialUser->getEmail())->exists()) {
                    return redirect('/login')->withErrors(['email' => 'This email uses a different method to login.']);
                }
            }
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['email' => 'This email uses a different method to login.']);
        }
        return redirect('/');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
}
