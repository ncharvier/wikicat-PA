<?php

namespace App\Controller;

use App\Core\CleanWords;
use App\Core\View;
use App\Model\User as UserModel;

class User{

    public function login()
    {
        new View("login");
    }

    public function logout()
    {
        echo "Se deco";
    }

    public function register()
    {
        $user = new UserModel();

        $user = $user->setId(1);

        $user->setEmail("CHarVier.NIcolas@gmail.com   ");
        $user->setFirstname("NICOlas ");
        $user->setLastname("  charVIER");
        $user->setPassword("Test1234");

        $user->save();

        new View("register");
    }

}