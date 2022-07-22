<?php

namespace App\Model;

use App\Core\BaseSQL;
use App\Core\queryBuilder;

class WikiPageVersion extends BaseSQL
{
    protected $id = null;
    protected $versionNumber;
    protected $versionOf;
    protected $isCurrentVersion = false;
    protected $content;
    protected $author;
    protected $createdAt;
    protected $updatedAt;

    public function __construct()
    {
        parent::__construct();
    }

    public function getCurrentVersion(int $pageId): ?object
    {
        $pdo = parent::getPdoSession();
        $query = (new queryBuilder)->select("id", "versionNumber", "versionOf", "isCurrentVersion", "content", "author", "createdAt", "updatedAt")
            ->target("WikiPageVersion")
            ->where("isCurrentVersion = true")
            ->where("versionOf = :versionOf");

        $queryPrepared = $pdo->prepare($query);
        $queryPrepared->execute([":versionOf"=>$pageId]);

        return $queryPrepared->fetchObject(get_called_class());
    }

    public function getSpecificVersion(int $pageId, float $versionNumber): ?object
    {
        $pdo = parent::getPdoSession();
        $query = (new queryBuilder)->select("id", "versionNumber", "versionOf", "isCurrentVersion", "content", "author", "createdAt", "updatedAt")
            ->target("WikiPageVersion")
            ->where("versionNumber = :versionNumber")
            ->where("versionOf = :versionOf");

        $queryPrepared = $pdo->prepare($query);
        $queryPrepared->execute([":versionNumber"=>$pageId,":versionOf"=>$versionNumber]);

        return $queryPrepared->fetchObject(get_called_class());
    }

    /**
     * @return mixed
     */
    public function getId() :?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getVersionNumber(): ?float
    {
        return $this->versionNumber;
    }

    /**
     * @param mixed $versionNumber
     */
    public function setVersionNumber(float $versionNumber): void
    {
        $this->versionNumber = $versionNumber;
    }

    /**
     * @return mixed
     */
    public function getVersionOf(): int
    {
        return $this->versionOf;
    }

    /**
     * @param mixed $versionOf
     */
    public function setVersionOf(int $versionOf): void
    {
        $this->versionOf = $versionOf;
    }

    /**
     * @return mixed
     */
    public function getIsCurrentVersion(): bool
    {
        return $this->isCurrentVersion??false;
    }

    /**
     * @param mixed $isCurrentVersion
     */
    public function setIsCurrentVersion(bool $isCurrentVersion): void
    {
        $this->isCurrentVersion = $isCurrentVersion;
    }

    /**
     * @return mixed
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent(string $content): void
    {
        $this->content = strip_tags($content);
    }

    /**
     * @return mixed
     */
    public function getAuthor(): int
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor(int $author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function save()
    {
        parent::save();
    }
}