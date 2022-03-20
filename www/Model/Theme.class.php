<?php
namespace App\Model;

use App\Core\BaseSQL;

class Theme extends BaseSQL {
    protected $id = null;
    protected $userId = null;
    protected $themeName = "";

    public function __construct() {
        parent::__construct();
    }

    /**
     * get theme id
     * @return int
     */
    public function getId(): ?int {
        return $this->id;
    }
    
    /**
     * get id of user who create the theme
     * @return int
     */
    public function getUserId(): int {
        return $this->userId;
    }

    /**
     * set id of user who create the theme
     * @param int id
     * @return void
     */
    public function setUserId(int $id): void {
        $this->userId = $id;
    }
    
    /**
     * get the name of the theme
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }
    
    /**
     * set the name of the theme
     * @param string name
     * @return void
     */
    public function setName(string $name): void {
        $this->name = trim($name);
    }

    /**
     * get path of theme
     * @return string
     */
    public function getPath(): string {
        return $this->path;
    }
    
    /**
     * get path of theme
     * @return void
     */
    public function setPath(string $path): void {
        $this->path = $path;
    }
    
    
    public function save(): void {
        parent::save();
    }
}
