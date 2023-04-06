<?php

namespace App\Http\Controllers\Auth\AuthStore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{

    public function create()
    {
        return view('auth.stores.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

      $result = Auth::guard('store')->attempt([
            'email' => $request->post('email'),
            'password' => $request->post('password')
            // or  $request->only('email','password'),
        ], $request->boolean('remember'));

        if (!$result) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard.index');
    }
}
