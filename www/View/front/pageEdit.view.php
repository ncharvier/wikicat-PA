<h1><?=Ucfirst($title)?></h1>

<?php

print_r($_POST);

$this->includePartial("form", $page->getPageEditForm($pageContent??null)) ?>