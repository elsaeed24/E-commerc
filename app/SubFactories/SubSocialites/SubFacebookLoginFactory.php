<?php

namespace App\SubFactories\SubSocialites;



use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class SubFacebookLoginFactory implements SubSocialLoginFactory
{
    public function redirect()
    {

       return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        try {
        $provider_user = Socialite::driver('facebook')->user();

        $user = User::where([

            'provider' => 'facebook',
            'provider_id' => $provider_user->id
        ])->first();


        if (!$user) {
            $user = User::create([
                'name' => $provider_user->name,
                'email' => $provider_user->email,
                'password' => Hash::make(Str::random(8)),
                'provider' => 'facebook',
                'provider_id' => $provider_user->id,
                'provider_token' => $provider_user->token,
            ]);
        }

             Auth::login($user);
            return redirect()->route('home.index');

        } catch (Throwable $e) {
            return redirect()->route('login')->withErrors([
                'email' => $e->getMessage(),
            ]);
        }




    }
}
