<?php

namespace App\Controller;

use App\Core\View;

class Admin
{
    public function dashboard()
    {
        $firstname = "Nicolas";
        $lastname = "CHARVIER";

        $view = new View("dashboard", "back");
        $view->assign("firstname", $firstname);
        $view->assign("lastname", $lastname);

    }
}