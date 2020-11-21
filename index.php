<!DOCTYPE html>
<html lang="en">
<head>
  <title>Team Purple B03</title>  

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <link rel="stylesheet" href="./css/style.css"/>
  
  
  <link rel="stylesheet" href="./css/bootstrap.min.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="./js/bootstrap.min.js"></script>
  <script src="./js/secondnav_toggle.js"></script>

</head>
<?php require_once "./php/home-navbar.html"; ?>
<body>
  <div class="jumbotron jumbotron-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h1 class="h1">Team Purple B03</h1>
            </div>
        </div>
    </div>
  </div>

  <?php
    include ("./php/carousel.html");
  ?>

</body>
</html>