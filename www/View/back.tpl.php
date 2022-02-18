<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title><?=$pageTitle??"Administration"?></title>
        <meta name="description" content="ceci est la description de ma page">
        <link rel="stylesheet" href="../Assets/Lib/fontawesome/css/all.css">
        <link rel="stylesheet" href="../Assets/dist/main.css">
    </head>
    <body id="body-back">
        <header id="main-header" class="bg-primary">
            <h1>Wikicat</h1>
            <div class="user">
                <span class="user-notification"><i class="fas fa-bell"></i></span>
                <span class="user-name">Picon Daniel</span>
                <img class="user-image" src="../Assets/Images/user.jpg" alt="user profil image">
            </div>
        </header>
        <div class="row">
            <nav id="main-nav" class="col-2 p-0">
                <a href="#" class="main-nav-choice active">
                    <span class="main-nav-icon"><i class="fas fa-chart-line"></i></span>
                    Dashboard
                </a>
                <a href="#" class="main-nav-choice">
                    <span class="main-nav-icon"><i class="fas fa-users"></i></span>
                    Utilisateurs
                </a>
                <a href="#" class="main-nav-choice">
                    <span class="main-nav-icon"><i class="fas fa-key"></i></span>
                    Rôles
                </a>
                <div class="main-nav-choice" data-wc-target="main-nav-subchoice-page">
                    <span class="main-nav-icon"><i class="fas fa-file"></i></span>
                    Pages
                </div>
                <div class="main-nav-subchoices" id="main-nav-subchoice-page">
                    <a href="#" class="main-nav-subchoice">Liste pages</a>
                    <a href="#" class="main-nav-subchoice">Templates</a>
                </div>
                <a href="#" class="main-nav-choice">
                    <span class="main-nav-icon"><i class="fas fa-comments"></i></span>
                    Commentaires
                </a>
                <a href="#" class="main-nav-choice">
                    <span class="main-nav-icon"><i class="fas fa-paint-roller"></i></span>
                    Apparence
                </a>
                <a href="#" class="main-nav-choice">
                    <span class="main-nav-icon"><i class="fas fa-puzzle-piece"></i></span>
                    Plugins
                </a>
                <a href="#" class="main-nav-choice">
                    <span class="main-nav-icon"><i class="fas fa-cogs"></i></span>
                    Paramètres
                </a>
            </nav>
            <main class="col">
                <?php include $this->view.".view.php";?>
            </main>
        </div>
    </body>

    <script src="../Assets/Js/Jquery.js"></script>
    <script src="../Assets/Js/Back-tpl-script.js"></script>
</html>