<?php

namespace App\Core;

use App\Model\Role;
use App\Model\User as UserModel;
use App\Model\User as RoleModel;

session_start();

class AccessManager
{
    public static function isLogged(): bool{
        if(!empty($_SESSION["connectedUser"]["id"])){
            $user = new UserModel();
            $user = $user->setId($_SESSION["connectedUser"]["id"]);

            if ($user->getConnectionToken() == $_SESSION["connectedUser"]["token"]){
                $user->updateUserSession();

                return true;
            }
        }
        return false;
    }

    public static function isSuperUser(): bool{
        if(!empty($_SESSION["connectedUser"]["id"])){
            $user = new UserModel();
            $user = $user->setId($_SESSION["connectedUser"]["id"]);

            $role = new RoleModel();
            $role = $role->setId($user->getRole());

            if($role->getIsSuperUser() == 1){
                return true;
            }
        }
        return false;
    }

    public static function isAdmin(): bool{
        if(!empty($_SESSION["connectedUser"]["id"])){
            $user = new UserModel();
            $user = $user->setId($_SESSION["connectedUser"]["id"]);

            $role = new RoleModel();
            $role = $role->setId($user->getRole());

            if($role->getAdminRights() == 1 || $role->getIsSuperUser == 1) {
                return true;
            }
        }
        return false;
    }

    public static function canDeletePage(): bool{
        if(!empty($_SESSION["connectedUser"]["id"])){
            $user = new UserModel();
            $user = $user->setId($_SESSION["connectedUser"]["id"]);

            $role = new RoleModel();
            $role = $role->setId($user->getRole());

            if($role->getDeletePage() == 1 || $role->getIsSuperUser() == 1) {
                return true;
            }
        }
        return false;
    }

    public static function canPostComments(): bool{
        if(!empty($_SESSION["connectedUser"]["id"])){
            $user = new UserModel();
            $user = $user->setId($_SESSION["connectedUser"]["id"]);

            $role = new RoleModel();
            $role = $role->setId($user->getRole());

            if($role->getAddComment() == 1 || $role->getIsSuperUser == 1){
                return true;
            }
        }
        return false;
    }

    public static function canModifyPage(): bool{
        if(!empty($_SESSION["connectedUser"]["id"])){
            $user = new UserModel();
            $user = $user->setId($_SESSION["connectedUser"]["id"]);

            $role = new RoleModel();
            $role = $role->setId($user->getRole());

            if($role->getModifyPage() == 1 || $role->getIsSuperUser == 1){
                return true;
            }
        }
        return false;
    }

    public static function canCreatePage(): bool{
        if(!empty($_SESSION["connectedUser"]["id"])){
            $user = new UserModel();
            $user = $user->setId($_SESSION["connectedUser"]["id"]);

            $role = new RoleModel();
            $role = $role->setId($user->getRole());

            if($role->getCreatePage() == 1 || $role->getIsSuperUser == 1){
                return true;
            }
        }
        return false;
    }

}