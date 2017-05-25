<?php

class TextLog{


    public static function info($message){
        file_put_contents(TextLog::getLogger(), "[". date("Y-m-d H:i:s") . "] [INFO]  JSON Data: " . $message."\n", FILE_APPEND);

    }

    public static function error($message){
        file_put_contents(TextLog::getLogger(), "[". date("Y-m-d H:i:s") . "] [ERROR]  JSON Data: " . $message."\n", FILE_APPEND);

    }

    public static function  getLogger(){

        return storage_path()."/logs/TextLog.log";
    }

}