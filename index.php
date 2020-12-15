<?php
    include ("./php/modals/Login_Signup_Modal.html");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Companion Vault</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="./css/style.css" />


    <link rel="stylesheet" href="./css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/secondnav_toggle.js"></script>
</head>

<body>
    <?php require_once "./php/home-navbar.html"; ?>
    <div class="container">
        <div class="row">
            <img src=" ./images/title_banner/Companion_Vault.png" class="img-fluid mx-auto" alt="Home Page Banner">
        </div>
    </div>

    <?php
    include ("./php/carousel.html");
  ?>

</body>

</html>
