<?php

namespace App\Controller;

session_start();

use App\Core\View;
use App\Core\Theme;

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
        $view = new View("back/visualSetting", "back");
        $theme = new Theme();
        $error = "";

        if (!empty($_POST['submitTheme'])) {
            if (!empty($_POST['themeName'])) {
                $themeName = htmlspecialchars($_POST['themeName']);
                unset($_POST['themeName']);
                unset($_POST['submitTheme']);
                unset($_POST['selectThemeName']);
                unset($_POST['picture']);

                if (!$theme->exist($themeName)) {
                    $theme->setName($themeName);
                    $theme->setContent(json_encode($_POST));
                    $theme->save();
                }
                else
                    $error = "Theme name already exist";
            }
            else
                $error = "You need to en enter a name";
        }
        else if (!empty($_POST['select'])) {
            $themeName = htmlspecialchars($_POST['selectThemeName']);
            $theme->getByName($themeName);
            $view->assign("content", json_decode(json_decode($theme->getContent()), true));
        }
        else if (!empty($_POST['modify'])) {
            if (!empty($_POST['selectThemeName'])) {
                $themeName = htmlspecialchars($_POST['selectThemeName']);
                unset($_POST['themeName']);
                unset($_POST['modify']);
                unset($_POST['submitTheme']);
                unset($_POST['selectThemeName']);
                unset($_POST['picture']);

                if ($theme->exist($themeName)) {
                    $theme->setName($themeName);
                    $theme->setContent(json_encode($_POST));
                    $theme->save();
                }
                else
                    $error = "Theme name does not exist";
            }
            else
                $error = "You need to en enter a name";
        }
        else if (!empty($_POST['delete'])) {
            if (!empty($_POST['selectThemeName'])) {
                $themeName = htmlspecialchars($_POST['selectThemeName']);
                if ($themeName != "default")
                    if ($theme->exist($themeName))
                        $theme->delete($themeName);
                    else
                        $error = "Theme name does not exist";
                else
                    $error = "You can't delete default theme";
            }
            else
                $error = "You need to en enter a name";
        }

        $view->assign("selectedTheme", $themeName ?? "default");
        $view->assign("activePage", "visualSetting");
        $view->assign("themeList", $theme->getThemeList());
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
