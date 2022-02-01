<?php

namespace App\Controller;

class Error
{
    public function page404(){
        http_response_code(404);
        die("404");
    }

    public function page500(){
        http_response_code(500);
        die("500");
    }
}