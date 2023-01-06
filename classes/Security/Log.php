<?php

namespace Security;

class Log 
{
    
    protected static function getPath()
    {
        return __DIR__ . "/../../storage/logs/";
    }

    public static function write($msg, $file = "general")
    {
        $file = self::getPath() . $file . ".log";
        file_put_contents($file, $msg . PHP_EOL, FILE_APPEND);
    }

}