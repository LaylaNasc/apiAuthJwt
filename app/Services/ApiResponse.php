<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success($data): JsonResponse
    {
        return response()->json(
            [
                'statusCode' => 200,
                'message' => 'success',
                'data' => $data,
            ],
            200
        );
    }

    public static function error($message): JsonResponse
    {
        return response()->json(
            [
                'statusCode' => 500,
                'message' => $message,
            ],
            500
        );
    }

    public static function unauthorized(): JsonResponse
    {
        return response()->json(
            [
                'statusCode' => 401,
                'message' => 'Não Autorizado',
            ],
            401
        );
    }
}