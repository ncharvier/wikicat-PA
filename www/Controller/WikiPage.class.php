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

    public function searchPage() {
        $page = new Page();
        $pageName = "accueil";
        $resultPage = null;

        if (!empty($_GET['searchPage'])) {
            $pageName = htmlspecialchars($_GET['searchPage']);
            $resultPage = $page->getAllPageAndVersionWithLike($pageName);
            if (!empty($resultPage))
                $pageName = $resultPage[0]->getTitle();
        }

        header("Location: /w/".$pageName);
    }

    public function edit(string $pageTitle)
    {
        $page = new Page();
        $pageVersion = new PageVersion();

        $view = new View("front/pageEdit", "front");
        $view->assign("exist", true);
        $view->assign("innerTree", null);

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

            $view->assign("innerTree", $page->getInnerTree());
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

            $view->assign("innerTree", $page->getInnerTree());
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

                $view->assign("innerTree", $page->getInnerTree());
                $view->assign("titleSeo", "Modifier {$pageTitle}");
                $view->assign("pageContent", $pageVersion->getContent());
            }
        }

        $view->assign("page", $page);
    }
}
