<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable                $exception
     *
     * @return JsonResponse
     *
     * See /config/error_codes.php for more information about Error Code
     */
    public function render($request, Throwable $exception)
    {
        switch (get_class($exception)) {
            case ValidationException::class:
                return $this->validateException($exception);
            case ModelNotFoundException::class:
                return $this->notFoundException();
        }

        $errorCode  = method_exists($exception, 'getCode') && !empty($exception->getCode()) 
            ? $exception->getCode()
            : null;

        $statusCode = method_exists($exception, 'getStatusCode') && !empty($exception->getStatusCode()) 
            ? $exception->getStatusCode()
            : null;

        return $this->respond($errorCode, $exception->getMessage(), $statusCode);
    }

    /**
     * @param  ValidationException $exception
     * 
     * @return JsonResponse
     */
    private function validateException(ValidationException $exception): JsonResponse
    {
        $data   = [];
        $errors = $exception->errors();

        array_walk_recursive($errors, function ($error) use (&$data) {
            $data[] = $error;
        });

        return $this->respond(config('error_codes.validation'), $exception->getMessage(), 422, $data);
    }

    /**
     * @return JsonResponse
     */
    private function notFoundException(): JsonResponse
    {
        return $this->respond(config('error_codes.data_not_found'), 'Not found', 404);
    }

    /**
     * @param integer|string|null $errorCode
     * @param string|null         $message
     * @param integer|            $statusCode
     * @param array|null          $data
     *
     * @return JsonResponse
     *
     * See /config/error_codes.php for more information about Error Code
     */
    private function respond($errorCode = null, $message = null, $statusCode = 400, $data = null): JsonResponse
    {
        $errorCode = $errorCode ?? config('error_codes.unknown');
        $message   = $message ?? 'The application has encountered an error while processing the request. Please try again later.';

        $responder = responder()->error($errorCode, $message);

        if (!empty($data)) {
            $responder->data(['validation_messages' => $data]);
        }

        return $responder->respond($statusCode);
    }
}
