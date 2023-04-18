<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\Intl\Currencies;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Intl\Timezones;

class Setting extends Model
{
    use HasFactory;

    protected $primaryKey = 'name';

    protected $keyType = 'string';

    public $incrementing = false ;

    protected $fillable =[
        'name', 'value'
    ];


    public static function localeOptions()
    {
        return Languages::getNames();

    }

    public static function timezoneOptions()
    {
        return Timezones::getNames();
    }

    public static function currencyOptions()
    {
        foreach (Currencies::getNames() as $code => $name){
            $currencies[$code] = "$code - $name";
        }
        return $currencies;
    }



}
