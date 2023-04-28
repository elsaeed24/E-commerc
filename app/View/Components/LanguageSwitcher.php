<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguageSwitcher extends Component
{
    public $locales;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->locales = LaravelLocalization::getSupportedLocales();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.language-switcher');
    }
}
