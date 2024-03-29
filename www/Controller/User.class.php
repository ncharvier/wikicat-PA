<?php

namespace App\Controller;

use App\Core\AccessManager;
use App\Core\baseController;
use App\Core\PHPMailerManager;
use App\Core\Validator;
use App\Core\View;
use App\Model\User as UserModel;
use App\Core\Theme;

Theme::loadCurrentTheme();

class User extends baseController{
    public function logout(){

        if(!empty($_SESSION["connectedUser"]["id"])){
            $user = new UserModel();

            $user = $user->setId($_SESSION["connectedUser"]["id"]);

            $user->clearToken();

            $user->save();
        }

        session_destroy();

        header('Location: /');
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
        $view->assign("currentTheme", Theme::getCurrentTheme());
    }

    public function register()
    {
        $user = new UserModel();

        if( !empty($_POST)){
            $result = Validator::run($user->getFormRegister(), $_POST);

            if(empty($result)){
                $user->setLogin($_POST["login"]);
                $user->setEmail($_POST["email"]);
                $user->setPassword($_POST["password"]);
                $user->generateValidationToken();

                $user->save();
                $user = $user->getByEmail($user->getEmail());

                $mailer = PHPMailerManager::getInstance();
                $mailer->send($user->getEmail(),
                    'email de validation',
                    "je suis un email de validation <a href='" . ROOT_URL . "/valideAccount?token=". $user->getValidationToken() . "&user=" . $user->getId() . "'>cliquez ici</a>");

                $view = new View("accountCreationSuccess", "auth");
                die();
                header('Location: /login');
            }
        } else {
            $view = new View("register", "auth");
            $view->assign("user",$user);
        }


        $view = new View("register", "auth");
        $view->assign("user",$user);
        $view->assign("currentTheme", Theme::getCurrentTheme());
    }

    public function valideAccount()
    {
        if(!empty($_GET["token"]) && !empty($_GET["user"])){
            $user = new UserModel();

            $user = $user->setId($_GET["user"]);

            if (!empty($user) && ($user->getValidationToken() == $_GET["token"])){
                $user->setStatus(1);
                $user->clearValidationToken();
                $user->save();
                header('Location: /login');
            }
        }
    }

    public function accountUpdate()
    {
        $changedEmail = false;
        if(AccessManager::isLogged()){
            $user = new UserModel();
            $user = $user->setId($_SESSION['connectedUser']['id']);


            if(!empty($_POST['login']) && ($_POST['login'] !== $user->getLogin()))
            {
                $result = Validator::run($user->getLoginUpdate(), ["login"=>$_POST['login']]);
                if(empty($result)) {
                    $user->setLogin($_POST["login"]);
                    $user->save();
                }
            }
            else if(!empty($_POST['email']) && ($_POST['email'] !== $user->getEmail()))
            {
                $result = Validator::run($user->getEmailUpdate(), ["email"=>$_POST['email']]);

                if(empty($result)){
                    $user->setEmail($_POST["email"]);
                    $user->save();
                    $changedEmail = true;
                    $mailer = PHPMailerManager::getInstance();
                    $mailer->send($user->getEmail(),
                        'email de validation',
                        "je suis un email de validation <a href='" . ROOT_URL . "/valideAccount?token=". $user->getValidationToken() . "&user=" . $user->getId());
                }
            }
            else if(!empty($_POST['password']) )
            {
                $result = Validator::run($user->getPasswordUpdate(), ["password"=>$_POST["password"]]);
                if(empty($result)){
                    $user->setPassword($_POST["password"]);
                    $user->save();
                }
            }
            if($changedEmail){
                self::logout();
            }else{
                header("Location: /w/accueil");
            }
        }else{
            echo 'Error';
        }
    }

    public function forgotPassword(){
        $user = new UserModel();
        $view = new View("forgotPassword", "auth");

        if( !empty($_POST)){
            $result = Validator::run($user->getForgotPassword(), $_POST);
            if(empty($result)){
                $user = $user->getByEmail($_POST["email"]);

                $user->generatePasswordForgetToken();
                $user->save();

                $sender = PHPMailerManager::getInstance();
                $sender->send($_POST["email"],
                    'Récupération de mot de passe Wikicat',
                    'Une demande de réinitialisation de mot de passe à été faite.
                 Si vous n\'êtes pas à l\'origine de cette demande, vous pouvez ignorer ce mail. 
                 Dans le cas contraire, nous vous invitons à <a href=\'' . ROOT_URL . "/acquireNewPassword?id=" . $user->getId() . "&token="  . $user->getPasswordForgetToken() . "'>cliquez ici</a>");

                $view->assign("emailSent", 1);
            }
        }
        $view->assign("user",$user);
    }

    public function acquireNewPassword(){
        $view = new View("acquireNewPassword", "auth");

        if(!empty($_GET["token"])){
            $user = new UserModel();

            $user = $user->setId($_GET["id"]);

            if($user->getPasswordForgetToken() == NULL){
                header('Location: /login');
            }

            if (!empty($user) && ($user->getPasswordForgetToken() == $_GET["token"])){
                $_SESSION["forgotPasswordToken"] = $user->getPasswordForgetToken();
                $_SESSION["idUser"] = $user->getId();

                $user->save();
            }
            $view->assign("user",$user);
        }else{
            echo "Il semblerait que vous essayez d'accèder à un compte dont le mot de passe a déjà été réinitialiser";
        }
    }

    public function passwordReset(){

        $user = new UserModel();

        $user = $user->setId($_POST["idUser"]);

        Validator::run($user->getChangePassword(), $_POST);

        if(isset($_POST["password"]) && isset($_POST["passwordConfirmation"])) {
            if($_POST["password"] == $_POST["passwordConfirmation"]){
                $user->setPassword($_POST["password"]);
                unset($_SESSION["forgotPasswordToken"]);
                $user->clearPasswordForgetToken();
                $user->clearValidationToken();

                $user->save();

                header('Location: /login');
            }
        }else{
            die("Erreur");
        }
    }
}
