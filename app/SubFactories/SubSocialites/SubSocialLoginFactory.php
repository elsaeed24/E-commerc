<?php

namespace App\SubFactories\SubSocialites;

interface SubSocialLoginFactory
{
    public function redirect();

    public function callback();
}