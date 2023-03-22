<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function jsonResponse($success = true, $data = null,$message=null, $statusCode = 200): JsonResponse
    {
        $response = [
            'success' => $success,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response, $statusCode);
    }
}
