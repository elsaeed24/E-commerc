<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Jobs\NewProductEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\GeoIP\MaxMindGeoLite;

class HomeController extends Controller
{

    public function index()
    {
          $config = config('services.maxmind');
          $geoip = new MaxMindGeoLite($config['account_id'], $config['license_key']);

        //  return $geoip->country('156.210.175.234');

        $latest = Product::with('category')->latest()->take(8)->get();
        return view('front.home.index',[
            'latest' => $latest
        ]);
    }

    public function sms()
    {
        $config = config('services.vonage');

        $basic  = new \Vonage\Client\Credentials\Basic($config['vonage_key'], $config['vonage_secret']);
         $client = new \Vonage\Client($basic);

         $user = Auth::user();

         $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS( $user->mobile, 'web developer' ,'hello ' . $user->name));

            return response()->json('sms message has been successfully');

    }

    public function newsletter()
    {
        dispatch(new NewProductEmail())
            ->onQueue('emails')
            ->delay(Carbon::now()->addMinutes(5));

        dispatch(new NewProductEmail())->onQueue('emails');
    }




}
