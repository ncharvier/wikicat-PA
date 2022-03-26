<?php
//singleton class is a class which is instance once time
class Logger{
    private static $instance= [];
    
    
    protected function __construct() { } 

     // Singletons should not be cloneable.
    
    protected function __clone() { }

    
     // Singletons should not be restorable from strings.
    
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    
    public static function getInstance(){
        if (is_null(self::$instance)){
            self::$instance = new Logger();
        }
        return self::$instance;
    }

    // method which write message in log
    public function write_log($fileLog, $message){

        if(!is_writable($fileLog))
        die('change your permissions'. $fileLog);
        $recup = fopen($fileLog,'a+');

        fwrite($recup, "\r" . $message );
        fclose($recup);
       
    }

    // method which read message in log
    public function read_log($fileLog){
        $recup = fopen($fileLog, 'r');
        return file_get_contents($fileLog);

    }

}
?>