<?php

namespace App\Http\Controllers\Front;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function show()
    {
        $code = request()->query('code');
        $coupon = Coupon::where('code','=',$code)->firstOrFail();


        return $coupon;
    }
}
