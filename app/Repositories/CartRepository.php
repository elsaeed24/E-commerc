<?php

namespace App\Repositories;


use App\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\App;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class CartRepository implements CartRepositoryInterface
{
    public function getAll()
    {
        return  Cart::with('product')
                    ->where('cart_id' , App::make('cart.id'))
                    ->get();
    }

    public function add($product_id , $quantity = 1)
    {
        $cart_id = App::make('cart.id');

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

    }

    public function update($product_id,$quantity)
    {
        Cart::where('product_id' ,'=' ,$product_id)
        ->update([
            'quantity' => $quantity,
        ]);


    }

    public function delete($product_id)
    {
        $cart_id = App::make('cart.id');

        Cart::where([
            'cart_id' => $cart_id,
            'product_id' => $product_id,
        ])->delete();

    }

    public function empty()
    {

        $cart_id = App::make('cart.id');

        Cart::where([
            'cart_id' => $cart_id
        ])->delete();


    }

    public function total()
    {

        return $this->getAll()->sum(function($item){
            return   $item->product->price * $item->quantity;
           });

    }
}
