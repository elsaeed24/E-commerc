<?php

use Illuminate\Support\Facades\Route;

class RouteSingleton
{
    private static $instance;

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if(!isset(self::$instance)){
            self::$instance = new self();
        }

       return self::$instance;
    }

    public function addRoute($method,$url,$action)
    {
        Route::$method($url,$action);

    }

    public function addController($method,$url,$controller,$action,$name=null)
    {
       $route = Route::$method($url,$controller.'@'. $action);
       if($name){
        $route->name($name);
       }

    }




}

