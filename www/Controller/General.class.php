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
        $test = AccessManager::isLogged();

        if($test){
            echo "connecter";
        } else {
            echo"non connecter - <a href='/login'>se connecter</a>";
        }

        echo "Welcome";
    }

    public function contact()
    {
        $view = new View("contact");
    }
}


