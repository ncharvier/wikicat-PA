<?php

namespace App\Core;

use App\Model\Role;
use App\Model\User as UserModel;
use App\Model\Role as RoleModel;

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
        if(AccessManager::isLogged()){
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
        if(AccessManager::isLogged()){
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
        if(AccessManager::isLogged()){
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
        if(AccessManager::isLogged()){
            $user = new UserModel();
            $user = $user->setId($_SESSION["connectedUser"]["id"]);

            $role = new RoleModel();
            $role = $role->setId($user->getRole());

            if($role->getAddComment() == 1 || $role->getIsSuperUser() == 1){
                return true;
            }
        }
        return false;
    }

    public static function canModifyPage(): bool{
        if(AccessManager::isLogged()){
            $user = new UserModel();
            $user = $user->setId($_SESSION["connectedUser"]["id"]);

            $role = new RoleModel();
            $role = $role->setId($user->getRole());

            if($role->getModifyPage() == 1 || $role->getIsSuperUser() == 1){
                return true;
            }
        }
        return false;
    }

    public static function canCreatePage(): bool{
        if(AccessManager::isLogged()){
            $user = new UserModel();
            $user = $user->setId($_SESSION["connectedUser"]["id"]);

            $role = new RoleModel();
            $role = $role->setId($user->getRole());

            if($role->getCreatePage() == 1 || $role->getIsSuperUser() == 1){
                return true;
            }
        }
        return false;
    }

    public static function accessIfAdmin(): void{
        if (!AccessManager::isAdmin()){
            echo "Vous n'avez pas l'autorisation nécessaire";
            http_response_code(401);
            die();
        }
    }

    public static function accessIfCanCreatePage(): void{
        if (!AccessManager::canCreatePage()){
            echo "Vous n'avez pas l'autorisation nécessaire";
            http_response_code(401);
            die();
        }
    }

    public static function accessIfCanModifyPage(): void{
        if (!AccessManager::canModifyPage()){
            echo "Vous n'avez pas l'autorisation nécessaire";
            http_response_code(401);
            die();
        }
    }

    public static function accessIfCanDeletePage(): void{
        if (!AccessManager::canDeletePage()){
            echo "Vous n'avez pas l'autorisation nécessaire";
            http_response_code(401);
            die();
        }
    }

    public static function accessIfLogged(): void{
        if (!AccessManager::isLogged()){
            echo "Vous n'avez pas l'autorisation nécessaire";
            http_response_code(401);
            die();
        }
    }
}