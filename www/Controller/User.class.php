<?php

namespace App\Controller;

session_start();

use App\Core\BaseSQL;
use App\Core\Validator;
use App\Core\View;
use App\Model\User as UserModel;

class User{
    public function logout(){

        if(!empty($_SESSION["connectedUser"]["id"])){
            $user = new UserModel();

            $user = $user->setId($_SESSION["connectedUser"]["id"]);

            $user->clearToken();

            $user->save();
        }

        session_destroy();

        echo "déconnecté";
    }

    public function login()
    {
        $loginError = false;

        $user = new UserModel();

        $view = new View("Login");

        if( !empty($_POST)){
            $userToConnect = $user->getByEmail($_POST["email"]);

            if(!empty($userToConnect)){
                $user = $userToConnect;

                if(password_verify($_POST["password"],$user->getPassword()) || $user->getStatus() == 1){
                    $user->updateUserSession();

                    header('Location: /');
                }
                else{
                    $loginError = true;
                }
            }
            else{
                $loginError = true;
            }
        }

        if($loginError){
            $view->assign("loginError","Identifiants invalides");
        }

        $view->assign("titleSeo","Se connecter au site");
        $view->assign("user",$user);
    }

    public function register()
    {
        $user = new UserModel();

        if( !empty($_POST)){
            $result = Validator::run($user->getFormRegister(), $_POST);
            print_r($result);

            if(empty($result)){
                $user->setLogin($_POST["login"]);
                $user->setEmail($_POST["email"]);
                $user->setPassword($_POST["password"]);

                $user->save();

                header('Location: /login');
            }
        }


        $view = new View("register");
        $view->assign("user",$user);
    }
}