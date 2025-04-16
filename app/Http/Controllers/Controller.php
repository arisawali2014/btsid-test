<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function successResponse($message,$data, $code = 200) {
        return response()->json([
            'statusCode' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function errorResponse($message, $code = 400) {
        return response()->json([
            'statusCode' => $code,
            'errorMessage' => $message
        ], $code);
    }
}
