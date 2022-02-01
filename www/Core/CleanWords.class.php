<?php

namespace App\Core;

class CleanWords
{


    public static function lastname($word):string
    {
        $word = strtoupper(trim($word));
        return $word;
    }


}