<?php
namespace App\Controller;

session_start();

use App\Core\AccessManager;
use App\Core\View;
use App\Core\Theme;
use App\Core\ErrorManager;
use App\Model\Role;
use App\Model\Role as RoleModel;
use App\Model\WikiPage as Page;
use App\Model\WikiPageVersion as PageVersion;
use App\Model\User;

Theme::loadCurrentTheme();

class Admin
{
    public function dashboard()
    {
        $user = new User();
        $page = new Page();
        $view = new View("back/dashboard", "back");
        $view->assign("activePage", "dashboard");
        $view->assign("nbUser", $user->count());
        $view->assign("nbCreatedUser", $user->count(7));
        $view->assign("nbPage", $page->count());
        $view->assign("nbCreatedPage", $page->count(7));
        $view->assign("currentTheme", Theme::getCurrentTheme());
    }

    public function user()
    {
        $user = new User();

        $view = new View("back/user", "back");
        $view->assign("userList", $user->getAll());
        $view->assign("activePage", "user");
        $view->assign("currentTheme", Theme::getCurrentTheme());
    }

    public function adminActiveUser() {
        $user = new User();

        if (!empty($_POST['userId'])) {
            $user = $user->setId($_POST['userId']);
            $user->setStatus(1);
            $user->save();
        }

        header("location: /admin/user");
    }

    public function adminBanUser() {
        $user = new User();

        if (!empty($_POST['userId'])) {
            $user = $user->setId($_POST['userId']);
            $user->setStatus(2);
            $user->save();
        }

        header("location: /admin/user");
    }

    public function adminResetPasswordUser() {
        $user = new User();

        if (!empty($_POST['userId']) || !empty($_POST['resetPassword'])) {
            $user = $user->setId($_POST['userId']);
            $user->setPassword($_POST['resetPassword']);
            $user->save();
        }

        header("location: /admin/user");
    }

    public function adminDeleteUser() {
        $user = new User();

        if (!empty($_POST['userId'])) {
            // TODO : delete user
            /* $user = $user->setId($_POST['userId']); */
            /* $user->setStatus(2); */
            /* $user->save(); */
        }

        header("location: /admin/user");
    }

    public function role()
    {
        $role = new RoleModel();
        $roleList = $role->getAll();
        unset($roleList[0]); // Remove the superuser from the list

        $view = new View("back/role", "back");
        $view->assign("role", $role);
        $view->assign("activePage", "role");
        $view->assign("titleSeo", "Rôles");
        $view->assign("roleList", $roleList);
        $view->assign("currentTheme", Theme::getCurrentTheme());

    }

    public function pageList()
    {
        $page = new Page();
        $view = new View("back/pageList", "back");
        $view->assign("pageList", $page->getAllPageAndVersion());
        $view->assign("activePage", "page");
        $view->assign("currentTheme", Theme::getCurrentTheme());
    }

    public function pageTemplate()
    {
        $view = new View("back/pageTemplate", "back");
        $view->assign("activePage", "page");
        $view->assign("currentTheme", Theme::getCurrentTheme());
    }

    public function comment()
    {
        $view = new View("back/comment", "back");
        $view->assign("activePage", "comment");
        $view->assign("currentTheme", Theme::getCurrentTheme());
    }

    public function visualSetting() {
        $selected = htmlspecialchars($_POST['selectThemeName'] ?? "default");
        $theme = new Theme();
        $errorAndTheme = ['error'=>"", 'theme'=>$selected];
        $path = preg_replace("%^.*(/Assets/themes/)$%", "$1", PATH);

        if (!empty($_POST['submitTheme']))
            $errorAndTheme = $this->createTheme();
        else if (!empty($_POST['apply']))
            $errorAndTheme = $this->applyTheme();
        else if (!empty($_POST['modify']))
            $errorAndTheme = $this->modifyTheme();
        else if (!empty($_POST['delete']))
            $errorAndTheme = $this->deleteTheme();
        else if (!empty($_POST['import']))
            $errorAndTheme = $this->importTheme();
        else if (!empty($_POST['export']))
            $errorAndTheme = $this->exportTheme();
        else if (!empty($_POST['rename']))
            $errorAndTheme = $this->renameTheme();

        $selectedTheme = $errorAndTheme['theme'];
        $error = $errorAndTheme['error'];
        $theme->getByName($selectedTheme);

        $view = new View("back/visualSetting", "back");
        $view->assign("content", json_decode($theme->getContent(), true));
        $view->assign("selectedTheme", $selectedTheme);
        $view->assign("currentTheme", Theme::getCurrentTheme());
        $view->assign("activePage", "visualSetting");
        $view->assign("themeList", Theme::getThemeList());
        $view->assign("cssAttributeCol1", Theme::getAttribute(0, 4));
        $view->assign("cssAttributeCol2", Theme::getAttribute(4, 8));
        $view->assign("cssAttributeCol3", Theme::getAttribute(8, 12));
        $view->assign("cssAttributeCol4", Theme::getAttribute(12, 14));
        $view->assign("cssAttributeCol5", Theme::getAttribute(14, 16));
        $view->assign("error", $error);
    }

