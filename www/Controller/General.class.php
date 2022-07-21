<?php

namespace App\Controller;

use App\Core\baseController;
use App\Core\View;
use App\Core\AccessManager as AccessManager;
use App\Core\PHPMailerManager;
use App\Model\User;
use App\Core\ErrorManager;

class General extends baseController{

    public function home()
    {
        header('Location: /w/accueil');
    }
}


