<?php

if (!function_exists('JsonRes')) {
    function JsonRes($status_code = null, array $data = null, String $message = null)
    {
        return response()->json([
            'status' => $status_code,
            'message' => $message,
            'data' => $data,
        ], $status_code);
    }
}

const SUCCESS_CODE = 200;
const REDIRECT_CODE = 302;
const BAD_REQUEST_CODE = 400;
const UNAUTHORIZED_CODE = 401;
const FORBIDDEN_CODE = 403;
const NOT_FOUND_CODE = 404;
const VALIDATION_ERROR_CODE = 422;
const SERVER_ERROR_CODE = 500;

