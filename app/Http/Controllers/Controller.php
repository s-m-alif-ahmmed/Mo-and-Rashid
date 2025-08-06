<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{

    // Success response
    public function sendResponse($result, $message, $code = 200, $token = null)
    {
        $response = [
            'status' => true,
            'message' => $message,
            'code' => $code,
            'token_type' => 'bearer',
            'token' => $token ?? '',
            'data' => $result,
        ];

        return response()->json($response, $code);
    }

    // Error response
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'status' => false,
            'message' => $error,
            'code' => $code,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
