<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
    protected function success(
        $data = null, string
        $message = 'Success',
        int $code = Response::HTTP_OK
    ): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error(
        $data = null,
        string $message = 'Error',
        int $code = Response::HTTP_BAD_REQUEST
    ): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }


}
