<?php

namespace App\Http\Controllers\Front;

use Throwable;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with('product')
                ->where('cart_id' , App::make('cart.id'))
                ->get();

        $total = $cart->sum(function($item){
          return   $item->product->price * $item->quantity;
         });

        return view('front.checkout',compact('cart','total'));
    }

    public function store(Request $request)
    {
        $cart = Cart::with('product')
            ->where('cart_id',App::make('cart.id'))
            ->get();

            if ($cart->count() == 0) {
                return redirect()->route('home.index');
            }

            $total = $cart->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            DB::beginTransaction();
            try {

            if ($request->post('register')) {
                    $user = $this->createUser($request);
                }

            $request->merge([
                'user_id' => Auth::id(),
                'total' => $total,
            ]);

            $order = Order::create($request->all());

            foreach ($cart as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

              Cart::where('cart_id',App::make('cart.id'))->delete();

            DB::commit();

            return redirect()->route('home.index')->with('status', 'Thank you! Your order has been placed!');

        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->back()
                            ->with('error', $e->getMessage())
                             ->withInput();
        }

    }
    protected function createUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->fisrt_name . ' ' . $request->last_name,
            'password' => Str::random(8),
            'email' => $request->email,

        ]);


        Auth::login($user);

        return $user;
    }
}
