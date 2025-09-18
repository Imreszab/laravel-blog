<?php

namespace App\Traits;

trait HttpResponses
{
    protected function success(
        mixed $data,
        string $message = "OK",
        int $code = 200,
    ): \Illuminate\Http\JsonResponse {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error(
        mixed $data = null,
        string $message = "Error",
        int $code,
    ): \Illuminate\Http\JsonResponse {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}