<?php
	session_start();
	include (__DIR__ . "/../php/headernav.php");
	include_once(__DIR__."/../php/DBConnect.php");
	include (__DIR__ . "/../php/modals/Modals.html");

	function comboboxOptions() {
		// This php code works, all values come out as normal.
		// No need to mess with this.
		$conn = databaseConnect("Pet");
		try {
			$sql = "select id, name, hidepet from Pets";
			$stmt = sqlsrv_query($conn, $sql);
			if ($stmt === false) {
				echo "Error Occurred: " . sqlsrv_errors();
			} else {
				$storeValueId;
				while ($row = sqlsrv_fetch_object($stmt)) {
                    if ($row->hidepet !== 1) {
                        echo "<option id = " . $row->id . " value = " . $row->name . ">" . $row->name . "</option>";
                    }
				}
			}
		} catch (Throwable $e) {
			echo "Throwable Error: " . $e;
		}
		sqlsrv_close($conn);
	}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Companion Vault</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style href="../css/bootstrap.min" rel="stylesheet" type="text/css"></style>
    <script src="../js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<script type="text/javascript">
    $(document).ready(function() {

        function signUpUser() {
            Swal.fire({
                title: 'Sign Up',
                html: `<input type="text" id="login" class="swal2-input" placeholder="Username" required>
                    <input type="password" id="password" class="swal2-input" placeholder="Password" required>
                    <input type="email" id="email" class="swal2-input" placeholder="Email" required>`,
                confirmButtonText: 'Sign Up',
                showCancelButton: true,
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
                if (result.isConfirmed) {
                    var signUpData = {
                        username: result.value['login'].toLowerCase(),
                        password: result.value['password'],
                        email: result.value['email'].toLowerCase()
                    };
                    $.post({
                        url: '../php/post-usages/simpleSignUp.php',
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
                                    case 'ERROR':
                                        Swal.fire({
                                            icon: 'error',
                                            text: json[message]
                                        }).then(result => {
                                            signUpUser();
                                        });
                                        break;
                                }
                            }
                        }
                    });
                }
            });
        }

        var idNum = document.getElementById("select_pet_control");
        var hidePet = document.getElementById("hidePet_id");
        $("#select_pet_control").change(function() {
            document.getElementById("speciesRadiosOther").value = ""
            $.post({
                url: "../php/retrieve_pet.php",
                data: {
                    pet_ID: idNum.options[idNum.selectedIndex].id
                },
                success: function(feedback) {
                    var json = JSON.parse(feedback);
                    document.getElementById("petname_id").value = json["Name"];
                    if (json["Species"] == "Dog") {
                        document.getElementById("speciesRadios1").checked = true;
                    } else if (json["Species"] == "Cat") {
                        document.getElementById("speciesRadios2").checked = true;
                    } else {
                        document.getElementById("speciesRadios3").checked = true;
                        document.getElementById("speciesRadiosOther").value = json["Species"];
                        $('#speciesRadiosOther').show();
                    }

                    document.getElementById("birthday_id").value = json["Birthdate"];
                    document.getElementById("weight_id").value = json["Weight"];
                    document.getElementById("street_id").value = json["Street"];
                    document.getElementById("city_id").value = json["City"];
                    document.getElementById("state_id").value = json["State"];
                    document.getElementById("zip_id").value = json["Zip"];
                    document.getElementById("chip_id").value = json["Chip"];
                    if (json["HidePet"] == 1) {
                        hidePet.checked = true;
                    } else {
                        hidePet.checked = false;
                    }
                }

            });
        });

        $("#signup").click(function() {
            signUpUser();
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
                    url: '../php/post-usages/simpleLogin.php',
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
                url: '../php/post-usages/User.php',
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

        $("#update_pet").click(function() {
            // Changed id assocaited with select html element.
            if (document.getElementById("speciesRadios1").checked) {
                var petSpecies = document.getElementById("speciesRadios1").value
            } else if (document.getElementById("speciesRadios2").checked) {
                var petSpecies = document.getElementById("speciesRadios2").value
            } else {
                var petSpecies = document.getElementById("speciesRadiosOther").value
            }

            // Used idNum.options[idNum.selectedIndex].id to fetch the id associated with the
            // selected pet name.
            var hidePetValue = 0;
            if (hidePet.checked) {
                hidePetValue = 1;
            }
            $.post({
                url: "../php/update_petDB.php",
                data: {
                    pet_name: document.getElementById("petname_id").value,
                    pet_species: petSpecies,
                    pet_birthdate: document.getElementById("birthday_id").value,
                    pet_weight: document.getElementById("weight_id").value,
                    pet_street: document.getElementById("street_id").value,
                    pet_city: document.getElementById("city_id").value,
                    pet_state: document.getElementById("state_id").value,
                    pet_zip: document.getElementById("zip_id").value,
                    pet_chip: document.getElementById("chip_id").value,
                    pet_ID: idNum.options[idNum.selectedIndex].id,
                    hidepet: hidePetValue
                },
                success: function() {
                    $('#update_successful').modal();
                    document.getElementById("petname_id").value = "";
                    document.getElementsByTagName("speciesRadios").checked = false;
                    document.getElementById("birthday_id").value = "";
                    document.getElementById("weight_id").value = "";
                    document.getElementById("street_id").value = "";
                    document.getElementById("city_id").value = "";
                    document.getElementById("state_id").value = "";
                    document.getElementById("zip_id").value = "";
                    document.getElementById("chip_id").value = "";
                }
            });
        });
    });

