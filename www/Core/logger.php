<?php
//singleton class is a class which is instance once time
class Logger{
    private static $instance= null;
    
    
    private function __construct() { 

    } 

    
    public static function getInstance(){
        if (is_null(self::$instance)){
            self::$instance = new Logger();
        }
        return self::$instance;
    }


    // method which write message in log
    public static function write_log($fileLog, $message){

        if(!is_writable($fileLog))
        die('change your permissions'. $fileLog);
        $recup = fopen($fileLog,'a+');

        fwrite($recup, "\r" . $message );
        fclose($recup);
       
    }

    // method which read message in log
    public static function read_log($fileLog){
        $recup = "SELECT id  FROM loggerLogin";
        fopen($fileLog, 'r');
        return file_get_contents($fileLog);

    }

}
?>




