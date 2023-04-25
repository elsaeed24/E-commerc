<?php

namespace App\Http\Controllers\Auth;

use App\Factories\Socialites\FacebookLoginFactory;
use App\Factories\Socialites\GoogleLoginFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialitesController extends Controller
{
    public function redirect($provider)
    {

        $social_login = match ($provider){

            'google' => new GoogleLoginFactory(),
            'facebook' => new FacebookLoginFactory()
        };

        return $social_login->SocialLogin()->redirect();

    }

    public function callback($provider)
    {

        $social_login = match ($provider){

            'google' => new GoogleLoginFactory(),
            'facebook' => new FacebookLoginFactory()
        };

        return $social_login->SocialLogin()->callback();


    }
}
