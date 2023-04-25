<?php

namespace App\Factories\Socialites;

use App\SubFactories\SubSocialites\SubFacebookLoginFactory;

class FacebookLoginFactory implements SocialLoginFactory
{
    public function SocialLogin()
    {
       return new SubFacebookLoginFactory();
    }
}
