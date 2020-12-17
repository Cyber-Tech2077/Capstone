<?php
	//session_start();
	require_once '../php/Retrieve-Info.php';
	//include (__DIR__ . "/../php/modals/Modals.html");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Team Purple B03</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
    <!-- Bootstrap JS -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-table.min.js"></script>
    <script src="../js/bootstrap-table-filter-control.min.js"></script>
    <!-- COntent Control Class -->
    <script src="../js/contentControl.js" type="application/ecmascript"></script>
    <!-- Sweetalert 2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Vex JS -->
    <script type="text/javascript" src="../libraries/vex-master/dist/js/vex.combined.min.js"></script>
    <!-- Bootstrap Stylesheets -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/bootstrap-table.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap-table-filter-control.min.css">
    <!-- Vex Stylesheets -->
    <link rel="stylesheet" href="../libraries/vex-master/dist/css/vex.css" />
    <link rel="stylesheet" href="../libraries/vex-master/dist/css/vex-theme-os.css" />
    <!-- Purple B03 Stylesheet -->
    <link rel="stylesheet" href="../css/style.css" />
    <!-- Element Organizer Stylesheet -->
    <link rel="stylesheet" href="../css/organize_elements.css" />
</head>

<script type="text/javascript">
    $(document).ready(function() {
        var petName = document.getElementById("petname_id");
        var petBirthDate = document.getElementById("birthday_id");
        var petWeight = document.getElementById("weight_id");
        var petStreet = document.getElementById("street_id");
        var petCity = document.getElementById("city_id");
        var petState = document.getElementById("state_id");
        var petZip = document.getElementById("zip_id");
        var petChip = document.getElementById("chip_id");

        let items = {
            items: ['*']
        };
        let connect = {
            connect: 'Pets'
        };
        $.post({
            url: '../php/add_service.php',
            data: {
                fetch: {
                    items: JSON.stringify(items),
                    connect: JSON.stringify(connect)
                }
            },
            dataType: 'json',
            success: function(json) {
                $('#updatePetTable')[0].children[1].setAttribute('style', 'text-align: center;');
                $('#updatePetTable').bootstrapTable('load', json);
            }
        });

        $('#updatePetTable').on('click-row.bs.table', function(e, row, element) {
            vex.dialog.open({
                className: 'vex-theme-os',
                input: [
                    '<div class="form-row"">',
                    '<div class="col-sm-6">',
                    '<label for="name">Pet Name</label>',
                    '<input type="text" style="text-align: center;" name="name" class="form-control" id="name"/>',
                    '</div>',
                    '<div class="col-sm-6">',
                    '<label for="birthdate">BirthDate</label>',
                    '<input type="date" style="text-align: center;" name="birthdate" class="form-control" id="birthdate"/>',
                    '</div>',
                    '</div>',
                    '<div style="margin: auto;" class="form-row">',
                    '<div class="col-sm-4">',
                    '<label for="species">Pet Species</label>',
                    '<input type="text" style="text-align: center;" name="species" class="form-control" id="species"/>',
                    '</div>',
                    '<div class="col-sm-4">',
                    '<label for="weight">Weight</label>',
                    '<input type="number" style="text-align: center;" name="weight" class="form-control" id="weight"/>',
                    '</div>',
                    '<div class="col-sm-4">',
                    '<label for="chipId">Chip ID</label>',
                    '<input type="text" style="text-align: center;" name="chipId" id="chipId" class="form-control" />',
                    '</div>',
                    '</div>',
                    '<legend for="address">Address</legend>',
                    '<div style="margin: auto;" class="form-row">',
                    '<div class="col-sm-6">',
                    '<label for="street">Street</label>',
                    '<input type="text" style="text-align: center;" name="street" id="street" class="form-control" />',
                    '</div>',
                    '<div class="col-sm-6">',
                    '<label for="city">City</label>',
                    '<input type="text" style="text-align: center;" name="city" id="city" class="form-control" />',
                    '</div>',
                    '</div>',
                    '<div style="margin: auto;" class="form-row">',
                    '<div class="col-sm-6">',
                    '<label for="state">State</label>',
                    '<select type="select" style="text-align: center;" name="state" id="state" class="form-control">',
                    '<option value="" disabled>Choose a state</option>',
                    `<?php require_once '../php/data_lists/states.html'; ?>`,
                    '</select>',
                    '</div>',
                    '<div class="col-sm-4">',
                    '<label for="zip">Zip Code</label>',
                    '<input type="text" style="text-align: center;" name="zip" id="zip" maxlength="5" class="form-control" />',
                    '</div>',
                    '</div>'
                ].join(''),
                overlayClosesOnClick: false,
                callback: function(data) {
                    let items = {
                        items: data
                    };
                    let connect = {
                        connect: 'Pets'
                    };
                    let wherever = {
                        id: row['id']
                    };
                    $.post({
                        url: '../php/add_service.php',
                        data: {
                            amend: {
                                items: JSON.stringify(items),
                                connect: JSON.stringify(connect),
                                whenever: JSON.stringify(wherever)
                            }
                        },
                        dataType: 'json',
                        success: function(response) {
                            for (const [key, value] of Object.entries(response)) {
                                if (key.toUpperCase() == 'SUCCESSFUL') {
                                    Swal.fire({
                                        icon: 'success',
                                        text: response[key],
                                        allowOutsideClick: false
                                    }).then(okClicked => {
                                        if (okClicked.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                }
                            }
                        }
                    });
                }
            });
            $('#zip').keydown(function(event) {
                return new ContentControl().keyboardNumbers(event);
            });
            // Loop through Object keys, find a specific string and 
            // if the conditions are true. Check mark the box.
            for (var itemKey in row) {
                if (itemKey.indexOf('id') == -1) {
                    if (itemKey.indexOf('visible') == -1) {
                        document.getElementById(itemKey).value = row[itemKey];
                    }
                } else {
                    continue;
                }
            }
        });
        /*$("#select_pet_control").change(function() {
            document.getElementById("speciesRadiosOther").value = ""
            var data = {
                petinfo: ['name', 'species', 'birthdate', 'weight', 'street', 'city', 'state', 'zip', 'chipId']
            };
            var petData = {
                id: idNum.options[idNum.selectedIndex].id
            };
            $.post({
                url: '../php/add_service.php',
                data: {
                    fetch: {
                        items: JSON.stringify(data),
                        whenever: JSON.stringify(petData)
                    }
                },
                dataType: 'json',
                success: function(jsonData) {
                    if (Array.isArray(jsonData)) {
                        for (var index = 0; index < jsonData.length; index++) {
                            petName.value = jsonData[index]["name"];
                            if (jsonData[index]["species"] == "Dog") {
                                document.getElementById("speciesRadios1").checked = true;
                            } else if (jsonData[index]["species"] == "Cat") {
                                document.getElementById("speciesRadios2").checked = true;
                            } else {
                                document.getElementById("speciesRadios3").checked = true;
                                document.getElementById("speciesRadiosOther").value = jsonData[index]["species"];
                                $('#speciesRadiosOther').show();
                            }
                            petBirthDate.value = jsonData[index]["birthdate"];
                            petWeight.value = jsonData[index]["weight"];
                            petStreet.value = jsonData[index]["street"];
                            petCity.value = jsonData[index]["city"];
                            petState.value = jsonData[index]["state"];
                            petZip.value = jsonData[index]["zip"];
                            petChip.value = jsonData[index]["chipId"];
                        }
                    }
                }
            })
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
            var params = {
                name: petName.value,
                species: petSpecies,
                birthdate: petBirthDate.value,
                weight: petWeight.value,
                street: petStreet.value,
                city: petCity.value,
                state: petState.value,
                zip: petZip.value,
                chipId: petChip.value
            };
            var when = {
                id: idNum.options[idNum.selectedIndex].id
            };
            $.post({
                url: '../php/add_service.php',
                data: {
                    amend: {
                        items: JSON.stringify(params),
                        whenever: JSON.stringify(when)
                    }
                },
                dataType: 'json',
                success: function(feedback) {
                    for (var jsonKey in feedback) {
                        switch (jsonKey.toUpperCase()) {
                            case 'ERROR':
                                Swal.fire({
                                    icon: 'error',
                                    text: feedback[jsonKey]
                                });
                                break;
                            case 'SUCCESSFUL':
                                Swal.fire({
                                    icon: 'success',
                                    text: 'Pet Updated!'
                                });
                                break;
                        }
                    }
                }
            });
        });*/
    });

</script>


<body>

    <?php require_once '../php/pages-navbar.html'; ?>

    <div class="container">
        <div class="row">
            <img src=" ../images/title_banner/Update_Pet.png" class="img-fluid mx-auto" alt="Update Pet">
        </div>
    </div>

    <table style="width: 600px;" id="updatePetTable" class="table table-hover col-md-6" data-toggle="table" data-filter-control="true">
        <thead>
            <tr>
                <th data-field="id" data-visible="false">Id</th>
                <th data-field="name" data-filter-control="select">Name</th>
                <th data-field="species" data-filter-control="select">Species</th>
                <th data-field="birthdate" data-filter-control="select">BirthDate</th>
                <th data-field="weight" data-filter-control="select">Weight</th>
                <th data-field="chipId" data-filter-control="select">Chip ID</th>
            </tr>
        </thead>
    </table>

</body>

</html>
