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
    public function getAll(): ?array
    {
        $sql = "SELECT * FROM ".$this->table;

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();

        $result = $queryPrepared->fetchAll(\PDO::FETCH_CLASS, get_called_class());
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

        $result = $queryPrepared->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        return $result ?? null;
    }

    protected function save()
    {
        $columns  = get_object_vars($this);
        $varsToExclude = get_class_vars(get_class());
        $columns = array_diff_key($columns, $varsToExclude);

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

    protected function delete()
    {
        if(!is_null($this->getId())){
            $sql = "DELETE FROM " . $this->table . " WHERE id=" . $this->getId();
        }

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
    }
}
