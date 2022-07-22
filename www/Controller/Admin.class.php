<?php
namespace App\Controller;

use App\Core\AccessManager;
use App\Core\baseController;
use App\Core\View;
use App\Core\Theme;
use App\Core\ErrorManager;
use App\Model\Role;
use App\Model\Role as RoleModel;
use App\Model\WikiPage as Page;
use App\Model\WikiPageVersion as PageVersion;
use App\Model\User;

class Admin extends baseController
{
    public function dashboard()
    {
        AccessManager::accessIfAdmin();
        $user = new User();
        $page = new Page();
        $view = new View("back/dashboard", "back");
        $view->assign("activePage", "dashboard");
        $view->assign("nbUser", $user->count());
        $view->assign("nbCreatedUser", $user->count(7));
        $view->assign("nbPage", $page->count());
        $view->assign("nbCreatedPage", $page->count(7));
    }

    public function user()
    {
        AccessManager::accessIfAdmin();
        $user = new User();

        $view = new View("back/user", "back");
        $view->assign("userList", $user->getAllUserAndRole());
        $view->assign("activePage", "user");
    }

    public function adminActiveUser() {
        AccessManager::accessIfAdmin();
        $user = new User();

        if (!empty($_POST['userId'])) {
            $user = $user->setId($_POST['userId']);
            $user->setStatus(1);
            $user->save();
        }

        header("location: /admin/user");
    }

    public function adminBanUser() {
        AccessManager::accessIfAdmin();
        $user = new User();

        if (!empty($_POST['userId'])) {
            $user = $user->setId($_POST['userId']);
            $user->setStatus(2);
            $user->save();
        }

        header("location: /admin/user");
    }

    public function adminModifyRole() {
        AccessManager::accessIfAdmin();
        $user = new User();

        if (!empty($_POST['userId']) || !empty($_POST['role']) || $_POST['role'] !== null) {
            $user = $user->setId($_POST['userId']);
            $user->setRole($_POST['role']);
            $user->save();
        }

        header("location: /admin/user");
    }

    public function adminResetPasswordUser() {
        AccessManager::accessIfAdmin();
        $user = new User();

        if (!empty($_POST['userId']) || !empty($_POST['resetPassword'])) {
            $user = $user->setId($_POST['userId']);
            $user->setPassword($_POST['resetPassword']);
            $user->save();
        }

        header("location: /admin/user");
    }

    public function adminDeleteUser() {
        AccessManager::accessIfAdmin();
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
        AccessManager::accessIfAdmin();
        $role = new RoleModel();
        $roleList = $role->getAll();
        unset($roleList[0]); // Remove the superuser from the list

        $view = new View("back/role", "back");
        $view->assign("role", $role);
        $view->assign("activePage", "role");
        $view->assign("titleSeo", "Rôles");
        $view->assign("roleList", $roleList);

    }

    public function pageList()
    {
        AccessManager::accessIfAdmin();
        $page = new Page();
        $view = new View("back/pageList", "back");
        $view->assign("pageList", $page->getAllPageAndVersion());
        $view->assign("activePage", "page");
    }

    public function pageTree()
    {
        AccessManager::accessIfAdmin();
        $view = new View("back/pageTree", "back");
        $view->assign("activePage", "page");
    }

    public function pageTemplate()
    {
        AccessManager::accessIfAdmin();
        $view = new View("back/pageTemplate", "back");
        $view->assign("activePage", "page");
    }

    public function comment()
    {
        AccessManager::accessIfAdmin();
        $view = new View("back/comment", "back");
        $view->assign("activePage", "comment");
    }

    public function visualSetting() {
        AccessManager::accessIfAdmin();
        $selected = htmlspecialchars($_POST['selectThemeName'] ?? "default");
        $theme = new Theme();
        $errorAndTheme = ['error'=>"", 'theme'=>$selected];
        $path = preg_replace("%^.*(/Assets/themes/)$%", "$1", PATH);

        if (!empty($_POST['submitTheme']))
            $errorAndTheme = $this->createTheme();
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
        $view->assign("activePage", "visualSetting");
        $view->assign("themeList", Theme::getThemeList());
        $view->assign("error", $error);
    }

    /**
     * create a theme
     * @return array
     */
    private function createTheme() {
        AccessManager::accessIfAdmin();
        $theme = new Theme();

        if (empty($_POST['themeName']))
            return ['error'=>"You need to en enter a name", 'theme'=>"default"];

        $themeName = htmlspecialchars($_POST['themeName']);
        unset($_POST['themeName']);
        unset($_POST['submitTheme']);
        unset($_POST['selectThemeName']);
        unset($_POST['picture']);

        if (Theme::exist($themeName))
            return ['error'=>"Theme name already exist", 'theme'=>"default"];

        $theme->setName($themeName);
        $theme->setContent(json_encode($_POST));
        $theme->save();

        return ['error'=>"", 'theme'=>$themeName];
    }

