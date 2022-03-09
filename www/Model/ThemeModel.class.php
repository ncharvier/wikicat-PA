<?php
namespace App\Model;

use App\Core\BaseSQL;

class ThemeModel extends BaseSQL
{
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
    public function getId(): int {
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
    public function getThemeName(): string {
        return $this->themeName;
    }
    
    /**
     * set the name of the theme
     * @param string name
     * @return void
     */
    public function setThemeName(string $name): void {
        $this->themeName = trim($name);
    }
    
    public function save(): void {
        parent::save();
    }
    
}
