<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait HandlesResponse
{
    protected function jsonResponse(
        int $statusCode = Response::HTTP_OK,
        mixed $data = [],
        mixed $message = null,
        ?array $errors = null,
        string $data_wrapper = ''
    ): JsonResponse {
        $response = [
            'success' => $statusCode >= 200 && $statusCode <= 299 ? 1 : 0,
            'message' => $message,
        ];

        $response['data'] = $data_wrapper === '' ? $data : [$data_wrapper => $data];

        if (isset($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}
