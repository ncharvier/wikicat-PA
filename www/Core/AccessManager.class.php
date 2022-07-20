<?php

namespace App\Core;

use App\Model\User as UserModel;

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
}