<?php
    use App\Core\AccessManager;
?>

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

<?php if(AccessManager::canModifyPage()): ?>
    <a class="btn btn--sm btn--primary" href="/w/edit/<?=$page->GetTitle()?>">Modifier</a>
<?php endif;?>

<?php if(AccessManager::canDeletePage() && $page->getId() != 1): ?>
    <a class="btn btn--sm btn--primary" href="/w/delete/<?=$page->GetTitle()?>">Suppression</a>
<?php endif;?>