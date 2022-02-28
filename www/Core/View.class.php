<?php

namespace App\Core;

class View
{
    private $view;
    private $template;
    private $data = [];

    public function __construct($view, $template = "front")
    {
        $this->setView($view);
        $this->setTemplate($template);
    }

    public function setView($view){
        $this->view = $view;
    }

    public function setTemplate($template){
        $this->template = $template;
    }

    public function assign($key, $value):void
    {
        $this->data[$key] = $value;
    }

    public function includePartial($name, $config)
    {
        if(!file_exists("View/Partial/".$name.".partial.php"))
        {
            die("Partial ".$name." 404");
        }
        include "View/Partial/".$name.".partial.php";
    }

    public function __toString():string
    {
        return "Ceci est la classe View";
    }


    public function __destruct()
    {
        //Array ( [firstname] => Yves )
        extract($this->data);
        include "View/".$this->template.".tpl.php";
    }

}
