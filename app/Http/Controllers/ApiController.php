<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    protected function success($data = null, $message = 'Sucesso', $code = 200) {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'errors' => null
        ], $code);
    }

    protected function error($message = 'Erro', $code = 400, $errors = null) {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
            'errors' => $errors
        ], $code);
    }
}
