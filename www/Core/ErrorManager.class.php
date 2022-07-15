<?php

namespace App\Core;

use App\Core\LogManager;
use App\Core\View;

class ErrorManager
{
    public static function error(int $httpCode, ?string $message) {
        $log = LogManager::getInstance();
        $log->writeLog($httpCode, $message);
        $view = new View('error');

        $title = '';
        switch ($httpCode) {
            case 404:
                $title =  'Error : 404';
                break;
            case 500:
                $title =  'Error : 500';
                break;
        }

        $view->assign('errorCode', $httpCode);
        $view->assign('titleSeo', $title);
        $view->assign('message', $message);

        die();
    }
}
