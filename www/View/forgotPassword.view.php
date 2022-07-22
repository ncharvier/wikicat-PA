<?= $loginError??"" ?>

<?php $this->includePartial("form", $user->getForgotPassword()) ?>

<?php if(isset($emailSent) == 1) { echo "Un mail de récupération à été envoyé à l'adresse email en question";}
