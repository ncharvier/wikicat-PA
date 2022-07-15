<?php if (!is_null($innerTree) && count($innerTree) > 1){
    $pagePath = "";

    foreach ($innerTree as $treeElement){
        $pagePath =  "<a href='/w/{$treeElement->getTitle()}'>{$treeElement->getTitle()}</a>" . ($pagePath == "" ? $pagePath : " / " . $pagePath);
    }

    echo $pagePath;
} ?>

<h1><?=Ucfirst($page->GetTitle())?></h1>

<?php
$this->includePartial("quillReader", $pageContent)
?>


<a class="btn btn--sm btn--primary" href="/w/edit/<?=$page->GetTitle()?>">Modifier</a>