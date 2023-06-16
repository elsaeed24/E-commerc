<?php

namespace App\Services\AdminAuthServices;

use App\Models\Admin;
use App\Traits\ResponseData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\AdminLoginRequest;

class AdminLoginService
{
    use ResponseData;
    protected $model ;

   public function __construct()
    {
        $this->model = new Admin();
    }

    public function validation( $request)
    {
        $validator = Validator::make($request->all(), $request->rules() );
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        return $validator;
    }

    public function isValidData($data)
    {
     if(! $token = Auth::guard('admin_api')->attempt($data->validated())){

        return $this->responseError();
    }

        return $token;
    }

    public function getStatus($email)
    {
        $admin = $this->model->whereEmail($email)->first();
        $status = $admin->status;

        return $status;
    }

    public function isVerified($email)
    {
        $admin = $this->model->whereEmail($email)->first();
        $verified = $admin->verified_at;
        return $verified;

    }

    public function login($request)
    {
        $data = $this->validation($request);
       $token = $this->isValidData($data);

       if($this->isVerified($request->email) == null){
        return response()->json(['message' => 'Your Account Is Not Verified'],422);

      }elseif($this->getStatus($request->email) == 'inactive'){
        return response()->json(['message' => 'Your Account Is Pending'],422);

       }

      $user = Auth::guard('admin_api')->user();

     return  $this->responseSuccess($user,$token);

    }


}


