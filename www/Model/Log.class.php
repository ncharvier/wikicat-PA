<?php
namespace App\Model;

use App\Core\BaseSQL;

class Log extends BaseSQL {
    protected $id = null;
    protected $message;
    protected $type;
    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getId(): ?int {
        return $this->id;
    }
}
?>
