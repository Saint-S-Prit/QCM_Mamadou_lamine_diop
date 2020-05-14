<?php
session_start();

    if (!isset($_SESSION['admin']))
    {
        header('Location:/quizz');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../asset/css/style.css">
    <link rel="stylesheet" href="../asset/css/mediaquery.css">
    <title>Document</title>
</head>
<body>
    <?php
    $logo = "../asset/Images/logo-QuizzSA.png";
        require_once('../layout/header.php');
        require_once('../layout/_admin.php');
        require_once('../layout/footer.php');
    ?>
</body>
</html>