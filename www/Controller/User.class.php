<?php

namespace App\Controller;

session_start();

use App\Core\AccessManager;
use App\Core\BaseSQL;
use App\Core\PHPMailerManager;
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

        $view = new View("login", "auth");

        if( !empty($_POST)){
            $userToConnect = $user->getByEmail($_POST["email"]);

            if(!empty($userToConnect)){
                $user = $userToConnect;

                if(password_verify($_POST["password"],$user->getPassword()) && $user->getStatus() == 1){
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
                $user->generateValidationToken();

                $mailer = PHPMailerManager::getInstance();
                echo $mailer->send('tshadow42@gmail.com', 'email de test', "je suis un email de test <a href='" . ROOT_URL . "/valideAccount?token=". $user->getValidationToken() ."></a>");

                $user->save();

                header('Location: /login');
            }
        }


        $view = new View("register", "auth");
        $view->assign("user",$user);
    }

    public function valideAccount()
    {
        if(!empty($_GET["token"]) && !empty($_GET["user"])){
            $user = new UserModel();

            $user = $user->setId($_GET["user"]);

            if (!empty($user) && ($user->getValidationToken() == $_GET["token"])){
                echo "lien ok";
                $user->setStatus(1);
                $user->clearValidationToken();
                $user->save();
            }
        }
    }

    public function accountUpdate()
    {
        if(AccessManager::isLogged()){
            $user = new UserModel();
            $user = $user->setId($_SESSION['connectedUser']['id']);
            print_r($_POST);

            if(!empty($_POST['login']))
            {
                $result = Validator::run($user->getLoginUpdate(), $_POST);
                print_r($result);

                $user->setLogin($_POST["login"]);
                $user->save();
            }
            else if(!empty($_POST['email']))
            {
                $result = Validator::run($user->getEmailUpdate(), $_POST);
                print_r($result);

                $user->setEmail($_POST["email"]);
                $user->save();
            }
            else if(!empty($_POST['password']))
            {
                $result = Validator::run($user->getPasswordUpdate(), $_POST);
                print_r($result);

                $user->setPassword($_POST["password"]);
                $user->save();
            }
            $view = new View("accountUpdate");
            $view->assign("user",$user);
        }else{
            echo 'Error';
        }
    }
}
