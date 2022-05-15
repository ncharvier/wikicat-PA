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

        if (empty($_POST['themeName']))
            return "You need to en enter a name";

        $themeName = htmlspecialchars($_POST['themeName']);
        unset($_POST['themeName']);
        unset($_POST['submitTheme']);
        unset($_POST['selectThemeName']);
        unset($_POST['picture']);

        if (Theme::exist($themeName))
            return "Theme name already exist";

        $theme->setName($themeName);
        $theme->setContent(json_encode($_POST));
        $theme->save();

        return "";
    }

    /**
     * modify a theme
     * @return string
     */
    private function modifyTheme() {
        $theme = new Theme();

        if (empty($_POST['selectThemeName']))
            return "You need to en enter a name";

        $themeName = htmlspecialchars($_POST['selectThemeName']);
        unset($_POST['themeName']);
        unset($_POST['modify']);
        unset($_POST['submitTheme']);
        unset($_POST['selectThemeName']);
        unset($_POST['picture']);

        if (!Theme::exist($themeName))
            return "Theme name does not exist";

        $theme->setName($themeName);
        $theme->setContent(json_encode($_POST));
        $theme->save();

        return "";
    }

    /**
     * delete a theme
     * @return string
     */
    private function deleteTheme()
    {
        $theme = new Theme();

        if (empty($_POST['selectThemeName']))
            return "You need to en enter a name";

        $themeName = htmlspecialchars($_POST['selectThemeName']);

        if ($themeName == "default")
            return "You can't delete default theme";

        if (!Theme::exist($themeName))
            return "Theme name does not exist";

        Theme::delete($themeName);

        return "";
    }

    /**
     * TODO : faire import theme
     * import a theme
     * @return string
     */
    private function importTheme()
    {
        $theme = new Theme();
        $name = basename($_FILES['fileTheme']['name']);
        $nameWithoutExt = explode('.', $name)[0];
        $tmpName = $_FILES['fileTheme']['tmp_name'];
        $size = $_FILES['fileTheme']['size'];
        $type = $_FILES['fileTheme']['type'];

        if ($size <= 0 || $size > 20000)
            return "File size too heavy";

        if ($type !== "application/json")
            return "File must be a json";

        if (Theme::exist($nameWithoutExt))
            return "Theme name already exist";

        $theme->setName($nameWithoutExt);
        $theme->setContent(file_get_contents($tmpName));
        $theme->save();

        return "";
    }

    /**
     * export a theme
     * @return string
     */
    public function exportTheme()
    {
        $theme = new Theme();
        $selectedTheme = htmlspecialchars($_POST['selectThemeName']);

        if (empty($selectedTheme))
            return "You need to en enter a name";

        $fullPath = PATHTMP."/$selectedTheme.zip";

        if (!Theme::exist($selectedTheme))
            return "File does not exist";

        $theme->getByName($selectedTheme);
        $code = $theme->compressToZip($selectedTheme.".zip");

        if ($code !== 0)
            return "Something wrong with compression : $code";

        header('Content-Description: Download theme');
        /* header('Content-Type: application/octet-stream'); */
        header('Content-Disposition: attachment; filename="'.$selectedTheme.'.zip"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fullPath));
        readfile($fullPath);

        return "";
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
