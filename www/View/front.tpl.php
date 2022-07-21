<?php
use App\Core\AccessManager;
use App\Model\WikiPage;
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title><?= $titleSeo??"Wikicat" ?></title>
        <meta name="description" content="ceci est la description de ma page">

        <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
        <link rel="stylesheet" href="../../Assets/dist/main.css">

        <script src="../../Assets/js/jquery.js"></script>
        <script src="../../Assets/js/color-picker.js"></script>
        <script src="../../Assets/js/modal.js"></script>
        <script src="../../Assets/js/tree.js"></script>
        <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
    </head>
    <body>
        <nav class="main-front-nav bg-grey row">
            <div class="col-2">
                <h1 class="m-0">
                    <span class="text-weight-800">Wiki</span><span class="text-secondary text-weight-400">cat</span>
                </h1>
            </div>
            <div class="col">
                <?php $this->includePartial("form", (new WikiPage())->searchPageForm()) ?>
            </div>
            <?php if (AccessManager::isAdmin()):?>
                <div class="col-2">
                    <a class="btn btn--sm d-block btn--primary" href="/admin/dashboard">Administration</a>
                </div>
            <?php endif?>
            <?php if (AccessManager::isLogged()):?>
                <div class="col-2">
                    <a class="btn btn--sm d-block btn--danger" href="/logout">Déconnexion</a>
                </div>
            <?php else:?>
                <div class="col-2">
                    <a class="btn btn--sm d-block btn--success" href="/login">Connexion</a>
                </div>
                <div class="col-2">
                    <a class="btn btn--sm d-block btn--success" href="/register">Inscription</a>
                </div>
            <?php endif?>
        </nav>
        <div class="row">
            <div class="col-2 bg-grey">
                <div id="pageTree"><div class="spinner-primary"></div></div>
            </div>
            <main class="col py-2 px-5 overflow-auto" style="height: 100vh">
                <?php include $this->view.".view.php";?>
            </main>
        </div>
        <script>
            $( document ).ready(function (){
                $.ajax({
                    url: "/tree/getPageTree",
                    success: function (tree){
                        $("#pageTree").html(tree);
                    }
                });
            });
        </script>
    </body>
</html>
