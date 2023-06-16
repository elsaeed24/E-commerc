<?php

namespace App\Services\AdminAuthServices;

use Exception;
use App\Models\Admin;
use App\Traits\ResponseData;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\AdminLoginRequest;
use Symfony\Component\Process\ExecutableFinder;

class AdminRegisterService
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

    public function store($request,$data)
    {

        $admin = $this->model->create(array_merge(
            $data->validated(),
            [ 'password' => Hash::make($request->post('password'))]
        ));

        return $admin->email;
    }

    public function generateToken($email)
    {
        $token = substr(md5(rand(0,9). $email . time()),0,32);
        $admin = $this->model->whereEmail($email)->first();
        $admin->verification_token = $token;
         $admin->save();

         return $admin;
    }

    public function sendEmail($admin)
    {
        Mail::to($admin->email)->send(new VerificationEmail($admin));

    }



    public function register($request)
    {
        try{
            DB::beginTransaction();
        $data = $this->validation($request);
        $email = $this->store($request,$data);
        $admin = $this->generateToken($email);
        $this->sendEmail($admin);
        DB::commit();

      $user = Auth::guard('admin_api')->user();

     return  $this->responseSuccess($user,$admin,"Account Has Been Created Please Check Your Email");

        }catch(Exception $e){
            DB::rollback();
            return $e->getMessage();
        }
    }


}


