<?php

namespace App\Controller;

use App\Core\View;

class Admin
{
    public function dashboard(){
        $firstname = "Nicolas";

        new View("dashboard", "back");
    }
}