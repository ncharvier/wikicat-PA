<?php
namespace App\Model;

use App\Core\BaseSQL;

class Theme extends BaseSQL {
    protected $id = null;
    protected $userId = null;
    protected $name = "";
    protected $content = "";

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
     * return theme with user id
     *
     * @param int userid
     * @return ?object
     */
    public function getThemeByUserId(int $userId): ?object {
        return parent::getFromValue($userId, 'userId');
    }

    /**
     * return all the theme of user
     *
     * @param int userId
     * @return array
     */
    public function getThemeListByUserId(int $userId): array
    {
        return parent::getFromValue($userId, 'userId', true) ?? [];
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
     * set the content
     *
     * @param string cotent
     */
    public function setContent(string $content) {
        $this->content = $content;
    }

    /**
     * return the content
     *
     * @return string
     */
    public function getContent(): string {
        return $this->content;
    }

    public function save(): void {
        parent::save();
    }
}
