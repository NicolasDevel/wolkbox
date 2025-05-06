<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler
{
    use ApiResponseTrait;

    /**
     * Maneja las excepciones lanzadas y las convierte en respuestas JSON.
     *
     * @param \Throwable $e
     * @return JsonResponse
     */
    public static function handleException(Throwable $e): JsonResponse
    {
        $code = $e->getCode() ?: Response::HTTP_BAD_REQUEST;

        return (new self())->error(
            $e->getTrace(),
            $e->getMessage(),
            $code
        );
    }
}
