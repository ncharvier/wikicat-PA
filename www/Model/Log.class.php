<?php
namespace App\Model;
use App\Core\BaseSQL;

class Logger extends BaseSQL
{
    protected $id = null;
    protected $message;
    protected $date;

    public function __construct()
    {
        parent::__construct();
    }
    public function getLogger()
    {
        $recup = "SELECT id, message, date FROM logger";
        $result = $this->pdo->query($recup);
        $result->setFetchMode(\PDO::FETCH_CLASS, 'App\Model\Logger');
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $result = $result->fetchAll();
        return $result;
    }
    public function setLogger($message)
    {
        if (empty($logger)) {// you can do this condition to check if is empty
            $logger= new Logger;//then create new object
        }
        $this->message = $message;
        $this->date = date("Y-m-d H:i:s");
        $this->save();
        
    }
}