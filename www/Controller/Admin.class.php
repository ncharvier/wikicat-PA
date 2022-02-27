<?php

namespace App\Controller;

use App\Core\View;

class Admin
{
    public function dashboard()
    {
        $firstname = "Nicolas";
        $lastname = "CHARVIER";

        $view = new View("back/dashboard", "back");
        $view->assign("firstname", $firstname);
        $view->assign("lastname", $lastname);

    }

    public function user()
    {
        $view = new View("back/user", "back");
    }

    public function role()
    {
        $view = new View("back/role", "back");
    }

    public function pageList()
    {
        $view = new View("back/pageList", "back");
    }

    public function pageTemplate()
    {
        $view = new View("back/pageTemplate", "back");
    }

    public function comment()
    {
        $view = new View("back/comment", "back");
    }

    public function visualSetting()
    {
        $view = new View("back/visualSetting", "back");
    }

    public function plugin()
    {
        $view = new View("back/plugin", "back");
    }

    public function globalSetting()
    {
        $view = new View("back/globalSetting", "back");
    }
}