<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    public static function Out(bool $status, $data, int $code, $reload = null): JsonResponse
    {
        $response = [
            'status' => $status,
            'data' => $data,
        ];

        // Only include reload key if it's not null
        if (!is_null($reload)) {
            $response['reload'] = $reload;
        }

        return response()->json($response, $code);
    }
}

