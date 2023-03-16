<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function jsonResponse($success = true,$data = null, $statusCode = 200):JsonResponse
    {
        $response = [
            'success' => $success,
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }
}
