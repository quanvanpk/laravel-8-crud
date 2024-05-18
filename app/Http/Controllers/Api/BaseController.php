<?php
namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;


class BaseController extends Controller
{
    use AuthorizesRequests;

    /**
     * @param string $message
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    public function responseSuccess($message = '', $data = [], $code = 200): JsonResponse
    {
        return response()->json([
                'status'  => true,
                'message' => $message,
                'data'    => $data,
            ], $code);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    public function responseError($message = '', $data = [], $code = 400): JsonResponse
    {
        return response()->json([
                'status' => false,
                'message' => $message,
                'data'    => $data,
            ], $code);
    }
}