    /**
     * create a theme
     * @return array
     */
    private function createTheme() {
        $theme = new Theme();

        if (empty($_POST['themeName']))
            return ['error'=>"Vous devez entrer un nom de theme", 'theme'=>"default"];

        $themeName = htmlspecialchars($_POST['themeName']);
        unset($_POST['themeName']);
        unset($_POST['submitTheme']);
        unset($_POST['selectThemeName']);

        if (Theme::exist($themeName))
            return ['error'=>"Le theme existe déjà", 'theme'=>"default"];

        $theme->setName($themeName);
        $theme->setContent(json_encode($_POST));
        $theme->save();

        return ['error'=>"", 'theme'=>$themeName];
    }

    /**
     * undocumented function
     *
     * @return void
     */
    public function applyTheme() {
        $theme = new Theme();

        if (empty($_POST['selectThemeName']))
            return ['error'=>"Vous devez entrer un nom de theme", 'theme'=>"default"];

        Theme::$currentTheme = htmlspecialchars($_POST['selectThemeName']);
        file_put_contents(PATHCURRENTTHEME.'/currentTheme.txt', Theme::$currentTheme);
        return ['error'=>"", 'theme'=>Theme::$currentTheme];
    }

    /**
     * modify a theme
     * @return array
     */
    private function modifyTheme() {
        $theme = new Theme();

        if (empty($_POST['selectThemeName']))
            return ['error'=>"Vous devez entrer un nom de theme", 'theme'=>"default"];

        $themeName = htmlspecialchars($_POST['selectThemeName']);
        unset($_POST['themeName']);
        unset($_POST['modify']);
        unset($_POST['submitTheme']);
        unset($_POST['selectThemeName']);
        unset($_POST['renameTheme']);

        if (!Theme::exist($themeName))
            return ['error'=>"Le theme n'éxiste pas", 'theme'=>"default"];

        $theme->setName($themeName);
        $theme->setContent(json_encode($_POST));
        $theme->save();

        return ['error'=>"", 'theme'=>$themeName];
    }

    /**
     * delete a theme
     * @return array
     */
    private function deleteTheme() {
        $theme = new Theme();

        if (empty($_POST['selectThemeName']))
            return ['error'=>"Vous devez entrer un nom de theme", 'theme'=>"default"];

        $themeName = htmlspecialchars($_POST['selectThemeName']);

        if ($themeName == "default")
            return ['error'=>"Vous ne pouvez pas supprimer le theme par defaut", 'theme'=>"default"];

        if (!Theme::exist($themeName))
            return ['error'=>"Le theme n'éxiste pas", 'theme'=>"default"];

        Theme::delete($themeName);

        return ['error'=>"", 'theme'=>"default"];
    }

    /**
     * import a theme
     * @return array
     */
    private function importTheme() {
        $theme = new Theme();
        $name = basename($_FILES['fileTheme']['name']);
        $nameWithoutExt = explode('.', $name)[0];
        $tmpName = $_FILES['fileTheme']['tmp_name'];
        $size = $_FILES['fileTheme']['size'];
        $type = $_FILES['fileTheme']['type'];

        if ($size <= 0 || $size > 20000)
            return ['error'=>"Fichier trop gros", 'theme'=>"default"];

        if ($type !== "application/json")
            return ['error'=>"Le fichier doit être un json", 'theme'=>"default"];

        if (Theme::exist($nameWithoutExt))
            return ['error'=>"Le theme existe déjà", 'theme'=>"default"];

        $theme->setName($nameWithoutExt);
        $theme->setContent(file_get_contents($tmpName));
        $theme->save();

        return ['error'=>"", 'theme'=>$nameWithoutExt];
    }

