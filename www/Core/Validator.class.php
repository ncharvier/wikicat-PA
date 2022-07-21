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
                $result[] = $input["error"];
            }else if($input["type"]=="email"  && !self::checkEmail($data[$name])){
                $result[] = $input["error"];
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

    /**
     * Checks if color is a 6 lenght with hexadecimal value
     */
    public static function checkColor($color): bool
    {
        $color = htmlspecialchars($color);
        return (ctype_xdigit($color) && strlen($color) == 6);
    }

    public static function checkRoleName($name): bool
    {
        return strlen(htmlspecialchars($name)) <= 30;
    }

}