<?php
namespace App\Model;

use App\Core\BaseSQL;

class Log extends BaseSQL {
    protected $id = null;
    protected $type = "";
    protected $message = "";
    /**
     *
     * constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /* public function setId($id): object { */
    /*     return parent::setId($id); */
    /* } */
    /**
     * @return mixed
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * get the type
     * @return string
     */
    public function getType(): string {
        return $this->type;
    }

    /**
     * set a type
     * @param string $type
     * @return void
     */
    public function setType(string $type): void {
        $this->type = $type;
    }

    /**
     * get a message
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }

    /**
     * set a message
     * @param string $message
     * @return void
     */
    public function setMessage(string $message): void {
        $this->message = $message;
    }

    public function save() {
        parent::save();
    }
}
?>
