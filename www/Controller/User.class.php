<?php

namespace App\Controller;

session_start();

use App\Core\BaseSQL;
use App\Core\Validator;
use App\Core\View;
use App\Model\User as UserModel;

class User{

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
                    $user->generateToken();

                    $user->save();

                    $_SESSION["connectedUser"]["id"] = $user->getId();
                    $_SESSION["connectedUser"]["login"] = $user->getLogin();
                    $_SESSION["connectedUser"]["email"] = $user->getEmail();
                    $_SESSION["connectedUser"]["token"] = $user->getToken();

                    print_r($_SESSION);
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

    public function logout()
    {
        echo "Se deco";
    }

    public function register()
    {
        $user = new UserModel();

        print_r($_POST);
        if( !empty($_POST)){
            $result = Validator::run($user->getFormRegister(), $_POST);
            print_r($result);

            $user->setLogin($_POST["login"]);
            $user->setEmail($_POST["email"]);
            $user->setPassword($_POST["password"]);

            $user->save();
        }


        $view = new View("register");
        $view->assign("user",$user);
    }
    public function accountUpdate()
    {
        $user = new UserModel();
        print_r($_POST);
        if(!empty($_POST)){
            $result = Validator::run($user->getLoginUpdate(), $_POST);
            print_r($result);

            $user->setLogin($_POST["login"]);
            $user->setEmail($_POST["email"]);
            $user->setPassword($_POST["password"]);

            $user->save();
        }
        $view = new View("accountUpdate");
        $view->assign("user",$user);
    }
}