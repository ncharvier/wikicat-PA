<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title><?=$pageTitle??"Auth"?></title>
        <meta name="description" content="ceci est la description de ma page">
        <link rel="stylesheet" href="../Assets/Lib/fontawesome/css/all.css">
        <link rel="stylesheet" href="../Assets/dist/main.css">
    </head>
    <body id="body-auth">
        <main class="d-flex justify-content-center align-items-center">
            <div class="col-5 auth-card">
                <div class="row">
                    <div class="col"></div>
                    <div class="col-5">
                        <h1 class="text-center m-0">
                            <span class="text-weight-800">Wiki</span>
                            <span class="text-secondary text-weight-400">cat</span>
                        </h1>
                        <?php include $this->view.".view.php";?>
                    </div>
                    <div class="col"></div>
                </div>
            </div>
        </main>
    </body>

    <script src="../Assets/js/jquery.js"></script>
</html>
