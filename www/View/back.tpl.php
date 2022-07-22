<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title><?=$pageTitle??"Administration"?></title>
        <meta name="description" content="ceci est la description de ma page">
        <link rel="stylesheet" href="../Assets/Lib/fontawesome/css/all.css">
        <link rel="stylesheet" href="../Assets/dist/main.css">
        <link rel="stylesheet" href="../Assets/themes/<?=$currentTheme?>.css">
        <script src="../Assets/js/jquery.js"></script>
        <script src="../Assets/js/color-picker.js"></script>
        <script src="../Assets/js/modal.js"></script>
        <script src="../Assets/js/tree.js"></script>
    </head>
    <body id="body-back">
        <header id="main-header">
            <h1>Wikicat</h1>
            <div class="user">
                <span class="user-notification"><i class="fas fa-bell"></i></span>
                <span class="user-name"><?=$_SESSION["connectedUser"]["login"]?></span>
                <img class="user-image" src="../Assets/images/user.jpg" alt="user profil image">
            </div>
        </header>
        <div class="row">
            <nav id="main-nav" class="col-2 p-0">
                <a href="/admin/dashboard" class="main-nav-choice <?= $activePage=="dashboard"?"active":""?>">
                    <span class="main-nav-icon"><i class="fas fa-chart-line"></i></span>
                    <span class="main-nav-title">Dashboard</span>
                </a>
                <a href="/admin/user" class="main-nav-choice <?= $activePage=="user"?"active":""?>">
                    <span class="main-nav-icon"><i class="fas fa-users"></i></span>
                    <span class="main-nav-title">Utilisateurs</span>
                </a>
                <a href="/admin/role" class="main-nav-choice <?= $activePage=="role"?"active":""?>">
                    <span class="main-nav-icon"><i class="fas fa-key"></i></span>
                    <span class="main-nav-title">Rôles</span>
                </a>
                <div class="main-nav-choice <?= $activePage=="page"?"active":""?>" data-wc-target="main-nav-subchoice-page">
                    <span class="main-nav-icon"><i class="fas fa-file"></i></span>
                    <span class="main-nav-title">Pages</span>
                    <i class="fas fa-chevron-down subchoice-indicator"></i>
                </div>
                <div class="main-nav-subchoices" id="main-nav-subchoice-page">
                    <a href="/admin/pageList" class="main-nav-subchoice">Liste pages</a>
                    <a href="/admin/pageTemplate" class="main-nav-subchoice">Templates</a>
                </div>
                <a href="/admin/comment" class="main-nav-choice <?= $activePage=="comment"?"active":""?>">
                    <span class="main-nav-icon"><i class="fas fa-comments"></i></span>
                    <span class="main-nav-title">Commentaires</span>
                </a>
                <a href="/admin/visualSetting" class="main-nav-choice <?= $activePage=="visualSetting"?"active":""?>">
                    <span class="main-nav-icon"><i class="fas fa-paint-roller"></i></span>
                    <span class="main-nav-title">Apparence</span>
                </a>
                <a href="/admin/plugin" class="main-nav-choice <?= $activePage=="plugin"?"active":""?>">
                    <span class="main-nav-icon"><i class="fas fa-puzzle-piece"></i></span>
                    <span class="main-nav-title">Plugins</span>
                </a>
                <a href="/admin/globalSetting" class="main-nav-choice <?= $activePage=="globalSetting"?"active":""?>">
                    <span class="main-nav-icon"><i class="fas fa-cogs"></i></span>
                    <span class="main-nav-title">Paramètres</span>
                </a>
                <a href="/" class="main-nav-choice">
                    <span class="main-nav-icon"><i class="fas fa-arrow-left"></i></i></span>
                    <span class="main-nav-title">Retour wiki</span>
                </a>
            </nav>
            <main class="col">
                <?php include $this->view.".view.php";?>
            </main>
        </div>

        <script src="../Assets/js/Back-tpl-script.js"></script>
        <script src="../Assets/webpack/node_modules/chart.js/dist/chart.js"></script>
        <script src="../Assets/js/chartCanvas.js"></script>
    </body>
</html>
