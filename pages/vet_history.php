<?php
    session_start();
    include_once("../php/Retrieve-Info.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Companion Vault</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- JQuery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
    <!-- Popper CDN -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <!-- Sweetalert 2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Vex JS -->
    <script type="text/javascript" src="../libraries/vex-master/dist/js/vex.combined.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-table.min.js"></script>
    <script src="../js/bootstrap-table-filter-control.min.js"></script>

    <!-- Bootstrap Stylesheets -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/bootstrap-table.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap-table-filter-control.min.css">
    <!-- Vex Stylesheets -->
    <link rel="stylesheet" href="../libraries/vex-master/dist/css/vex.css" />
    <link rel="stylesheet" href="../libraries/vex-master/dist/css/vex-theme-os.css" />
    <!-- Purple B03 Stylesheet -->
    <link rel="stylesheet" href="../css/style.css" />
</head>

<script type="text/javascript">
    $(document).ready(function() {
        var items = {
            columns: [
                'date', 'name', 'location', 'details', 'k9_rabies', 'k9_distemper',
                'k9_parvo', 'k9_adeno1', 'k9_adeno2', 'k9_parainfluenza', 'k9_bordetella', 'k9_lyme'
            ]
        };
        var connect = {
            connect: 'VetHistory'
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
                $('#table').bootstrapTable('load', json);
            }
        });
        $('#table').on('click-row.bs.table', function(e, row, element) {
            vex.dialog.alert({
                className: 'vex-theme-os',
                input: [
                    '<div class="form-row"">',
                        '<div class="col-sm-4">',
                            '<label for="vetService">Service Date</label>',
                            '<input type="text" style="text-align: center;" class="form-control" name="vetService" id="dateVetService" disabled/>',
                        '</div>',
                        '<div class="col">',
                            '<label for="petName">Pet Name</label>',
                            '<input type="text" style="text-align: center;" class="form-control" name="petName" id="petName" disabled/>',
                        '</div>',
                        '<div class="col-sm-2">',
                            '<label for="vetLocation">Location</label>',
                            '<input type="text" style="text-align: center;" class="form-control" name="vetLocation" id="vetLocation" disabled/>',
                        '</div>',
                    '</div>',
                    '<label for="vetDetails">Vet Details:</label>',
                    '<textarea name="vetDetails" id="vetDetails" disabled></textarea>',
                    '<div style="margin: auto;" class="form-group row">',
                        '<legend style="text-align: center;">Canine Vaccines</legend>',
                        '<div class="form-group col-auto">',
                            '<div class="custom-control custom-checkbox">',
                                '<input type="checkbox" name="k9_vaccines" id="k9_rabies" class="custom-control-input" disabled/>',
                                '<label for="k9_rabies" class="custom-control-label">Rabies</label>',
                            '</div>',
                            '<div class="custom-control custom-checkbox">',
                                '<input type="checkbox" name="k9_vaccines" id="k9_distemper" class="custom-control-input" disabled/>',
                                '<label for="k9_distemper" class="custom-control-label">Distemper</label>',
                            '</div>',
                            '<div class="custom-control custom-checkbox">',
                                '<input type="checkbox" name="k9_vaccines" id="k9_parvovirus" class="custom-control-input" disabled/>',
                                '<label for="k9_parvovirus" class="custom-control-label">Parvovirus</label>',
                            '</div>',
                            '<div class="custom-control custom-checkbox">',
                                '<input type="checkbox" name="k9_vaccines" id="k9_adenovirus_type1" class="custom-control-input" disabled/>',
                                '<label for="k9_adenovirus_type1" class="custom-control-label">Adenovirus Type 1</label>',
                            '</div>',
                            '<div class="custom-control custom-checkbox">',
                                '<input type="checkbox" name="k9_vaccines" id="k9_adenovirus_type2" class="custom-control-input" disabled/>',
                                '<label for="k9_adenovirus_type2" class="custom-control-label">Adenovirus Type 2</label>',
                            '</div>',
                        '</div>',
                        '<div class="form-group col-auto">',
                            '<div class="custom-control custom-checkbox">',
                                '<input type="checkbox" name="k9_vaccines" id="k9_parainfluenza" class="custom-control-input" disabled/>',
                                '<label for="k9_parainfluenza" class="custom-control-label">Parainfluenza</label>',
                            '</div>',
                            '<div class="custom-control custom-checkbox">',
                                '<input type="checkbox" name="k9_vaccines" id="k9_bordetella" class="custom-control-input" disabled/>',
                                '<label for="k9_bordetella" class="custom-control-label">Bordetella</label>',
                            '</div>',
                            '<div class="custom-control custom-checkbox">',
                                '<input type="checkbox" name="k9_vaccines" id="k9_lyme_disease" class="custom-control-input" disabled/>',
                                '<label for="k9_lyme_disease" class="custom-control-label">Lyme Disease</label>',
                            '</div>',
                            '<div class="custom-control custom-checkbox">',
                                '<input type="checkbox" name="k9_vaccines" id="k9_leptospirosis" class="custom-control-input" disabled/>',
                                '<label for="k9_leptospirosis" class="custom-control-label">Leptospirosis</label>',
                            '</div>',
                            '<div class="custom-control custom-checkbox">',
                                '<input type="checkbox" name="k9_vaccines" id="k9_canine_influenza" class="custom-control-input" disabled/>',
                                '<label for="k9_canine_influenza" class="custom-control-label">Canine Influenza</label>',
                            '</div>',
                        '</div>',
                    '</div>'
                ].join('')
            });
            document.getElementById('dateVetService').value = row['date'];
            document.getElementById('petName').value = row['name'];
            document.getElementById('vetLocation').value = row['location'];
            document.getElementById('vetDetails').value = row['details'];
            if (row['k9_rabies'] == '1') {
                document.getElementById('k9_rabies').checked = true;
            } else {
                document.getElementById('k9_rabies').checked = false;
            }
        });
    });

