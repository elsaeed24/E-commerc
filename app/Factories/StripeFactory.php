<?php

namespace App\Factories;


use App\SubFactories\SubStripeFactory;

class StripeFactory implements  PaymentsFactory
{
    public function PaymentMethod()
    {
        return new SubStripeFactory(); // return new object from subclass
    }
}
