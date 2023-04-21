<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use App\Models\cart as CartModel;

class Cart extends Component
{

    public $cart;

    public $total;


    /**
     * Create a new component instance.
     */
    public function __construct()
    {

        $this->cart = CartModel::with('product')
        ->where('cart_id' , App::make('cart.id'))
        ->get();

        $this->total = $this->cart->sum(function($item){
        return   $item->product->price * $item->quantity;
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart');
    }
}
