<?php

namespace App\Controller;

use App\Core\View;

class General{

    public function home()
    {
        echo "Welcome";
    }

    public function contact()
    {
        $view = new View("contact");
    }
}


