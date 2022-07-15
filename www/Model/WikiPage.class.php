<?php

namespace App\Model;

use App\Core\BaseSQL;

class WikiPage extends BaseSQL
{
    protected $id = null;
    protected $title;
    protected $parentPageId;
    protected $createdAt;
    protected $updateAt;

    public function __construct()
    {
        parent::__construct();
    }

    public function foundByTitle($title): ?object
    {
        return parent::getFromValue(strtolower(trim($title)), "title");
    }

    public function getParentPage(): ?object
    {
        return $this->setId($this->parentPageId);
    }

    public function getInnerTree(): ?array
    {
        $tree[] = $this;
        $lastPage = $this;

        while ($lastPage->parentPageId != null){
            $lastPage = $lastPage->getParentPage();
            $tree[] = $lastPage;
        }

        return $tree;
    }

    /**
     * @return null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle(string $title): void
    {
        $this->title = trim(strtolower($title));
    }

    /**
     * @return mixed
     */
    public function getParentPageId(): ?int
    {
        return $this->parentPageId;
    }

    /**
     * @param mixed $parentPageId
     */
    public function setParentPageId(int $parentPageId): void
    {
        $this->parentPageId = $parentPageId;
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
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    public function save()
    {
        parent::save();
    }

    public function getPageEditForm(?string $pageContent): array
    {
        return [
            "config"=>[
                "form-id"=>"pageEditForm",
                "method"=>"POST",
                "action"=>"/w/edit/{$this->getTitle()}",
                "submit"=>"Enregistrer",
                "submit-class"=>"btn btn--success"
            ],
            "inputs"=>[
                "pageId"=>[
                    "type"=>"hidden",
                    "id"=>"pageId",
                    "value"=>$this->getId()??""
                ],
                "newPageContent"=>[
                    "type"=>"quill",
                    "id"=>"newPageContent",
                    "default-value"=>$pageContent??""
                ]
            ]
        ];
    }
}