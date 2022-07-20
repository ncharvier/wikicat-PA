<?php

namespace App\Controller;

use App\Core\AccessManager;
use App\Core\baseController;
use App\Core\View;
use App\Model\WikiPage as Page;
use App\Model\WikiPageVersion as PageVersion;

class WikiPage extends baseController
{
    public function show(string $pageTitle)
    {
        $page = new Page();
        $pageVersion = new PageVersion();
        $page = $page->foundByTitle($pageTitle);

        if ($page == null){
            header('Location: /w/edit/'.$pageTitle);
        }

        $pageVersion = $pageVersion->getCurrentVersion($page->getId());

        $view = new View("front/pageShow", "front");

        $view->assign("innerTree", $page->getInnerTree());
        $view->assign("titleSeo", $page->getTitle());
        $view->assign("pageContent", $pageVersion->getContent());
        $view->assign("page", $page);
    }

    public function edit(string $pageTitle)
    {
        if(!AccessManager::isLogged()){
            header('Location: /w/'.$pageTitle);
        }

        $page = new Page();
        $pageVersion = new PageVersion();

        $view = new View("front/pageEdit", "front");
        $view->assign("exist", true);
        $view->assign("innerTree", null);

        $page = $page->foundByTitle($pageTitle);

        if ($page == null){
            $view->assign("exist", false);

            $page = new Page();
            $page->setTitle($pageTitle);
            $view->assign("titleSeo", "Créé {$pageTitle}");
        } else {
            $pageVersion = $pageVersion->getCurrentVersion($page->getId());

            $view->assign("innerTree", $page->getInnerTree());
            $view->assign("titleSeo", "Modifier {$pageTitle}");
            $view->assign("pageContent", $pageVersion->getContent());
        }

        $view->assign("page", $page);
        unset($_POST);
    }

    public function updatePage($pageTitle){
        $page = new Page();
        $pageVersion = new PageVersion();

        if (isset($_POST["newPageContent"]) && !empty($_POST["pageId"])){
            $page = $page->setId($_POST["pageId"]);
            $oldVersion = $pageVersion->getCurrentVersion($page->getId());

            if ($page->getId() != 1) {
                $page->setParentPageId($_POST["parentPage"]);
            }
            $pageVersion->setContent($_POST["newPageContent"]);
            $pageVersion->setIsCurrentVersion(true);
            $pageVersion->setVersionNumber($oldVersion->getVersionNumber() + 1.0);
            $pageVersion->setVersionOf($page->getId());
            $pageVersion->setAuthor($_SESSION["connectedUser"]["id"]);
            $pageVersion->save();

            $oldVersion->setIsCurrentVersion(false);

            $oldVersion->save();

        } else if (isset($_POST["newPageContent"])){
            $page->setTitle($pageTitle);
            $page->setParentPageId($_POST["parentPage"]);

            $page->save();
            $page = $page->foundByTitle($pageTitle);

            $pageVersion->setContent($_POST["newPageContent"]);
            $pageVersion->setIsCurrentVersion(true);
            $pageVersion->setVersionNumber(1.0);
            $pageVersion->setVersionOf($page->getId());
            $pageVersion->setAuthor($_SESSION["connectedUser"]["id"]);

            $pageVersion->save();
        }

        header('Location: /w/edit/'.$pageTitle);
    }
}