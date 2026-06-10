<?php

namespace App\helpers;
class Helpers {
    public static function isBlank (mixed $value): bool
    {
        if (empty($value))  {
            return true;
        }

        //todo: not important
//        if (is_string($value)) {
//            $value  = trim($value);
//            return !empty($value) && strlen($value) !== 0 ;
//        }
//
//        if(is_array($value)) {
//            return !empty($value) && count($value) !== 0;
//        }

        return false;

    }
}



