<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Template de back</title>
        <meta name="description" content="ceci est la description de ma page">
        <link rel="stylesheet" href="../Assets/Lib/fontawesome/css/all.css">
        <link rel="stylesheet" href="../Assets/dist/main.css">
    </head>
    <body id="body-back">
        <header id="main-header" class="bg-primary">
            <h1>Wikicat</h1>
            <div class="user">
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
                <a href="#" class="main-nav-choice">
                    <span class="main-nav-icon"><i class="fas fa-file"></i></span>
                    Pages
                </a>
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
</html>