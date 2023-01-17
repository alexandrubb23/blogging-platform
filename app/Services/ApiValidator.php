<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiValidator
{
    /**
     * Validate the data.
     *
     * @param [object] $data
     * @param [array] $rules
     * @return boolean
     */
    public static function validate(string $api_url, object $data, array $rules): bool
    {
        try {
            Validator::make((array)  $data, $rules)->validate();

            return true;
        } catch (Exception $ex) {
            self::logError($api_url, $ex);
        }

        return false;
    }

    /**
     * Log error.
     *
     * @param string $errorMessage
     * @param Exception $ex
     * 
     * @return void
     */
    private static function logError(string $api_url, Exception $ex): void
    {
        $errorMessage = sprintf('Invalid API "%s" Response: %s', $api_url, $ex->getMessage());
        Log::error($errorMessage);
    }
}
