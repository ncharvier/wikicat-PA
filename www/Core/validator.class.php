<?php
namespace App\Core;

class Validator
{

    public static function run($config, $data): array
    {
        $result = [];

        if( count($data) != count($config["inputs"]) ){
            $result[]="Formulaire modifié par user";
        }
        foreach ($config["inputs"] as $name=>$input){

            if(!isset($data[$name])){
                $result[]="Il manque des champs";
            }
            if(!empty($input["required"]) && empty($data[$name])){
                $result[]="Vous avez supprimé l'attribut required";
            }

            if($input["type"]=="password" && !self::checkPassword($data[$name])){
                $result[]="Password incorrect";
            }else if($input["type"]=="email"  && !self::checkEmail($data[$name])){
                $result[]="Email incorrect";
            }

        }
        return $result;
    }

    public static function checkPassword($pwd): bool
    {
        return strlen($pwd)>=8 && strlen($pwd)<=16
            && preg_match("/[a-z]/i", $pwd, $result)
            && preg_match("/[0-9]/", $pwd, $result);
    }

    public static function checkEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

}