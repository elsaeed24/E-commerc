<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\GeoIP\MaxMindGeoLite;
use Illuminate\Http\Request;

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
}
