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

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getParentPageId()
    {
        return $this->parentPageId;
    }

    /**
     * @param mixed $parentPageId
     */
    public function setParentPageId($parentPageId): void
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
                "pageEditor"=>[
                    "type"=>"quill",
                    "id"=>"newPageContent",
                    "default-value"=>$pageContent??""
                ]
            ]
        ];
    }
}