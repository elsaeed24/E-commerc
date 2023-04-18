<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use Illuminate\Http\Request;
use PayPalHttp\HttpException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Session;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PaymentController extends Controller
{

    protected function getClient()
    {
        $config = config('services.paypal');
        $environment = new SandboxEnvironment($config['client_id'], $config['client_secret']);
        $client = new PayPalHttpClient($environment);
        return $client;
    }



    public function create(Order $order)
    {
        // $config = config('services.paypal');
        // $environment = new SandboxEnvironment($config['client_id'], $config['client_secret']);
        // $client = new PayPalHttpClient($environment);

        $client = $this->getClient();

        // create order

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $order->id,
                "amount" => [
                    "value" => $order->total,
                    "currency_code" => "USD"
                ]
            ]],

            "application_context" => [
                "cancel_url" => url(route('paypal.cancel')),
                "return_url" => url(route('paypal.callback')),
            ]
        ];

try{
            // Call API with your client and get a response for your call
            $response = $client->execute($request);


            if ($response->statusCode == 201 && isset($response->result)) {

                Session::put('payapl_order_id', $response->result->id);
                // Save the paypal order id in the database (orders)

                foreach ($response->result->links as $link) {
                    if ($link->rel == 'approve') {
                        return redirect()->away($link->href);
                    }
                }
            }

        }catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    public function callback(Request $request)
    {

        $order_id = Session::get('payapl_order_id');


        $request = new OrdersCaptureRequest($order_id);

        $request->prefer('return=representation');
        // try {
            // $client = $this->getClient();


            // // Call API with your client and get a response for your call
            // $response = $client->execute($request);


            // if ($response->statusCode == 201 && isset($response->result)) {
            //     if ($response->result->status == 'COMPLETED') {
            //         // update order payment status = 'paid'
            //         // Save the paypal order id in the database (orders)
            //         Session::forget('payapl_order_id');
            //         return redirect()->route('home.index')->with('success', 'Thank you');
            //     }
            // }
            return redirect()->route('home.index')->with('success', 'Thank you');


        // } catch (HttpException $ex) {
        //     echo $ex->statusCode;
        //     print_r($ex->getMessage());
        // }
    }
}
