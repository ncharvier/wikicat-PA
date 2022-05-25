<?php

namespace App\Core;

use App\Core\LogManager;

class ErrorManager
{
    public static function error(int $httpCode, ?string $message) {
        $log = LogManager::getInstance();
        $log->writeLog($httpCode, $message);

        switch ($httpCode) {
            case 404:
                header("location: page404");
                break;
            case 500:
                header("location: page500");
                break;
        }
    }
}
