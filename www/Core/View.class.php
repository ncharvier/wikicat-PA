<?php

namespace App\Core;

class View
{
    private $view;
    private $template;
    private $data;

    public function __construct(string $view, string $template = "front"){
        $this->setView($view);
        $this->setTemplate($template);
    }

    public function setView(string $view): void {
        $this->view = strtolower($view);
    }

    public function setTemplate(string $template): void {
        $this->template = strtolower($template);
    }

    public function assign($key, $value):void{
        $this->data[$key] = $value;
    }

    public function __destruct(){
        if (isset($data)){
            extract($this->data);
        }
        include "View/" .$this->template. ".tpl.php";
    }

    public function includePartial($name, $config){
        if(!file_exists("View/partial/".$name."/.partial.php")){
            die("vue partiel introuvable");
        }


    }
}