<?php

namespace App\Helpers;

use Exception;

class APIHelper {
    
    public static function requireInputs($inputArr) {
        $emptyValues = [];
        foreach ($inputArr as $key => $value) {
            if (empty($value)) {
                array_push($emptyValues, $key);
            }
        }

        if (! empty($emptyValues)) {
            throw new Exception(implode(', ', $emptyValues) . " cannot be empty.");
        }
    }
    

    public static function getSuccessResponse($additionalInfo) {
        $defaultResponse = [
            'Success' => true,
            'ErrorMessage' => ''
        ];
        $response = response()->json(array_merge($defaultResponse, $additionalInfo));

        return $response;
    }
    

    public static function getExceptionResponse($e) {
        $response = response()->json([
            'Success' => false,
            'ErrorMessage' => $e->getMessage()
        ]);
        return $response;
    }
}