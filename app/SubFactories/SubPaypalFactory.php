<?php

namespace App\SubFactories;



class SubPaypalFactory implements SubPaymentFactory
{
    public function ProcessPayment()
    {
        return 'ProcessPayment With Paypal';
    }
}
