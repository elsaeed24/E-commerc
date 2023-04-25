<?php

namespace App\Factories\Socialites;

use App\SubFactories\SubSocialites\SubGoogleLoginFactory;

class GoogleLoginFactory implements SocialLoginFactory
{
    public function SocialLogin()
    {
        return new SubGoogleLoginFactory();
    }
}
