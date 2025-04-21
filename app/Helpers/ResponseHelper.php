<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    public static function Out(bool $status, $data, int $code): JsonResponse
    {

        return response()->json(['status' => $status, 'data' => $data], $code);

    }
}
