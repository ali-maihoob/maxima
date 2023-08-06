<?php
namespace App\Traits;

trait HttpResponse {
    protected function success($data, $message = null, $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => 'Success Request',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error($data, $message = null, $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => 'Error Request',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
