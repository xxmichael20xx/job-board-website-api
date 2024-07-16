<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HasHttpResponse
{
    /**
     * Return a success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public function success(mixed $data = null, string $message = 'Request successful', int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $status);
    }

    /**
     * Return an error response
     *
     * @param string $message
     * @param int $status
     * @param array|null $errors
     * @return JsonResponse
     */
    public function error(string $message = 'Operation failed', int $status = 400, ?array $errors = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $status);
    }

    /**
     * Return a validation error response
     *
     * @param array $errors
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public function validationError(array $errors, string $message = 'Validation errors', int $status = 422): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $status);
    }

    /**
     * Return a custom response
     *
     * @param mixed $data
     * @param string $message
     * @param string $status
     * @param int $statusCode
     * @return JsonResponse
     */
    public function custom(mixed $data = null, string $message = '', string $status = 'Info', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
}
