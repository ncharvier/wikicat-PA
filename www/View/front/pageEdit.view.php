<h1><?=Ucfirst($page->GetTitle())?></h1>

<?php if (!$exist):?>
    <div class="alert alert--danger mx-0">
        <h4>Cette page n'existe pas </h4>
        <hr>
        vous pouvez la créé :
    </div>
<?php endif;?>

<?php

$this->includePartial("form", $page->getPageEditForm($pageContent??null)) ?>