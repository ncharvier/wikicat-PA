<?php

namespace App\Core;

class ErrorManager
{
    public static function error(int $httpCode, ?string $message){
        switch ($httpCode){
            case 404:
                header("location: page404");
                break;
            case 500:
                header("location: page500");
                break;
        }
    }
}