</script>

<body>
    <!-- Do Not Move - php headernav from here-->
    <?php include ("../php/pages-navbar.html"); ?>

    <div class="container">
        <div class="row">
            <img src=" ../images/title_banner/Veterinary_History.png" class="img-fluid mx-auto" alt="Veterinary History">
        </div>
    </div>

    <div class="container">
        <!-- data-search="true" -->
        <table id="table" class="table table-hover" data-toggle="table" data-filter-control="true">
            <thead>
                <tr>
                    <th data-field="id" data-visible="false">Id</th>
                    <th data-field="date" data-sortable="true">Date</th>
                    <th data-field="name" data-filter-control="select">Pet</th>
                    <th data-field="location" data-filter-control="select">Location</th>
                    <th data-field="details" data-filter-control="input">Details</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>


    <form id="filled_form" hidden>
        <div class="row">
            <!-- Left Column-->
            <div class="col-md-6">
                <!-- Pet Name -->
                <div class="form-group col-md-12">
                    <legend class="control-legend" id="select_pet">Pet</legend>
                    <div class="card bg-light col-4 p-1">
                        <p class="mb-0" id="name_card"></p>
                    </div>
                </div>
                <div class="form-group col-12">
                    <legend class="control-legend" id="select_location">Veterinary Location</legend>
                    <div class="card bg-light col-4 p-1">
                        <p class="mb-0" id="location_card"></p>
                    </div>
                </div>
                <!-- Veterinary Service Date -->
                <div class="form-group col-lg-10">
                    <legend class="control-legend">Date of Veterinary Service</legend>
                    <div class="card bg-light col-4 p-1">
                        <p class="mb-0" id="date_card"></p>
                    </div>
                </div>
            </div>
            <!-- Right Column-->
            <div class="col-md-6">
                <!-- K9 Vaccines-->
                <div class="row" id="k9_vaccine_checkboxes" style="display: none">
                    <legend>Canine Vaccines</legend>
                    <!-- K9 Vaccines Left Column-->
                    <div class="col">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="k9_rabies_Id" name="k9_vaccines" value="">
                            <label class="custom-control-label">Rabies</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="k9_distemper_Id" name="k9_vaccines" value="">
                            <label class="custom-control-label">Distemper</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="k9_parvo_Id" name="k9_vaccines" value="">
                            <label class="custom-control-label">Parvovirus</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="k9_adeno1_Id" name="k9_vaccines" value="">
                            <label class="custom-control-label">Adenovirus, Type 1</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="k9_adeno2_Id" name="k9_vaccines" value="">
                            <label class="custom-control-label">Adenovirus, Type 2</label>
                        </div>
                    </div>
                    <!-- K9 Vaccines Right Column-->
                    <div class="col">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="k9_parainfluenza_Id" name="k9_vaccines" value="">
                            <label class="custom-control-label">Parainfluenza</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="k9_bordetella_Id" name="k9_vaccines" value="">
                            <label class="custom-control-label">Bordetella</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="k9_lyme_Id" name="k9_vaccines" value="">
                            <label class="custom-control-label">Lyme Disease</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="k9_leptospirosis_Id" name="k9_vaccines" value="">
                            <label class="custom-control-label">Leptospirosis</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="k9_influenza_Id" name="k9_vaccines" value="">
                            <label class="custom-control-label">Canine Influenza</label>
                        </div>
                    </div>
                </div>
                <!-- Feline Vaccines-->
                <div class="row" id="feline_vaccine_checkboxes" style="display: none">
                    <legend>Feline Vaccines</legend>
                    <div class="col">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="feline_rabies_Id" name="feline_vaccines" value="">
                            <label class="custom-control-label">Rabies</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="feline_distemper_Id" name="feline_vaccines" value="">
                            <label class="custom-control-label">Feline Distemper</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="feline_herpes_Id" name="feline_vaccines" value="">
                            <label class="custom-control-label">Feline Herpesvirus</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="feline_calici_Id" name="feline_vaccines" value="">
                            <label class="custom-control-label">Calicivirus</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="feline_leukemia_Id" name="feline_vaccines" value="">
                            <label class="custom-control-label">Feline Leukemia Virus</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="feline_bordetella_Id" name="feline_vaccines" value="">
                            <label class="custom-control-label">Bordetella</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="col-md-6 mx-auto">
            <div class="form-group">
                <legend class="control-legend">Enter Details</legend>
                <textarea class="form-control no-gray" rows="9" cols="50" id="detail_entry" readonly></textarea>
            </div>
        </div>
    </form>
</body>

</html>
