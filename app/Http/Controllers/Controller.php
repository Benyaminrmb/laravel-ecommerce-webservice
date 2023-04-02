<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @param $status boolean
     * @param $data array|string|mixed
     * @param $message string
     * @param $statusCode numeric
     * @return JsonResponse
     */
    public function jsonResponse($status = true, $data = null, $message = null, $statusCode = 200): JsonResponse
    {
        $response['status'] = $status;
        if ($message) {
            $response['message'] = $message;
        }
        $response['data'] = $data;

        return response()->json($response, $statusCode);
    }
}
