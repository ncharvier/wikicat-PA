<h1>Se connecter</h1>

<?= $loginError??"" ?>

<?php $this->includePartial("form", $user->getFormLogin()) ?>