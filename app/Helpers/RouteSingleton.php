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

    public function addRoute($method,$url,$action,$name=null)
    {
       Route::$method($url,$action);

    }



}

