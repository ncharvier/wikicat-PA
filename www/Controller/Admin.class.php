<?php

// TODO : faille %00

namespace App\Controller;

session_start();

use App\Core\View;
use App\Core\Theme;
use App\Core\ErrorManager as Error;

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
        $selectedTheme = htmlspecialchars($_POST['selectThemeName'] ?? "default");
        $view = new View("back/visualSetting", "back");
        $theme = new Theme();
        $error = "";
        $path = preg_replace("%^.*(/Assets/themes/)$%", "$1", PATH);

        if (!empty($_POST['submitTheme']))
            $error = $this->createTheme();
        else if (!empty($_POST['modify']))
            $error = $this->modifyTheme();
        else if (!empty($_POST['delete']))
            $error = $this->deleteTheme();
        else if (!empty($_POST['import']))
            $error = $this->importTheme();
        else if (!empty($_POST['export']))
            $error = $this->exportTheme();


        $theme->getByName($selectedTheme);

        /* $view->assign("file", $path.$theme->getName()); */
        $view->assign("fileName", $theme->getName());
        /* $view->assign("exportRoute", "/admin/exportTheme/?theme=".$theme->getName()); */
        $view->assign("content", json_decode($theme->getContent(), true));
        $view->assign("selectedTheme", $selectedTheme);
        $view->assign("activePage", "visualSetting");
        $view->assign("themeList", Theme::getThemeList());
        $view->assign("error", $error);
    }

    /**
     * create a theme
     * @return string
     */
    private function createTheme()
    {
        $theme = new Theme();
        $error = "";

        if (!empty($_POST['themeName'])) {
            $themeName = htmlspecialchars($_POST['themeName']);
            unset($_POST['themeName']);
            unset($_POST['submitTheme']);
            unset($_POST['selectThemeName']);
            unset($_POST['picture']);

            if (!Theme::exist($themeName)) {
                $theme->setName($themeName);
                $theme->setContent(json_encode($_POST));
                $theme->save();
            }
            else
                $error = "Theme name already exist";
        }
        else
            $error = "You need to en enter a name";

        return $error;
    }

    /**
     * modify a theme
     * @return string
     */
    private function modifyTheme()
    {
        $theme = new Theme();
        $error = "";

        if (!empty($_POST['selectThemeName'])) {
            $themeName = htmlspecialchars($_POST['selectThemeName']);
            unset($_POST['themeName']);
            unset($_POST['modify']);
            unset($_POST['submitTheme']);
            unset($_POST['selectThemeName']);
            unset($_POST['picture']);

            if (Theme::exist($themeName)) {
                $theme->setName($themeName);
                $theme->setContent(json_encode($_POST));
                $theme->save();
            }
            else
                $error = "Theme name does not exist";
        }
        else
            $error = "You need to en enter a name";

        return $error;
    }

    /**
     * delete a theme
     * @return string
     */
    private function deleteTheme()
    {
        $theme = new Theme();
        $error = "";

        if (!empty($_POST['selectThemeName'])) {
            $themeName = htmlspecialchars($_POST['selectThemeName']);
            if ($themeName != "default")
                if (Theme::exist($themeName))
                    Theme::delete($themeName);
                else
                    $error = "Theme name does not exist";
            else
                $error = "You can't delete default theme";
        }
        else
            $error = "You need to en enter a name";

        return $error;
    }

    /**
     * TODO : faire import theme
     * import a theme
     * @return string
     */
    private function importTheme()
    {
        return "merde";
    }

    /**
     * TODO : finir export theme
     * export a theme
     * @return string
     */
    public function exportTheme()
    {
        $theme = new Theme();
        $error = "";
        $code = 0;
        $selectedTheme = htmlspecialchars($_POST['selectThemeName']);

        if (!empty($selectedTheme)) {
            $theme->getByName($selectedTheme);
            $code = $theme->compressToZip($selectedTheme.".zip");
            if ($code !== 0)
                $error = "Something wrong with compression : $code";
        }
        else
            $error = "You need to en enter a name";

        /* header('location: /admin/visualSetting'); */
        return $error;
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
