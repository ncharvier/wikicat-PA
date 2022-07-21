<?php

namespace App\Controller;

use App\Core\View;
use App\Core\AccessManager as AccessManager;
use App\Core\PHPMailerManager;
use App\Model\User;
use App\Core\ErrorManager;

class General{

    public function home()
    {
        $isLogged = AccessManager::isLogged();

        if($isLogged){
            header('Location: /w/accueil');
        } else {
            header('Location: /login');
        }
    }
}


