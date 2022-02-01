<?php

namespace App\Controller;

use App\Core\BaseSQL;
use App\Core\Validator;
use App\Core\View;
use App\Model\User as UserModel;

class User{

    public function login()
    {
        $view = new View("Login");
        $view->assign("titleSeo","Se connecter au site");
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
        }

        //$user= $user->setId(3);
        //$user->setEmail("toto@gmail.com");
        //$user->save();

        $view = new View("register");
        $view->assign("user",$user);
    }

}