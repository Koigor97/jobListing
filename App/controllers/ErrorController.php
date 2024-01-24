<?php

namespace App\Controllers;

class ErrorController {
    /**
     * This method show the 404 not found error page
     * 
     * @return void
     */
    public static function notFound($message = 'Resource not found') {
        http_response_code(404);
        loadView('error', [
            'status' => 404,
            'message' => $message
        ]);
    }

    /**
     * This method show the 403 unauthorized error page
     * 
     * @return void
     */
    public static function unauthorized($message = 'You are not authorized to view this page') {
        http_response_code(403);
        loadView('error', [
            'status' => 403,
            'message' => $message
        ]);
    }

}