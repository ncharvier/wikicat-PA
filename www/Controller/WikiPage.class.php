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
            AccessManager::accessIfCanModifyPage();
            $page = $page->setId($_POST["pageId"]);
            $oldVersion = $pageVersion->getCurrentVersion($page->getId());

            if ($page->getId() != 1) {
                $page->setParentPageId($_POST["parentPage"]);
                $page->save();
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
            AccessManager::accessIfCanModifyPage();
            $page->setTitle($pageTitle);

            if ($page->getId() != 1) {
                $page->setParentPageId($_POST["parentPage"]);
            }

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

    public function getPageTree(){
        $page = new Page();
        echo "<ul class=\"tree\">" . $this->treeFiller($page->setId(1)) . "</ul>";
    }


    private function treeFiller($parent) {
        $childs = $parent->getAllChild();
        $comp = function ($a, $b) {
            return strcmp($a->getTitle(), $b->getTitle());
        };
        usort($childs, $comp);

        if ($childs == null){
            return "<li><a href='/w/{$parent->getTitle()}'>{$parent->getTitle()}</a></li>";
        }else{
            $html = "<li>
                        <span class=\"tree-title\"><span class=\"tree-arrow\"></span><a href='/w/{$parent->getTitle()}'>{$parent->getTitle()}</a></span>
                        <ul class=\"tree-nested\">";
            foreach ($childs as $child){
                $html .= $this->treeFiller($child);
            }
            return $html."</ul></li>";
        }
    }
}
