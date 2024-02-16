<?php

namespace App\Http\Controllers;

use Flugg\Responder\Contracts\Responder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @var Responder $responder
     */
    protected Responder $responder;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->responder = responder();
    }

    /**
     * @param mixed       $data
     * @param string|null $transformer
     * @param integer     $status
     *
     * @return JsonResponse
     */
    protected function success($data = null, string $transformer = null, $status = 200): JsonResponse
    {
        return $this->responder->success($data, $transformer)->respond($status);
    }

    /**
     * @param integer|string|null $errorCode
     * @param string|null         $message
     * @param integer             $status
     *
     * @return JsonResponse
     */
    protected function error($errorCode = null, string $message = null, $status = 404): JsonResponse
    {
        return $this->responder->error($errorCode, $message)->respond($status);
    }
}
