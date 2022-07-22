<?php
namespace App;
session_start();
require "conf.inc.php";

use App\Core\ErrorManager;
use App\Controller\WikiPage;
use App\Core\View;

function myAutoloader($class){
    $class = str_ireplace("App\\", "", $class);
    $class = str_ireplace("\\", "/", $class);
    if(file_exists($class.".class.php")){
        include $class.".class.php";
    }
}

spl_autoload_register("App\myAutoloader");

$uri = substr($_SERVER["REQUEST_URI"], 0, strpos($_SERVER["REQUEST_URI"], "?"));

if(empty($uri)){
    $uri = $_SERVER["REQUEST_URI"];
}

if (preg_match("#^\/w\/((?!\/).)*$#", $uri)){
    $wikiPage = new WikiPage();

    $uri = trim(str_replace('/w/','',$uri));

    $wikiPage->show(strtolower($uri));

} else if (preg_match("#^\/w\/edit\/((?!\/).)*$#", $uri)){
    $wikiPage = new WikiPage();

    $uri = trim(str_replace('/w/edit/','',$uri));

    $wikiPage->edit(strtolower($uri));

} else if (preg_match("#^\/w\/update\/((?!\/).)*$#", $uri)){
    $wikiPage = new WikiPage();

    $uri = trim(str_replace('/w/update/','',$uri));

    $wikiPage->updatePage(strtolower($uri));

} else {
    $routeFile = "routes.yml";
    if(!file_exists($routeFile)){

        http_response_code(500);
        $view = new View("500", "front");
        $view->assign("titleSeo", "Problème interne");
        die();
    }

    $routes = yaml_parse_file($routeFile);

    if( empty($routes[$uri]) || empty($routes[$uri]["controller"])  || empty($routes[$uri]["action"]) ){
        http_response_code(404);
        $view = new View("404", "front");
        $view->assign("titleSeo", "La page n\'existe pas");
        die();
    }

    /* $controller = ucfirst(strtolower($routes[$uri]["controller"])); */
    $controller = $routes[$uri]["controller"];
    $action = strtolower($routes[$uri]["action"]);

    $controllerFile = "Controller/".$controller.".class.php";
    if(!file_exists($controllerFile)){
        http_response_code(500);
        $view = new View("500", "front");
        $view->assign("titleSeo", "Problème interne");
        die();
    }
    include $controllerFile;

    $controller = "App\\Controller\\".$controller;

    if( !class_exists($controller) ){
        http_response_code(500);
        $view = new View("500", "front");
        $view->assign("titleSeo", "Problème interne");
        die();
    }

    $objectController = new $controller();

    if( !method_exists($objectController, $action) ){
        http_response_code(500);
        $view = new View("500", "front");
        $view->assign("titleSeo", "Problème interne");
    }

    $objectController->$action();
}
