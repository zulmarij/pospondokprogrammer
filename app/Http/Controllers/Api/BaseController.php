<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function responseOk($code = 200, $result, $message = 'Sukses')
    {
        $response = [
            'code' => $code,
            'data' => $result,
            'message' => $message,
        ];


        return response()->json($response, $code);
    }

    public function responseError($code = 422, $errorDetails = [], $error = 'Gagal' )
    {
        $response = [
            'code' => $code,
            'error' => $error,
        ];

        if (!empty($errorDetails)) {
            $response['errorDetails'] = $errorDetails;
        }

        return response()->json($response, $code);
    }
}
