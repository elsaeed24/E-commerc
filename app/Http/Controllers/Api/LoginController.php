<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class LoginController extends Controller
{
    use ResponseTrait;

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'string|max:255',   // دة بارامتر المفروض الموبايل اب يبعتة
            //'abilities' => 'nullable|array',
        ]);

        $user = Store::where('email' , $request->email)->first();

        if($user && Hash::check($request->password, $user->password)){

            $device = $request->input('device_name', $request->userAgent()); // لومبعتش البارامتر الديفلت هيكون يوزراجينت ودة بيجيب اسم المتصفح اللي استخدمة اليوزر اثناء اللوجن
            // create token
           $token = $user->createToken($device,['products.create', 'products.update','products.delete']);
           // $user->createToken('اسم التوكن(بعتبرة اسم الجهاز اللي عمل منة لوجن)','الصلاحيات')

           return Response::json([
            'code' => 100,
            'token' => $token->plainTextToken,
            'user' => $user,
           ],201);

        }else{
            return $this->responseError('Invalid email and password');
        }

    }

    public function logout(Request $request)
    {
        //Revoke All User "logout from all devices must be delete all tokens"


        // current user
        $user = Auth::guard('sanctum')->user();

         // Logout from current device
         $user->currentAccessToken()->delete();

         // Logout out form all devices
        //$user->tokens()->delete();

        return Response::json([
            'message' => 'Token deleted',
        ]);

    }
}
