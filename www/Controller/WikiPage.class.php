<?php

namespace App\Controller;

use App\Core\queryBuilder;
use App\Core\View;
use App\Model\WikiPage as page;

class WikiPage
{
    public function show(string $pageTitle)
    {
        $page = new page();
        $page = $page->foundByTitle($pageTitle);

        if ($page == null){
            header('Location: /w/edit/'.$pageTitle);
        }

        echo $pageTitle;
    }

    public function edit(string $pageTitle)
    {
        $page = new page();
        $page = $page->foundByTitle($pageTitle);

        if ($page == null){
            $page = new page();
            $page->setTitle($pageTitle);
        }

        $view = new View("front/pageEdit", "front");

        if (isset($_POST["newPageContent"])){
            $view->assign("pageContent", $_POST["newPageContent"]);
        }

        $view->assign("title", $pageTitle);
        $view->assign("page", $page);
    }
}