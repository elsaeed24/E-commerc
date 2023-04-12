<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

trait ResponseTrait
{

    public function responseSuccess($data,$message ="Successful",$ststus_code = JsonResponse::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'errors' => null,
            'data' => $data,


        ], $ststus_code);
    }

    public function responseError($message ="Data Is Invalid",$ststus_code = JsonResponse::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
           // 'errors' => $errors,
            'data' => null

        ], $ststus_code);
    }

}
