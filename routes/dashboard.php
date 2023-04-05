<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

Route::prefix('admin')->group(function () {

    $router = RouteSingleton::getInstance();    // only one object only from class

    $router->addRoute('resource','categories',CategoryController::class);
    $router->addRoute('resource','products',ProductController::class);

});

//Route::get('admin/users/{id}', [UserController::class, 'show'])->name('admin.users.show');





