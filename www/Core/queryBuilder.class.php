<?php

namespace App\Core;

use PHPMailer\PHPMailer\Exception;

class queryBuilder
{
    private $columns = [];
    private $conditions = [];
    private $target = [];
    private $join = [];
    private $like = "";
    private $mode = null;

    public function __toString(): string
    {
        $where = $this->conditions === [] ? '' : ' WHERE ' . implode(' AND ', $this->conditions);
        $on = !empty($this->join["condition"]) ? ' ON ' . $this->join['condition'] : '';
        $alias1 = !empty($this->join["aliasTable1"]) ? " as " . $this->join["aliasTable1"] : " as t1";
        $alias2 = !empty($this->join["aliasTable2"]) ? " as " . $this->join["aliasTable2"] : " as t2";
        $like = $this->like === '' ? '' : " LIKE :" . $this->like ;

        if (!empty($this->target) || !empty($this->join)){
            switch ($this->mode){
                case 1:
                    if (empty($this->join)) {
                        $query = 'SELECT ' . implode(', ', $this->columns)
                            . ' FROM ' . implode(', ', $this->target)
                            . $where . $like . ";";
                    }
                    else {
                        $query = 'SELECT ' . implode(', ', $this->columns)
                            . ' FROM ' . $this->join['table1'] . $alias1
                            . ' ' . $this->join['type'] . ' JOIN  ' . $this->join['table2'] . $alias2
                            . $on . $where . $like . ";";

                    }
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
        $this->target[] = DBPREFIXE.strtolower($table);
        return $this;
    }

    public function where(string ...$where): self
    {
        foreach ($where as $arg) {
            $this->conditions[] = $arg;
        }

        return $this;
    }

    /**
     * join 2 table
     * @param string $table1 - table1 as t1
     * @param string $table2 - table2 as t2
     * @param string $type (optional) - type of join (INNER, LEFT, RIGHT, FULL)
     * @return self
     */
    public function join(string $table1, string $table2, string $type = ""): self {
        $this->join["table1"] = DBPREFIXE.strtolower($table1); 
        $this->join["table2"] = DBPREFIXE.strtolower($table2);
        $this->join["type"] = $type;
        return $this;
    }

    /**
     * add alias to table after join
     * @param string $aliasTable1
     * @param string $aliasTable2
     * @return self
     */
    public function alias(string $aliasTable1, string $aliasTable2): self {
        $this->join["aliasTable1"] = $aliasTable1;
        $this->join["aliasTable2"] = $aliasTable2;
        return $this;
    }

    /**
     * join on statement
     * @param string $condition - condition of join
     * @return self
     */
    public function on(string $condition): self {
        $this->join["condition"] = $condition;
        return $this;
    }

    /**
     * like statement
     * @param string $attribute
     * @param string $pattern
     * @return self
     */
    public function like(string $attribute, string $pattern): self {
        $this->conditions[] = $attribute;
        $this->like = $pattern;
        return $this;
    }
}
