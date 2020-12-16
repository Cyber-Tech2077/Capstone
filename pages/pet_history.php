<?php require_once "../php/Retrieve-Info.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Team Purple B03</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/secondnav_toggle.js"></script>

    <link rel="stylesheet" href="../css/style.css" type="text/css" />
    <link rel="stylesheet" href="../css/organize_elements.css" type="text/css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
</head>
<?php require_once "../php/pages-navbar.html"; ?>.
<script type="text/javascript">
    $(document).ready(function() {

        $("#select_pet_control").change(function() {

            var petChosen = document.getElementById("select_pet_control");
            if (petChosen.value !== '') {
                var selectedPet = {
                    items: 'history'
                };
                var connect = {
                    directory: 'history'
                }
                var seatbelt = {
                    click: 'location'
                };
                var whenever = {
                    petId: petChosen.options[petChosen.selectedIndex].id
                };
                $.post({
                    url: "../php/add_service.php",
                    data: {
                        fetch: {
                            items: JSON.stringify(selectedPet),
                            connect: JSON.stringify(connect),
                            fasten: JSON.stringify(seatbelt),
                            whenever: JSON.stringify(whenever)
                        }
                    },
                    dataType: 'json',
                    success: function(json) {

                        //make sure table is clear
                        $("#output_body tr").remove();

                        //loop through array to make new row for each service with date
                        var tbodyRef = document.getElementById('output_body');

                        if (Array.isArray(json)) {
                            for (var index = 0; index < json.length; index++) {
                                var newRow = tbodyRef.insertRow(index);

                                var checkbox1 = document.createElement('input');
                                checkbox1.setAttribute('type', 'checkbox');

                                var checkbox2 = document.createElement('input');
                                checkbox2.setAttribute('type', 'checkbox');

                                var checkbox3 = document.createElement('input');
                                checkbox3.setAttribute('type', 'checkbox');

                                var currentIndex = 0;
                                for (var result in json[index]) {
                                    var cellNum = newRow.insertCell(currentIndex);
                                    switch (currentIndex) {
                                        case 3:
                                            cellNum.setAttribute('style', 'text-align: center;');
                                            cellNum.appendChild(checkbox1);
                                            if (json[index][result] == '1') {
                                                checkbox1.checked = true;
                                            }
                                            break;
                                        case 4:
                                            cellNum.setAttribute('style', 'text-align: center');
                                            cellNum.appendChild(checkbox2);
                                            if (json[index][result] == '1') {
                                                checkbox2.checked = true;
                                            }
                                            break;
                                        case 5:
                                            cellNum.setAttribute('style', 'text-align: center');
                                            cellNum.appendChild(checkbox3);
                                            if (json[index][result] == '1') {
                                                checkbox3.checked = true;
                                            }
                                            break;
                                        default:
                                            cellNum.setAttribute('style', 'text-align: center');
                                            cellNum.innerHTML = json[index][result];
                                    }
                                    currentIndex++;
                                }
                            }
                        } else if (typeof json == 'object') {
                            var newRow = tbodyRef.insertRow(0);
                            // Individual Columns
                            var cell1 = newRow.insertCell(0);
                            var cell2 = newRow.insertCell(1);
                            var cell3 = newRow.insertCell(2);
                            var cell4 = newRow.insertCell(3);
                            var cell5 = newRow.insertCell(4);
                            var cell6 = newRow.insertCell(5);
                            var cell7 = newRow.insertCell(6);

                            cell1.innerHTML = 'N/A';
                            cell2.innerHTML = 'N/A';
                            cell3.innerHTML = 'N/A';
                            cell4.innerHTML = 'N/A';
                            cell5.innerHTML = 'N/A';
                            cell6.innerHTML = 'N/A';
                            cell7.innerHTML = 'Using a object datatype isn\'t allowed. Please use an array datatype instead.';
                        }
                    },
                    error: function(err) {
                        alert("Err " + err);
                    }
                });
            } else {
                //make sure table is clear
                $("#output_body tr").remove();
            }
        });

        $('#login').click(function() {
            Swal.fire({
                title: 'Sign In',
                html: '<input id="swal-input1" class="swal2-input">' +
                    '<input id="swal-input2" class="swal2-input">',
                preConfirm: () => {
                    return [
                        document.getElementById('swal-input1').value,
                        document.getElementById('swal-input2').value
                    ]
                }
            }).then((result1) => {
                Swal.fire(result1.value[0]);
            });
        });

    });

</script>

<body>

    <div class="container">
        <div class="row">
            <img src=" ../images/title_banner/Pet_History.png" class="img-fluid mx-auto" alt="Pet History">
        </div>
    </div>

    <div id="formContainer">
        <div class="form-group col-8" id="selectContainer">
            <legend class="control-legend" id="select_pet">Select Pet</legend>
            <select class="form-control" id="select_pet_control">

                <!-- Select Pet Dropdown Options - Goes Here -->
                <option value=""></option>
                <?php
                    $retrievePet = new DataRetrieval();
                    echo $retrievePet->getOptions(array('id', 'name'));
                ?>

            </select>
        </div>
    </div>
    <br />
    <div class="container">
        <table class="table" id="outputHistory">
            <thead>
                <tr>
                    <th class="histColHdr" scrop="col">Date</th>
                    <th class="histColHdr" scope="col">Service</th>
                    <th class="histColHdr" scope="col">Location</th>
                    <th class="histColHdr" scope="col">Vetted</th>
                    <th class="histColHdr" scope="col">Groomed</th>
                    <th class="histColHdr" scope="col">Boarded</th>
                    <th class="histColHdr" scope="col">Details</th>
                </tr>
            </thead>
            <tbody id="output_body">
                <!-- Loop through each entry here -->
            </tbody>
        </table>
    </div>

</body>

</html>
