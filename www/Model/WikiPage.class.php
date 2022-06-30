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

    public function save()
    {
        parent::save();
    }
}