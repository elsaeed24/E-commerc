<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\MessageController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard2', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('home',[HomeController::class,'index'])->name('home.index');
Route::get('sms',[HomeController::class,'sms']);

Route::get('products/{slug}', [ProductController::class, 'show'])->name('front.products.show');


Route::get('cart',[CartController::class,'index'])->name('cart');
Route::post('cart',[CartController::class,'store']);
Route::delete('cart/{product_id}', [CartController::class, 'destroy'])->name('cart.destroy');


Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('checkout', [CheckoutController::class, 'store']);

Route::get('payments/{order}', [PaymentController::class, 'create'])->name('payments.create');
Route::any('payments/paypal/callback', [PaymentController::class, 'callback'])->name('paypal.callback');
Route::any('payments/paypal/cancel', [PaymentController::class, 'cancel'])->name('paypal.cancel');

Route::get('messages', [MessageController::class, 'index'])->name('messages');
Route::get('messages/{peer_id}', [MessageController::class, 'show'])->name('messages.peer');
Route::post('messages/{peer_id}', [MessageController::class, 'store']);

Route::get('validate/email/{email}', function($email) {

    $exists = User::where('email', '=', $email)->exists();
    return [
        'exists' => $exists,
        'msg' => $exists? 'Email already used' : 'Email avialable',
    ];

})->name('validate.email');


require __DIR__.'/dashboard.php';
// require __DIR__.'/auth_store.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

