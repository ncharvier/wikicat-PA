<?php
if (file_exists("conf.inc.php")){
    header("location: /");
} else if (isset($_POST)
    && isset($_POST["domaineName"])
    && isset($_POST["dbHost"])
    && isset($_POST["dbPort"])
    && isset($_POST["dbUser"])
    && isset($_POST["dbPassword"])
    && isset($_POST["dbName"])
    && isset($_POST["emailHost"])
    && isset($_POST["emailPort"])
    && isset($_POST["emailUserName"])
    && isset($_POST["emailPassword"])
    && isset($_POST["emailName"])
    && isset($_POST["suEmail"])
    && isset($_POST["suName"])
    && isset($_POST["suPassword"])) {

    $seed = str_split('abcdefghijklmnopqrstuvwxyz123456789');
    shuffle($seed);
    $dbPrefix = '';
    foreach (array_rand($seed, 4) as $k) $dbPrefix .= $seed[$k];

    $newConfig = "<?php
// Database
define(\"DBNAME\",\"{$_POST["dbName"]}\");
define(\"DBUSER\",\"{$_POST["dbUser"]}\");
define(\"DBPWD\",\"{$_POST["dbPassword"]}\");
define(\"DBDRIVER\",\"mysql\");
define(\"DBPORT\",\"{$_POST["dbPort"]}\");
define(\"DBHOST\",\"{$_POST["dbHost"]}\");
define(\"DBPREFIXE\",\"{$dbPrefix}_\");
// PHPMailer
define(\"MAILHOST\",\"{$_POST["emailHost"]}\");
define(\"MAILPORT\", {$_POST["emailPort"]});
define(\"MAILSMTPAUTH\", true);
define(\"MAILSECURE\", \"ssl\");
define(\"MAILUSERNAME\", \"{$_POST["emailUserName"]}\");
define(\"MAILPWD\", \"{$_POST["emailPassword"]}\");
define(\"MAILNAME\", \"{$_POST["emailName"]}\");
// Theme
define(\"PATH\", \"/var/www/html/Core/../Assets/themes/\");
define(\"PATHTMP\", \"/var/www/html/Core/../Assets/tmp/\");

define(\"ROOT_URL\", \"{$_POST["domaineName"]}\");
";

    $confFile = fopen("conf.inc.php", "w");
    fwrite($confFile, $newConfig);
    fclose($confFile);

    require("conf.inc.php");

    try{
        $pdo = new \PDO( DBDRIVER.":host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME ,DBUSER , DBPWD );
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }catch(\Exception $e){
        die("Erreur SQL".$e->getMessage());
    }

    $dbImport = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
START TRANSACTION;
SET time_zone = \"+00:00\";

CREATE DATABASE IF NOT EXISTS `mvcdocker2` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mvcdocker2`;

CREATE TABLE `{$dbPrefix}_log` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `{$dbPrefix}_role` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `colour` char(6) NOT NULL,
  `create_page` tinyint(1) NOT NULL DEFAULT '0',
  `modify_page` tinyint(1) NOT NULL DEFAULT '0',
  `delete_page` tinyint(1) NOT NULL DEFAULT '0',
  `add_comment` tinyint(1) NOT NULL DEFAULT '0',
  `admin_rights` tinyint(1) NOT NULL DEFAULT '0',
  `is_super_user` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `{$dbPrefix}_role` (`id`, `name`, `colour`, `create_page`, `modify_page`, `delete_page`, `add_comment`, `admin_rights`, `is_super_user`) VALUES
(1, 'SuperUser', 'FF0000', 1, 1, 1, 1, 1, 1),
(2, 'Sefault', '00FF00', 0, 0, 0, 0, 0, 0);

CREATE TABLE `{$dbPrefix}_user` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `connectionToken` char(32) DEFAULT NULL,
  `validationToken` varchar(32) DEFAULT NULL,
  `passwordForgetToken` varchar(32) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `role` smallint(6) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `{$dbPrefix}_user` (`id`, `login`, `email`, `password`, `status`, `connectionToken`, `validationToken`, `passwordForgetToken`, `role`) VALUES
('1',:suName, :suEmail, :suPassword, 0, NULL, NULL, NULL, 1);

CREATE TABLE `{$dbPrefix}_wikipage` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `parentPageId` int(11) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `{$dbPrefix}_wikipage` (`id`, `title`, `parentPageId`) VALUES
(1, 'accueil', NULL);

CREATE TABLE `{$dbPrefix}_wikipageversion` (
  `id` int(11) NOT NULL,
  `versionNumber` double NOT NULL,
  `versionOf` int(11) NOT NULL,
  `isCurrentVersion` tinyint(1) NOT NULL,
  `content` text,
  `author` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `{$dbPrefix}_wikipageversion` (`id`, `versionNumber`, `versionOf`, `isCurrentVersion`, `content`, `author`) VALUES
(1, 1, 1, 1, '{\"ops\":[{\"insert\":\"\\n\"}]}', 1);

ALTER TABLE `{$dbPrefix}_log`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `{$dbPrefix}_role`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `{$dbPrefix}_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `{$dbPrefix}_wikipage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

ALTER TABLE `{$dbPrefix}_wikipageversion`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `{$dbPrefix}_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{$dbPrefix}_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT;

ALTER TABLE `{$dbPrefix}_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT;

ALTER TABLE `{$dbPrefix}_wikipage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT;

ALTER TABLE `{$dbPrefix}_wikipageversion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT;
COMMIT;";

    $suName = trim($_POST["suName"]);
    $suEmail = strtolower(trim($_POST["suEmail"]));
    $suPassword = password_hash($_POST["suPassword"], PASSWORD_DEFAULT);

    $queryPrepared = $pdo->prepare($dbImport);
    $queryPrepared->execute([":suName"=>$suName,":suEmail"=>$suEmail,":suPassword"=>$suPassword]);
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $titleSeo??"Wikicat" ?></title>
        <meta name="description" content="ceci est la description de ma page">

        <link rel="stylesheet" href="../../Assets/dist/main.css">

        <script src="../Assets/js/jquery.js"></script>
    </head>
    <body>
        <main class="container-fluid">
            <form class="row" method="post">
                <section class="col-12">
                    <h1><span class="text-weight-800">Wiki</span><span class="text-secondary text-weight-400">cat</span></h1>
                    <h2>Installation de votre wiki</h2>

                    Nous avons besoin de quelques informations
                </section>

                <section class="col-12">
                    <h2>Wiki</h2>

                    <input type="text" name="domaineName" placeholder="monwiki.com" required>
                    <input type="email" name="suEmail" placeholder="email super utilisateur" required>
                    <input type="text" name="suName" placeholder="login super utilisateur" required>
                    <input type="password" name="suPassword" placeholder="mot de passe super utilisateur" required>
                </section>

                <section class="col-12">
                    <h2>Base de données</h2>

                    <div class="alert alert--info">
                        Attention, wikicat ne fonctionne que sur des bases de donnée mysql
                    </div>

                    <input type="text" name="dbHost" placeholder="adresse" required>
                    <input type="number" name="dbPort" placeholder="port" required>
                    <input type="text" name="dbUser" placeholder="nom d'utilisateur" required>
                    <input type="password" name="dbPassword" placeholder="mot de passe" required>
                    <input type="text" name="dbName" placeholder="nom de la base" required>
                </section>

                <section class="col-12">
                    <h2>serveur d'email</h2>

                    <input type="text" name="emailHost" placeholder="adresse" required>
                    <input type="number" name="emailPort" placeholder="port" required>
                    <input type="email" name="emailUserName" placeholder="nom d'utilisateur" required>
                    <input type="password" name="emailPassword" placeholder="mot de passe" required>
                    <input type="text" name="emailName" placeholder="nom d'affichage'" required>
                </section>

                <section>
                    <button type="submit" class="btn btn--success">Installer le wiki</button>
                </section>
            </form>
        </main>
    </body>
</html>