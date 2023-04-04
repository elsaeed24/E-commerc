<?php

use App\Http\Controllers\Admin\CategoryController;



//use Illuminate\Support\Facades\Route;





$router = RouteSingleton::getInstance();    // only one object only from class

$router->addRoute('resource','categories',CategoryController::class);
