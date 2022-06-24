<?php

namespace App\Model;

use App\Core\BaseSQL;

class WikiPage extends BaseSQL
{
    protected $id;
    protected $title;
    protected $parentPageId;
    protected $createdAt;
    protected $updatedAt;

    public function __construct()
    {
        parent::__construct();
    }
}