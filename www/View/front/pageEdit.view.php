<?php if (!is_null($innerTree) && count($innerTree) > 1){
    $pagePath = "";

    foreach ($innerTree as $treeElement){
        $pagePath =  "<a href='/w/{$treeElement->getTitle()}'>{$treeElement->getTitle()}</a>" . ($pagePath == "" ? $pagePath : " / " . $pagePath);
    }

    echo $pagePath;
} ?>

<h1><?=Ucfirst($page->GetTitle())?></h1>

<?php if (!$exist):?>
    <div class="alert alert--danger mx-0">
        <h4>Cette page n'existe pas </h4>
        <hr>
        vous pouvez la créé :
    </div>
<?php endif;?>

<?php
    $this->includePartial("form", $page->getPageEditForm($pageContent??null))
?>

<?php if ($exist): ?>
    <a class="btn btn--danger" href="/w/<?=Ucfirst($page->GetTitle())?>">Annuler</a>
<?php endif;?>