    /**
     * modify a theme
     * @return array
     */
    private function modifyTheme() {
        AccessManager::accessIfAdmin();
        $theme = new Theme();

        if (empty($_POST['selectThemeName']))
            return ['error'=>"You need to en enter a name", 'theme'=>"default"];

        $themeName = htmlspecialchars($_POST['selectThemeName']);
        unset($_POST['themeName']);
        unset($_POST['modify']);
        unset($_POST['submitTheme']);
        unset($_POST['selectThemeName']);
        unset($_POST['picture']);

        if (!Theme::exist($themeName))
            return ['error'=>"Theme name does not exist", 'theme'=>"default"];

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
        AccessManager::accessIfAdmin();
        $theme = new Theme();

        if (empty($_POST['selectThemeName']))
            return ['error'=>"You need to en enter a name", 'theme'=>"default"];

        $themeName = htmlspecialchars($_POST['selectThemeName']);

        if ($themeName == "default")
            return ['error'=>"You can't delete default theme", 'theme'=>"default"];

        if (!Theme::exist($themeName))
            return ['error'=>"Theme name does not exist", 'theme'=>"default"];

        Theme::delete($themeName);

        return ['error'=>"", 'theme'=>"default"];
    }

    /**
     * import a theme
     * @return array
     */
    private function importTheme() {
        AccessManager::accessIfAdmin();
        $theme = new Theme();
        $name = basename($_FILES['fileTheme']['name']);
        $nameWithoutExt = explode('.', $name)[0];
        $tmpName = $_FILES['fileTheme']['tmp_name'];
        $size = $_FILES['fileTheme']['size'];
        $type = $_FILES['fileTheme']['type'];

        if ($size <= 0 || $size > 20000)
            return ['error'=>"File size too heavy", 'theme'=>"default"];

        if ($type !== "application/json")
            return ['error'=>"File must be a json", 'theme'=>"default"];

        if (Theme::exist($nameWithoutExt))
            return ['error'=>"Theme name already exist", 'theme'=>"default"];

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
        AccessManager::accessIfAdmin();
        $theme = new Theme();
        $selectedTheme = htmlspecialchars($_POST['selectThemeName']);

        if (empty($selectedTheme))
            return ['error'=>"You need to en enter a name", 'theme'=>"default"];

        $fullPath = PATHTMP."/$selectedTheme.zip";

        if (!Theme::exist($selectedTheme))
            return ['error'=>"File does not exist", 'theme'=>"default"];

        $theme->getByName($selectedTheme);
        $code = $theme->compressToZip($selectedTheme.".zip");

        if ($code !== 0)
            return ['error'=>"Something wrong with compression : $code", 'theme'=>$selectedTheme];

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
        AccessManager::accessIfAdmin();
        $theme = new Theme();
        $selectedTheme = htmlspecialchars($_POST['selectThemeName']);
        $renameTheme = htmlspecialchars($_POST['renameTheme']);

        if (empty($renameTheme) || empty($selectedTheme))
            return ['error'=>"You need to en enter a name", 'theme'=>"default"];

        if ($selectedTheme === $renameTheme)
            return ['error'=>"New name and old name cannot be the same", 'theme'=>$selectedTheme];

        if (!Theme::exist($selectedTheme))
            return ['error'=>"File does not exist", 'theme'=>"default"];

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
        AccessManager::accessIfAdmin();
        $role = new RoleModel();

        $_POST["colour"] = substr($_POST["colour"], 1);

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
        AccessManager::accessIfAdmin();
        $role = new RoleModel();
        $role = $role->setId($_POST["id"]);

        $_POST["colour"] = substr($_POST["colour"], 1);

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
        AccessManager::accessIfAdmin();
        $role = new RoleModel();
        $role = $role->setId($_POST["id"]);

        $role->delete();
        header('Location: /admin/role');
    }



    public function plugin()
    {
        AccessManager::accessIfAdmin();
        $view = new View("back/plugin", "back");
        $view->assign("activePage", "plugin");
    }

    public function globalSetting()
    {
        AccessManager::accessIfAdmin();
        $view = new View("back/globalSetting", "back");
        $view->assign("activePage", "globalSetting");
    }
}
