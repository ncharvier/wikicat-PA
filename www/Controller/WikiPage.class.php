<?php

namespace App\Controller;

use App\Core\queryBuilder;
use App\Core\View;
use App\Model\WikiPage as Page;
use App\Model\WikiPageVersion as PageVersion;

class WikiPage
{
    public function show(string $pageTitle)
    {
        $page = new Page();
        $page = $page->foundByTitle($pageTitle);

        if ($page == null){
            header('Location: /w/edit/'.$pageTitle);
        }

        echo $pageTitle;
    }

    public function edit(string $pageTitle)
    {
        $page = new Page();
        $pageVersion = new PageVersion();

        $view = new View("front/pageEdit", "front");
        $view->assign("exist", true);

        if (isset($_POST["newPageContent"]) && !empty($_POST["pageId"])){
            $page = $page->setId($_POST["pageId"]);
            $oldVersion = $pageVersion->getCurrentVersion($page->getId());

            $pageVersion->setContent($_POST["newPageContent"]);
            $pageVersion->setIsCurrentVersion(true);
            $pageVersion->setVersionNumber($oldVersion->getVersionNumber() + 1.0);
            $pageVersion->setVersionOf($page->getId());
            $pageVersion->setAuthor(10);
            $pageVersion->save();

            $oldVersion->setIsCurrentVersion(false);

            $oldVersion->save();

            $view->assign("titleSeo", "Modifier {$pageTitle}");
            $view->assign("pageContent", $_POST["newPageContent"]);

        } else if (isset($_POST["newPageContent"])){
            $page->setTitle($pageTitle);
            $page->setParentPageId(0);
            $page->save();
            $page = $page->foundByTitle($pageTitle);

            $pageVersion->setContent($_POST["newPageContent"]);
            $pageVersion->setIsCurrentVersion(true);
            $pageVersion->setVersionNumber(1.0);
            $pageVersion->setVersionOf($page->getId());
            $pageVersion->setAuthor(10);

            $pageVersion->save();

            $view->assign("titleSeo", "Modifier {$pageTitle}");
            $view->assign("pageContent", $_POST["newPageContent"]);
        } else {
            $page = $page->foundByTitle($pageTitle);

            if ($page == null){
                $view->assign("exist", false);

                $page = new Page();
                $page->setTitle($pageTitle);
                $view->assign("titleSeo", "Créé {$pageTitle}");
            } else {
                $pageVersion = $pageVersion->getCurrentVersion($page->getId());

                $view->assign("titleSeo", "Modifier {$pageTitle}");
                $view->assign("pageContent", $pageVersion->getContent());
            }
        }

        $view->assign("page", $page);
    }
}