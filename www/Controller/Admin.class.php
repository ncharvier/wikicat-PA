<?php

namespace App\Controller;

session_start();

use App\Core\View;
use App\Model\Theme;

class Admin
{
    public function dashboard()
    {
        $view = new View("back/dashboard", "back");
        $view->assign("activePage", "dashboard");

    }

    public function user()
    {
        $view = new View("back/user", "back");
        $view->assign("activePage", "user");
    }

    public function role()
    {
        $view = new View("back/role", "back");
        $view->assign("activePage", "role");
    }

    public function pageList()
    {
        $view = new View("back/pageList", "back");
        $view->assign("activePage", "page");
    }

    public function pageTemplate()
    {
        $view = new View("back/pageTemplate", "back");
        $view->assign("activePage", "page");
    }

    public function comment()
    {
        $view = new View("back/comment", "back");
        $view->assign("activePage", "comment");
    }

    public function visualSetting()
    {
        $userId = $_SESSION["connectedUser"]["id"];
        $error = "";

        if (!empty($_POST['submitTheme'])) {
            if (!empty($_POST['themeName'])) {
                $themeName = $_POST['themeName'];
                unset($_POST['themeName']);
                unset($_POST['submitTheme']);

                $theme = new Theme();
                $theme->setUserId($userId);
                $theme->setName($themeName);
                $theme->setContent(json_encode($_POST));
                $theme->save();
            }
            else {
                $error = "You need to en enter a name";
            }
        }

        $theme2 = new Theme();
        $themeList = $theme2->getThemeListByUserId($userId);

        $view = new View("back/visualSetting", "back");
        $view->assign("activePage", "visualSetting");
        $view->assign("themeList", $themeList);
        $view->assign("error", $error);
    }

    public function plugin()
    {
        $view = new View("back/plugin", "back");
        $view->assign("activePage", "plugin");
    }

    public function globalSetting()
    {
        $view = new View("back/globalSetting", "back");
        $view->assign("activePage", "globalSetting");
    }
}
