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

</head>

<body>
  
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Team Purple B03</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar navbar-nav p-2">
      <a class="nav-link hoverable active" href="./index.php">Home <span class="sr-only">(current)</span></a>
      <a class="nav-link hoverable" href="./pages/faq.php">FAQ</a>
      <a class="nav-link hoverable" href="./pages/contact_us.php">Contact Us</a>
      <a class="nav-link hoverable" href="./pages/add_pet.php">Add a Pet</a>
      <a class="nav-link hoverable" href="./pages/update_pet.php">Update Pet</a>
      <a class="nav-link hoverable" href="./pages/pet_history.php">Pet History</a>
    </div>
    <div class="navbar navbar-nav ml-auto p-2" id="navbar">
          <a class="btn btn-md hoverable" data-toggle="modal" data-target="#signupModal">Sign Up</a>
          <a class="btn btn-md hoverable" data-toggle="modal" data-target="#loginModal">Log In</a>
      </div>
  </div>
</nav>
  
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