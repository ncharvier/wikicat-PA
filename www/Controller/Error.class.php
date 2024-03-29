<?php

namespace App\Controller;

use App\Core\baseController;
use App\Core\View;

class Error extends baseController
{
    public function page404(){
        $view = new View("error");
        $message = htmlspecialchars($_GET["msg"] ?? "");

        $view->assign("errorCode", 404);
        $view->assign("titleSeo", "Error : 404");
        $view->assign("message", $message);

        http_response_code(404);
        die();
    }

    public function page500(){
        $view = new View('error');
        $message = htmlspecialchars($_GET["msg"] ?? "");

        $view->assign("errorCode", 500);
        $view->assign("titleSeo", "Error : 500");
        $view->assign("message", $message);

        http_response_code(500);
        die();
    }
}
