<h1>Se connecter</h1>

<?= $loginError??"" ?>

<?php $this->includePartial("form", $user->getFormLogin()) ?>

<a class="btn btn--primary" href="/register">Je n'ai pas de compte</a>

<a class="btn btn--primary" href="/forgotPassword">J'ai oublié mon mot de passe</a>
