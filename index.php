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
                                        });
                                        break;
                                }
                            }
                        }
                    });
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
    <?php require_once './navigation/home-navbar.php'; ?>

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
