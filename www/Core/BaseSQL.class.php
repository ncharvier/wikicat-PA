<?php

namespace App\Core;

abstract class BaseSQL
{
    private $pdo;
    private $table;

    public function __construct(){
        //INTEGRER LE SINGLETON

        try{
            $this->pdo = new \PDO(DBDRIVER.":host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME, DBUSER, DBPWD);
        }catch (\Exception $e){
            die("erreur SQL" .$e->getMessage());
        }

        $classname = explode("\\",get_called_class());
        $classname = strtolower(end($classname));

        $this->table = DBPREFIXE.$classname;

    }

    protected function save(){
        $columns  = get_object_vars($this);
        $varsToExclude = get_class_vars(get_class());
        $columns = array_diff_key($columns, $varsToExclude);
        $columns = array_filter($columns);


        if( !is_null($this->getId()) ){
            foreach ($columns as $key => $column) {
                $setUpdate[] = $key . "=:" . $key;
            }

            $sql = "UPDATE ".$this->table." SET ". implode(", ", $setUpdate) ." WHERE id=" . $this->getId();
        }else{
            $sql = "INSERT INTO ".$this->table." (".implode(", ", array_keys($columns)).") VALUES (:".implode(",:", array_keys($columns)).")";
        }

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute( $columns );
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
}