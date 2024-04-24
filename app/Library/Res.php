<?php

namespace App\Library;

/**
 * Format response.
 */
class Res
{
    /**
     * API Response
     *
     * @var array
     */
    protected static $response = [
        'status' => 'success',
        'message' => null,
    ];

    /**
     * Give success response.
     */
    public static function success($data = null, $message = null)
    {
        self::$response['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response);
    }

    /**
     * Give error response.
     */
    public static function error($data = null, $message = null, $code = 400)
    {   
        
        self::$response['status'] = 'error';
        self::$response['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, $code);
    }

    public static function errorValidation($error, $code = 401)
    {
        self::$response['status'] = 'error';
        self::$response['message'] = 'error validation';
        self::$response['errors'] = $error;

        return response()->json(self::$response, $code);
    }
}