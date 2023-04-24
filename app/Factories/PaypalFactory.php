<?php

namespace App\Factories;

use App\SubFactories\SubPaypalFactory;

class PaypalFactory implements  PaymentsFactory
{
    public function PaymentMethod()
    {
        return new SubPaypalFactory();  // return new object from subclass
    }
}
