<?php
namespace App\Helpers;

final class MyHelper
{
    public static function replaceBrackets($str, $with = '')
    {
        return rtrim(str_replace("[", ".", str_replace("][", ".", $str)), "]");
    }
}
