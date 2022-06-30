<?php

namespace App\Model;

use App\Core\BaseSQL;

class WikiPageVersion extends BaseSQL
{
    protected $id;
    protected $versionNumber;
    protected $versionOf;
    protected $isCurrentVersion;
    protected $content;
    protected $author;
    protected $createdAt;
    protected $updateAt;

    public function __construct()
    {
        parent::__construct();
    }



    public function save()
    {
        parent::save();
    }
}