</script>


<body>

    <div class="container">
        <div class="row">
            <img src=" ../images/title_banner/Update_Pet.png" class="img-fluid mx-auto" alt="Update Pet">
        </div>
    </div>

    <div class="row">
        <!-- Left Column-->
        <div class="col-md-6 mx-auto">
            <div class="form-group col-md-12">
                <legend class="control-legend" id="select_pet">Select a Pet to Update</legend>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" id="select_pet_control">
                    <option value=""></option>
                    <?php comboboxOptions(); ?>
                </select>
            </div>
        </div>
        <hr class="form-group col-10 solid">
    </div>

    <form>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    <legend class="control-legend">Pet</legend>
                </div>
                <!-- Name -->
                <div class="form-group col-lg-10">
                    <label class="control-label">Name</label>
                    <input type="text" class="form-control col-8" id="petname_id" name="petname">
                </div>

                <!-- Species -->
                <div class="form-group col-lg-10">
                    <label>Species</label>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="speciesRadios1" name="speciesRadios" class="custom-control-input" value="Dog">
                        <label class="custom-control-label m-2" for="speciesRadios1">Dog</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="speciesRadios2" name="speciesRadios" class="custom-control-input" value="Cat">
                        <label class="custom-control-label m-2" for="speciesRadios2">Cat</label>
                    </div>
                    <div class="form-inline">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="speciesRadios3" name="speciesRadios" class="custom-control-input" value="">
                            <label class="custom-control-label m-2" for="speciesRadios3">Other</label>
                        </div>
                        <input class="form-control col-4" type="text" id="speciesRadiosOther" style="display: none">
                    </div>
                </div>

                <!-- Birth Date -->
                <div class="form-group col-lg-10">
                    <label class="control-label">Birth Date</label>
                    <input class="form-control col-5 col-sm-7 col-md-6 col-lg-5 col-xl-4" type="date" id="birthday_id">
                </div>

                <!-- Weight -->
                <div class="form-group col-lg-10">
                    <label class="col-form-label">Weight in lbs.</label>
                    <input class="form-control col-3 col-sm-4 col-md-5 col-lg-3" type="number" min="0" step="0.1" pattern="d+(.d{1})?" id="weight_id" placeholder="0.0">
                </div>

                <!-- Chip Id -->
                <div class="form-group col-lg-10">
                    <label class="control-label">Chip ID</label>
                    <input type="text" class="form-control col-8" id="chip_id" chipNum="chipId">
                </div>
            </div>

            <!-- Right Column-->
            <div class="col-md-6">
                <!-- Address -->
                <div class="form-group col-md-12">
                    <legend class="control-legend">Address</legend>
                </div>
                <div class="form-group col-lg-10">
                    <!-- Street -->
                    <label class="control-label">Street</label>
                    <input type="text" class="form-control" id="street_id">
                </div>

                <div class="form-group col-lg-10">
                    <!-- City-->
                    <label class="control-label">City</label>
                    <input type="text" class="form-control" id="city_id">
                </div>

                <div class="row col-12">
                    <div class="form-group col-md-8 col-lg-6">
                        <!-- State  -->
                        <label class="control-label">State</label>
                        <select class="form-control" id="state_id">
                            <?php
				include (__DIR__ . "/../php/data_lists/states.html");
				?>
                        </select>
                    </div>

                    <div class="form-group col-md-4 col-lg-4">
                        <!-- Zip Code-->
                        <label class="control-label">Zip Code</label>
                        <input class="form-control" type="text" id="zip_id">
                    </div>
                    <?php if (isset($_SESSION['currentUser'])): ?>
                    <div class="row col-6">
                        <div class="form-group col-sm-4">
                            <label class="control-label">Hide Pet</label>
                            <input type='checkbox' class='form-control' id='hidePet_id' />
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>

    <!-- Save Button -->
    <div class="form-group text-center">
        <button class="btn btn-primary" id="update_pet">Submit</button>
    </div>

</body>

</html>
