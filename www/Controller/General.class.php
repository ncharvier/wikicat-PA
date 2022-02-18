<?php

namespace App\Controller;

use App\Core\View;
use App\Core\AccessManager as AccessManager;
use App\Core\PHPMailerManager;

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

        /* $email = new PHPMailerManager(); */
        /* $retour = $email->send('teddy.gauthier@outlook.com', 'email de test', 'je suis un email de test'); */
        /* echo $retour ? 'email envoyer' : 'erreur'; */
    }

    public function contact()
    {
        $view = new View("contact");
    }
}


