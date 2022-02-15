<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Title</title>
        <link href="../dist/main.css" rel="stylesheet">
    </head>
    <body>
        <?php
            echo "<h2>Input</h2>";

            include_once "Form/Input.php";


            echo "<h2>Components</h2>";

            include_once "Components/Alerts.php";
            include_once "Components/Buttons.php";
            include_once "Components/Card.php";


            echo "<h2>Utils</h2>";

            include_once "Utils/Spacing.php";
        ?>
    </body>
</html>
