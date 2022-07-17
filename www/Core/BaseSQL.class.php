<?php

namespace App\Core;

abstract class BaseSQL
{
    private $pdo;
    private $table;

    public function __construct()
    {
        //Faudra intégrer le singleton
        try{
            //Connexion à la base de données
            $this->pdo = new \PDO( DBDRIVER.":host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME ,DBUSER , DBPWD );
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch(\Exception $e){
            die("Erreur SQL".$e->getMessage());
        }
        //Récupérer le nom de la table :
        // -> prefixe + nom de la classe enfant
        $classExploded = explode("\\",get_called_class());
        $this->table = DBPREFIXE.strtolower(end($classExploded));

    }

    protected function getPdoSession(){
        return $this->pdo;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): object
    {
        $sql = "SELECT * FROM ".$this->table. " WHERE id=:id ";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute( ["id"=>$id] );
        return $queryPrepared->fetchObject(get_called_class());
    }

    protected function getFromValue($value, string $valueName): ?object
    {
        $sql = "SELECT * FROM ".$this->table. " WHERE " . $valueName . "=:value ";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute( ["value"=>$value] );

        $result = $queryPrepared->fetchObject(get_called_class());
        return $result!=false?$result:null;
    }

    /**
     * get list
     * @return array
     */
    public function getAll()
    {
        $sql = "SELECT * FROM ".$this->table;

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();

        $result = $queryPrepared->fetchAll(\PDO::FETCH_OBJ);
        return $result ?? null;
    }

    /**
     * get list
     * @param mixed value
     * @param string valueName
     * @return array
     */
    public function getAllFromValue($value, string $valueName)
    {
        $sql = "SELECT * FROM ".$this->table." WHERE ".$valueName."=:value ";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute( ["value"=>$value] );

        $result = $queryPrepared->fetchAll(\PDO::FETCH_OBJ);
        return $result ?? null;
    }

    /**
     * count number of element in database
     * @param int $numberOfDay - count since number of day
     * @return int
     */
    public function count(int $numberOfDay = 0): int {
        $exec = [];

        if ($numberOfDay > 0) {
            $timeDay = $numberOfDay * 24 * 3600;
            $timeLimit = time() - $timeDay;
            $datetime = date('Y-m-d H:i', $timeLimit);

            $sql = "SELECT COUNT(*) as count FROM ".$this->table." WHERE createdAt >= :date";
            /* $exec = ["date" => $datetime]; */
            $exec["date"] = $datetime;
        }
        else
            $sql = "SELECT COUNT(*) as count FROM ".$this->table;

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($exec);
        $result = $queryPrepared->fetch(\PDO::FETCH_OBJ);

        return $result->count;
    }

    /**
     * count number of element in database
     * @param mixed $value - attribute value
     * @param string $valueName - attribute name
     * @param int $numberOfDay (optional) - count since number of day
     * @return int
     */
    public function countFromValue($value, string $valueName, int $numberOfDay = 0): int {
        $exec = ["value" => $value];

        if ($numberOfDay > 0) {
            $timeDay = $numberOfDay * 24 * 3600;
            $timeLimit = time() - $timeDay;
            $datetime = date('Y-m-d H:i', $timeLimit);

            $sql = "SELECT COUNT(*) as count FROM ".$this->table." WHERE  ".$valueName."=:value createdAt >= :date";
            $exec["date"] = $datetime;
        }
        else
            $sql = "SELECT COUNT(*) as count FROM ".$this->table." WHERE  ".$valueName;

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($exec);
        $result = $queryPrepared->fetch(\PDO::FETCH_OBJ);

        return $result->count;
    }

    protected function save()
    {
        $columns  = get_object_vars($this);
        $varsToExclude = get_class_vars(get_class());
        $columns = array_diff_key($columns, $varsToExclude);
        //$columns = array_filter($columns);

        unset($columns["updatedAt"]);
        unset($columns["createdAt"]);
        unset($columns["id"]);

        if( !is_null($this->getId()) ){
            foreach ($columns as $key=>$value){
                if (is_bool($value)){
                    $columns[$key] = intval($value);
                }
                $setUpdate[]=$key."=:".$key;
            }
            $sql = "UPDATE ".$this->table." SET ".implode(",",$setUpdate)." WHERE id=".$this->getId();
        }else{
            $sql = "INSERT INTO ".$this->table." (".implode(",", array_keys($columns)).")
            VALUES (:".implode(",:", array_keys($columns)).")";
        }

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute( $columns );
    }
}
