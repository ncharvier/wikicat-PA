<?php

namespace App\Core;

use PHPMailer\PHPMailer\Exception;

class queryBuilder
{
    private $columns = [];
    private $conditions = [];
    private $target = [];
    private $mode = null;

    public function __toString(): string
    {
        $where = $this->conditions === [] ? '' : ' WHERE ' . implode(' AND ', $this->conditions);

        if (!empty($this->target)){
            switch ($this->mode){
                case 1:
                    $query = 'SELECT ' . implode(', ', $this->columns)
                                    . ' FROM ' . implode(', ', $this->target)
                                    . $where . ";";
                    return $query;
                case 2:
                    $query = 'DELETE FROM ' . implode(', ', $this->target)
                                    . $where . ";";
                    return $query;
                case 3:
                    $query = 'INSERT INTO ' . implode(', ', $this->target)
                                    . ' ('.implode(', ', $this->columns).') '
                                    . ' VALUES ('.implode(', :', $this->columns).');';
                    return $query;
                case 4:
                    $query = 'UPDATE ' . implode(', ', $this->target) ." SET ";

                    foreach ($this->columns as $key => $column){
                        $query .= ($key == 0 ? " " : ", ") . $column . " = :" . $this->columns[$key];
                    }

                    $query .= $where.";";

                    return $query;
                default:
                    break;
            }
        }

        return "";
    }

    public function select(string ...$column): self
    {
        if ($this->mode == null){
            $this->mode = 1;
        }

        $this->columns = $column;

        return $this;
    }

    public function delete(): self
    {
        if ($this->mode == null){
            $this->mode = 2;
        }

        return $this;
    }

    public function insert(array $column): self
    {
        if ($this->mode == null){
            $this->mode = 3;
        }

        $this->columns = $column;

        return $this;
    }

    public function update(array $column): self
    {
        if ($this->mode == null){
            $this->mode = 4;
        }

        $this->columns = $column;

        return $this;
    }

    public function target(string $table): self
    {
        $this->target[] = DBPREFIXE.$table;
        return $this;
    }

    public function where(string ...$where): self
    {
        foreach ($where as $arg) {
            $this->conditions[] = $arg;
        }

        return $this;
    }

}