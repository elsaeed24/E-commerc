<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Store;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Support\Facades\Response;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
      $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:stores,email',
            'password' => 'required|min:6',
            'status' => 'in:active,inactive',
            'currency' => 'sometimes|max:3',
            'description' => 'sometimes|min:20',
            'type' => 'in:admin,super-admin',
        ]);

       $request->merge([
        'password' => Hash::make($request->post('password')),
        'slug' => Str::slug($request->post('name'))
       ]);

       $user = Store::create($request->all());

       $token = $user->createToken('user',['app:all'])->plainTextToken;

        $user->notify(new EmailVerificationNotification());


       return Response::json([
        'status' => 'true',
        'token' => $token,
        'user' => $user,
       ],200);

    }
}
