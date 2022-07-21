<?php

namespace App\Model;

use App\Core\BaseSQL;
use App\Core\queryBuilder;

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

    public function getAllPageAndVersion() {
        $pdo = parent::getPdoSession();
        $query = (new queryBuilder)->select("*")
            ->join("WikiPage", "WikiPageVersion")
            ->alias("page", "pageVersion")
            ->on("page.id = pageVersion.versionOf")
            ->where("pageVersion.isCurrentVersion = true");

        $queryPrepared = $pdo->prepare($query);
        $queryPrepared->execute();

        $result = $queryPrepared->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        return $result;
    }

    public function getAllPageAndVersionWithLike(string $search) {
        $pdo = parent::getPdoSession();
        $query = (new queryBuilder)->select("*")
            ->join("WikiPage", "WikiPageVersion")
            ->alias("page", "pageVersion")
            ->on("page.id = pageVersion.versionOf")
            ->where("pageVersion.isCurrentVersion = true")
            ->like("page.title", "search");

        $queryPrepared = $pdo->prepare($query);
        $queryPrepared->execute(["search" => "%$search%"]);

        $result = $queryPrepared->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        return $result;
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
        if($this->getId() != 1 && $this->getId() != $parentPageId){
            $this->parentPageId = $parentPageId;
        }else if ($this->getId() != 1){
            $this->parentPageId = 1;
        }
    }

    public function getAllChild(): ?array{
        return $this->getAllFromValue($this->getId(),"parentPageId");
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
        $parentPageList = [];

        foreach(WikiPage::getAll() as $pageInDb) {
            if ($pageInDb->getId() != $this->getId()) {
                $parentPageList[] = ["value" => $pageInDb->getId(),
                                    "text" => $pageInDb->getTitle(),
                                    "selected"=>($pageInDb->getId() == $this->getParentPageId() && $this->getParentPageId() != null)];
            }
        }

        $comp = function ($a, $b) {
            return strcmp($a["text"], $b["text"]);
        };

        usort($parentPageList, $comp);

        $config = [
            "config"=>[
                "form-id"=>"pageEditForm",
                "method"=>"POST",
                "action"=>"/w/update/{$this->getTitle()}",
                "submit"=>"Enregistrer",
                "submit-class"=>"btn btn--success"
            ],
            "inputs"=>[
                "pageId"=>[
                    "type"=>"hidden",
                    "id"=>"pageId",
                    "value"=>$this->getId()??""
                ],
                "parentPage"=>[
                    "type"=>"select",
                    "id"=>"parentPage",
                    "label"=>"Page parent",
                    "options"=>$parentPageList
                ],
                "newPageContent"=>[
                    "type"=>"quill",
                    "id"=>"newPageContent",
                    "default-value"=>$pageContent??""
                ]
            ]
        ];

        if ($this->getId() == 1){
            unset($config["inputs"]["parentPage"]);
        }

        return $config;
    }

    /**
     * undocumented function
     *
     * @return void
     */
    public function searchPageForm(): array {
        return [
            "config"=>[
                "form-id"=>"searchPageFrom",
                "method"=>"GET",
                "action"=>"/searchPage",
                "submit"=>"rechercher",
                "submit-class"=>"d-none"
                /* "submit-class"=>"btn btn--success" */
            ],
            "inputs"=>[
                "searchPage"=>[
                    "type"=>"text",
                    "id"=>"searchPage",
                    "class"=>"form-input",
                    "placeholder"=>"rechercher une page"
                ],
            ]
        ];
    }
}
