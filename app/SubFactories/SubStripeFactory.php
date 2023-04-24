<?php

namespace App\SubFactories;



class SubStripeFactory implements SubPaymentFactory
{
    public function ProcessPayment()
    {
        return 'ProcessPayment With Stripe';
    }
}
