<?php

namespace App\Http\Controllers\Test;

use App\Factories\PaypalFactory;
use App\Factories\StripeFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class PaymentMethodController extends Controller
{
    public function payments($type)
    {
        $payments = match($type){      // or switch case

            // 'paypal' => new PaypalFactory(),
            'stripe' => new StripeFactory(),
            default => new PaypalFactory()
        };
        return $payments->PaymentMethod()->ProcessPayment();
    }
}
