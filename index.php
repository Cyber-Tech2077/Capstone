<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Team Purple B03</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="./css/style.css" />


    <link rel="stylesheet" href="./css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./libaries/Blowfish.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/secondnav_toggle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#signup").click(function() {
                Swal.fire({
                    title: 'Sign Up',
                    html: `<input type="text" id="login" class="swal2-input" placeholder="Username" required>
                                <input type="password" id="password" class="swal2-input" placeholder="Password" required>
                                <input type="email" id="email" class="swal2-input" placeholder="Email" required>`,
                    confirmButtonText: 'Sign Up',
                    focusConfirm: false,
                    preConfirm: () => {
                        const login = Swal.getPopup().querySelector('#login').value;
                        const password = Swal.getPopup().querySelector('#password').value;
                        const email = Swal.getPopup().querySelector('#email').value;
                        if (!login || !password || !email) {
                            Swal.showValidationMessage(`Please enter login, password and email.`);
                        }
                        return {
                            login: login,
                            password: password,
                            email: email
                        }
                    }
                }).then((result) => {
                    var signUpData = {
                        username: result.value['login'].toLowerCase(),
                        password: result.value['password'],
                        email: result.value['email'].toLowerCase()
                    };
                    $.post({
                        url: './php/post-usages/simpleSignUp.php',
                        data: {
                            signup: JSON.stringify(signUpData)
                        },
                        dataType: 'json',
                        success: function(json) {
                            for (var message in json) {
                                switch (message.toUpperCase()) {
                                    case 'SUCCESSFUL':
                                        Swal.fire({
                                            icon: 'success',
                                            text: json[message]
                                        })
                                        break;
                                }
                            }
                        }
                    })
                });
            });

            $("#login").click(function() {

                Swal.fire({
                    title: 'Login Form',
                    html: `<input type="text" id="login" class="swal2-input" placeholder="Username" required>
                    <input type="password" id="password" class="swal2-input" placeholder="Password" required>`,
                    confirmButtonText: 'Sign in',
                    focusConfirm: false,
                    preConfirm: () => {
                        const login = Swal.getPopup().querySelector('#login').value;
                        const password = Swal.getPopup().querySelector('#password').value;
                        if (!login || !password) {
                            Swal.showValidationMessage(`Please enter login and password`);
                        }
                        return {
                            login: login,
                            password: password
                        }
                    }
                }).then(result => {
                    var loginData = {
                        username: result.value['login'],
                        password: result.value['password']
                    };
                    $.post({
                        url: './php/post-usages/simpleLogin.php',
                        data: {
                            userData: JSON.stringify(loginData)
                        },
                        dataType: 'json',
                        success: function(json) {
                            window.location.reload();
                        }
                    });
                });
            });
            $('#logout').click(function() {
                var userOut = {
                    logout: 'You have been successfully logged out.'
                };
                $.post({
                    url: './php/post-usages/User.php',
                    data: {
                        userSignOut: JSON.stringify(userOut)
                    },
                    dataType: 'json',
                    success: function(json) {
                        for (var message in json) {
                            switch (message.toUpperCase()) {
                                case 'LOGOUT':
                                    Swal.fire({
                                        icon: 'success',
                                        text: json[message]
                                    }).then(result => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                    break;
                            }
                        }
                    }
                });
            });

        });

    </script>



</head>

<body>

    <div id="main_nav">
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
                </div>
                <div class="navbar navbar-nav ml-auto p-2" id="navbar">
                    <?php if (isset($_SESSION['currentUser'])): ?>
                    <a class="btn btn-md btn-outline-warning" id="mode_button" onclick="second_navbar()">User Mode</a>
                    <a class="btn btn-md hoverable" data-toggle="modal" id='currentUser'>Welcome, <?php echo $_SESSION['currentUser'] ?></a>
                    <a class="btn btn-md hoverable" data-toggle="modal" id='logout'>Log out</a>
                    <?php else: ?>
                    <a class="btn btn-md hoverable" data-toggle="modal" id='signup' data-target="#signupModal">Sign Up</a>
                    <a class="btn btn-md hoverable" data-toggle="modal" id="login" data-target="#loginModal">Log In</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>

    <div id="user_nav">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup2" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup2">
                <div class="navbar navbar-nav p-2">
                    <!-- Veterinary Dropdown -->
                    <div class="dropdown text-center">
                        <a class="nav-link dropdown-toggle hoverable" data-toggle="dropdown">Pet</a>
                        <div class="dropdown-menu text-center">
                            <a class="dropdown-item nav-link hoverable" href="./pages/add_pet.php">Add a Pet</a>
                            <a class="dropdown-item nav-link hoverable" href="./pages/update_pet.php">Update Pet</a>
                            <a class="dropdown-item nav-link hoverable" href="./pages/pet_history.php">Pet History</a>
                        </div>
                    </div>
                    <!-- Veterinary Dropdown -->
                    <div class="dropdown text-center">
                        <a class="nav-link dropdown-toggle hoverable" data-toggle="dropdown">Veterinary</a>
                        <div class="dropdown-menu text-center">
                            <a class="dropdown-item nav-link hoverable" href="./pages/add_vet_service.php">Add Veterinary Service</a>
                        </div>
                    </div>
                    <!-- Grooming Dropdown -->
                    <div class="dropdown text-center">
                        <a class="nav-link dropdown-toggle hoverable" data-toggle="dropdown">Grooming</a>
                        <div class="dropdown-menu text-center">
                            <a class="dropdown-item nav-link hoverable" href="./pages/add_grooming_service.php">Add Grooming Service</a>
                        </div>
                    </div>
                    <!-- Boarding Dropdown -->
                    <div class="dropdown text-center">
                        <a class="nav-link dropdown-toggle hoverable" data-toggle="dropdown">Boarding</a>
                        <div class="dropdown-menu text-center">
                            <a class="dropdown-item nav-link hoverable" href="./pages/add_boarding_service.php">Add Boarding Service</a>
                        </div>
                    </div>
                    <!-- Location Dropdown -->
                    <div class="dropdown text-center">
                        <a class="nav-link dropdown-toggle hoverable" data-toggle="dropdown">Location</a>
                        <div class="dropdown-menu text-center">
                            <a class="dropdown-item nav-link hoverable" href="./pages/add_location.php">Add a Location</a>
                            <a class="dropdown-item nav-link hoverable" href="./pages/update_location.php">Update a Location</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>

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
