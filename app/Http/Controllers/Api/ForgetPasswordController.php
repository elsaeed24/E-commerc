<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\ForgetPasswordNotification;
use Illuminate\Support\Facades\Hash;

class ForgetPasswordController extends Controller
{

    private $otp;
    public function __construct()
    {
        $this->otp = new Otp();
    }


    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:stores',
        ]);

        $input = $request->only('email');
        $user = Store::where('email',$input)->first();
        $user->notify(new ForgetPasswordNotification());
        $success['success'] = true;
        return response()->json($success,200);

    }

    public function resetPassword(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:stores',
            'otp' => 'required|max:6',
            'password' => 'required|string|min:6'
        ]);

        $otp2 = $this->otp->validate($request->email,$request->otp);
        if(! $otp2->status ){

            return response()->json([
                'error' => $otp2
            ], 401);
        }
        $input = $request->only('email');
        $user = Store::where('email',$input)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        $user->tokens()->delete();

        $success['success'] = true;
        return response()->json($success,200);

    }
}
