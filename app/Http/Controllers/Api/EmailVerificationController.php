<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerificationRequest;
use App\Models\Store;
use App\Notifications\EmailVerificationNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    private $otp;
    public function __construct()
    {
        $this->otp = new Otp();
    }
    // public function sendEmailVerification(Request $request)
    // {
    //          Auth::guard('store')->user()->notify(new EmailVerificationNotification());
    //          $success['success'] = true;
    //          return response()->json($success,200);

    // }


    public function email_verification(EmailVerificationRequest $request)
    {
        $otp = $this->otp->validate($request->email,$request->otp);
        if(!$otp->status){
            return response()->json(['error' => $otp],401);

        }

        $user = Store::where('email',$request->email)->first();
        $user->update([
            'email_verified_at' => now()
        ]);

        $success['success'] = true;
        return response()->json($success,200);
    }
}
