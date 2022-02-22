<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Title</title>
        <script src="../js/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="../js/tree.js"></script>
        <link href="../dist/main.css" rel="stylesheet">
    </head>
    <body>
        <?php
            echo "<h2>Grille</h2>";

            include_once "Grid.php";

            echo "<h2>Input</h2>";

            include_once "Form/Input.php";


            echo "<h2>Components</h2>";

            include_once "Components/Alerts.php";
            include_once "Components/Buttons.php";
            include_once "Components/Card.php";
            include_once "Components/Tree.php";


            echo "<h2>Utils</h2>";

            include_once "Utils/Spacing.php";
        ?>
    </body>
</html>
