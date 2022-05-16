<?php
namespace App\Core;

class LogManager {
    public static $instance = null;

    /**
     * constructor
     */
    private function __construct() {
        // TODO : faire connection avec la db
    }

    /**
     * get instance of MasterRing
     * @return LogManager
     */
    public static function getInstance(): LogManager {
        if (!self::$instance)
            self::$instance = new LogManager();

        return self::$instance;
    }

    /**
     * write log in database
     * @param string type
     * @param string msg
     * @return void
     */
    public function writeLog(string $type, string $msg) {
        // TODO : faire writeLog
        return;
    }

    /**
     * read log from database
     * @param int id
     * @return string
     */
    public function readLog(int $id): string {
        // TODO : faire readLog
        return "";
    }
}

?>