    /**
     * export a theme
     * @return array
     */
    public function exportTheme() {
        $theme = new Theme();
        $selectedTheme = htmlspecialchars($_POST['selectThemeName']);

        if (empty($selectedTheme))
            return ['error'=>"Vous devez entrer un nom de theme", 'theme'=>"default"];

        $fullPath = PATHTMP."/$selectedTheme.zip";

        if (!Theme::exist($selectedTheme))
            return ['error'=>"Le theme n'éxiste pas", 'theme'=>"default"];

        $theme->getByName($selectedTheme);
        $code = $theme->compressToZip($selectedTheme.".zip");

        if ($code !== 0)
            return ['error'=>"Il y a eu une erreur avec la compression", 'theme'=>$selectedTheme];

        header('Content-Description: Download theme');
        /* header('Content-Type: application/octet-stream'); */
        header('Content-Disposition: attachment; filename="'.$selectedTheme.'.zip"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fullPath));
        readfile($fullPath);

        return ['error'=>"", 'theme'=>$selectedTheme];
    }

    /**
     * rename a theme
     * @return array
     */
    public function renameTheme() {
        $theme = new Theme();
        $selectedTheme = htmlspecialchars($_POST['selectThemeName']);
        $renameTheme = htmlspecialchars($_POST['renameTheme']);

        if (empty($renameTheme) || empty($selectedTheme))
            return ['error'=>"Vous devez entrer un nom de theme", 'theme'=>"default"];

        if ($selectedTheme === $renameTheme)
            return ['error'=>"L'ancien et le nouveau nom de peuvent pas être identique", 'theme'=>$selectedTheme];

        if (!Theme::exist($selectedTheme))
            return ['error'=>"Le theme n'éxiste pas", 'theme'=>"default"];

        $theme->getByName($selectedTheme);
        $theme->setName($renameTheme);
        $theme->save();
        Theme::delete($selectedTheme);

        return ['error'=>"", 'theme'=>$renameTheme];
    }

    /**
     * Creates a role
     */
    public static function createRole()
    {
        $role = new RoleModel();

        var_dump($_POST);

        $role->setName($_POST["name"]);
        $role->setColour($_POST["colour"]);
        $role->setCreatePage($_POST["createPage"]);
        $role->setModifyPage($_POST["modifyPage"]);
        $role->setDeletePage($_POST["deletePage"]);
        $role->setAddComment($_POST["addComment"]);
        $role->setAdminRights($_POST["adminRights"]);
        $role->setIsSuperUser(0);

        unset($_POST);

        $role->save();
        header('Location: /admin/role');
    }

    /**
     * Updates a role
     */
    public static function updateRole()
    {
        $role = new RoleModel();
        $role = $role->setId($_POST["id"]);

        $role->setName(ucfirst(strtolower($_POST["name"])));
        $role->setColour(strtoupper($_POST["colour"]));
        $role->setCreatePage($_POST["createPage"]);
        $role->setModifyPage($_POST["modifyPage"]);
        $role->setDeletePage($_POST["deletePage"]);
        $role->setAddComment($_POST["addComment"]);
        $role->setAdminRights($_POST["adminRights"]);

        $role->save();
        header('Location: /admin/role');
    }

    public static function deleteRole()
    {
        $role = new RoleModel();
        $role = $role->setId($_POST["id"]);

        $role->delete();
        header('Location: /admin/role');
    }



    public function plugin()
    {
        $view = new View("back/plugin", "back");
        $view->assign("activePage", "plugin");
        $view->assign("currentTheme", Theme::getCurrentTheme());
    }

    public function globalSetting()
    {
        $view = new View("back/globalSetting", "back");
        $view->assign("activePage", "globalSetting");
        $view->assign("currentTheme", Theme::getCurrentTheme());
    }
}
