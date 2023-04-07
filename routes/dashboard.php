<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\AuthStore\LoginController;

Route::prefix('admin')->middleware('auth:store')->group(function () {

    $router = RouteSingleton::getInstance();    // only one object only from class

    $router->addRoute('resource','categories',CategoryController::class);
    $router->addRoute('resource','products',ProductController::class);
    $router->addController('get','dashboard', DashboardController::class,'index','dashboard.index');

    $router->addRoute('resource','roles',RoleController::class);


   $router->addController('post','logout', LoginController::class,'destroy','stores.logout');


});

Route::prefix('admin')->middleware('guest:store')->group(function () {


    Route::get('login', [LoginController::class, 'create'])
                ->name('stores.login');

    Route::post('login', [LoginController::class, 'store']);

});





//Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
//Route::get('admin/users/{id}', [UserController::class, 'show'])->name('admin.users.show');





