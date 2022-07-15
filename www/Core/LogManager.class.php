<?php
namespace App\Core;

use App\Model\Log;

/*

Usage example :
use App\Core\LogManager as Log;

$log = Log::getInstance();
$log->writeLog('type', 'salut tout le monde');
$log->readLog(1);

*/

class LogManager {
    public static $instance = null;
    public $log;

    /**
     * constructor
     */
    private function __construct() {
        $this->log = new Log;
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
        $this->log->setType($type);
        $this->log->setMessage($msg);
        $this->log->save();
    }

    /**
     * read log from database
     * @param int id
     * @return string
     */
    public function readLog(int $id): string {
        $this->log = $this->log->setId($id);
        return $this->log->getMessage();
    }
}
?>
