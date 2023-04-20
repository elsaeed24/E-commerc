<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Notifications\NewOrderNotification;
use App\Models\User;


class CartController extends Controller
{
    public function index()


    {




        // app(cart.id)  or app()->make('cart.id')  or App::make('cart.id')      طرق لجلب القيمة من السيرفيز كونتينر
        $cart = Cart::with('product')
                    ->where('cart_id' , App::make('cart.id'))
                    ->get();

       $total = $cart->sum(function($item){
         return   $item->product->price * $item->quantity;
        });

        return view('front.cart',compact('cart','total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1'
        ]);

        $cart_id = App::make('cart.id');
        $product_id = $request->post('product_id');
        $quantity = $request->post('quantity',1);

        $product = Product::findOrFail($product_id);

        $cart = Cart::where([
            'cart_id' => $cart_id,
            'product_id' => $product_id,
        ])->first();

        if($cart){
            $cart->increment('quantity', $quantity);
        }else{

        $cart = Cart::create([
            'user_id' => Auth::id(),
            'cart_id' => $cart_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
        ]);
        }

        return redirect()->back()
                         ->with('status', "Product {$product->name} Added To Cart.");
    }


    // عشان هستخدم الفانكشن في اكتر من مكان ممكن اسجلها في السيرفيز كونتينر ولما اطلبها استدعيها افضل مكان هو فى البروفيدرز فى الاب سيرفيز في فانكشن البوت
   /* protected function getCartId()  // فحص الكوكيز اذا كان فية قيمة ولا لا لو مفيش هتنشأ ايدي لكوكي جديد
    {
     $id =Cookie::get('cart_id'); // الكوكي عبارة عن اسم وقيمة وفية اوبشن ثالث ممكن الكوكي يتحذف بشكل تلقائي بعد مدة
        if(!$id){
            $id = Str::uuid();
            Cookie::queue('cart_id',$id, 60 * 24 * 30);
        }

        return $id;
    }*/
}
