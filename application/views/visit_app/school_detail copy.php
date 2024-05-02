<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo site_url('assets/visits/styles.css'); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>

</style>

<body>
    <style>
        .navbar {
            position: fixed;
            width: 100%;
            border-radius: 0px;
            border-bottom: none;
            background-color: #333;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 5px 0;
        }
    </style>
    <!-- Header Bar -->
    <nav class="navbar fixed-top" style="z-index: 1;">
        <a class="navbar-brand" href="#"><i class="fa fa-arrow-left"></i></a>
        <a class="navbar-brand" href="#">PSRA Visit App</a>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">

        </div>
    </nav>

    <div class="container">
        <div class="row">

            <div class="col-sm-12">

                <main id="main" class="container" style="height: 100vh; overflow-y: auto; padding:0px; ">
                    <div class="row">
                        <div class="col-xs-12 col-lg-offset-3 col-lg-6">
                            <div class="m-b-md text-center">
                                <h1 id="title">PSRA VISIT APP</h1>
                                <p id="description" class="description" class="text-center">
                                    <a class="btn btn-success" href="<?php echo site_url("visits/index"); ?>"><i class="fa fa-home"></i>Back To Home</a>
                                    <button class="btn btn-success"></button>
                                    <button class="btn"><i class="fa fa-trash"></i></button>
                                    <button class="btn"><i class="fa fa-close"></i></button>
                                    <button class="btn"><i class="fa fa-folder"></i></button>
                                </p>
                            </div>

                            <?php if ($school) { ?>
                                <div class="alert alert-success" role="alert">

                                    <h4 class="alert-heading">Instititute ID: <?php echo $school->schools_id; ?>

                                    </h4>
                                    <h4>
                                        <?php if ($school->registrationNumber > 0) { ?> REG. No:
                                            <?php echo $school->registrationNumber ?>
                                        <?php } else {
                                            echo '<span style="color:#721c24">Not Registered Yet!</span>';
                                        } ?>
                                    </h4>
                                    <h4><?php echo $school->schoolName; ?></h4>
                                    <small style="color: inherit;">

                                        <?php if ($school->division) {
                                            echo "Region: <strong style='color: inherit;' >" . $school->division . "</strong>";
                                        } else {
                                            echo "Region: Null";
                                        } ?>
                                        <?php if ($school->districtTitle) {
                                            echo " , District: <strong style='color: inherit;' >" . $school->districtTitle . "</strong>";
                                        } else {
                                            echo "District: Null";
                                        } ?>
                                        <?php if ($school->tehsilTitle) {
                                            echo " , Tehsil: <strong style='color: inherit;' >" . $school->tehsilTitle . "</strong>";
                                        } else {
                                            echo " , Tehsil: Null";
                                        } ?>

                                        <?php if ($school->ucTitle) {
                                            echo " , Unionconsil: <strong style='color: inherit;' >" . $school->ucTitle . "</strong>";
                                        } else {
                                            echo " , Unionconsil: Null";
                                        } ?>

                                        <?php if ($school->address) {
                                            echo " , Address:  <strong style='color: inherit;' >" . $school->address . "</strong>";
                                        } else {
                                            echo " Address: Null";
                                        } ?>
                                    </small>
                                    <small>

                                        <div class="row">
                                            <div class="col-xs-6">
                                                <strong>School Contact Details</strong>
                                                <span style="display: block;">Phone No: <strong><?php echo $school->phone_no; ?></strong></span>
                                                <span style="display: block;">Mobile No: <strong><?php echo $school->mobile_no; ?></strong></span>
                                                <span style="display: block;">Email: <strong><?php echo $school->principal_email; ?></strong></span>
                                            </div>
                                        </div>
                                    </small>
                                    <hr>

                                    <p class="mb-0" style="text-align: center;">

                                    <h4>Visit List</h4>
                                    </p>


                                </div>
                            <?php } else { ?>
                                <div class="alert alert-danger" role="alert" style="display: none;">
                                    <h4 class="alert-heading">Apologies!</h4>

                                    <p style="color: inherit;">Instititute not found.</p>
                                    <hr>
                                    <p class="mb-0">

                                    </p>
                                </div>
                            <?php } ?>

                            <ul class="list-group" style="font-size: 12px;">
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            Visit Reason
                                        </div>
                                        <div class="col-xs-4">
                                            Levels
                                        </div>
                                        <div class="col-xs-2">
                                            Session
                                        </div>
                                        <div class="col-xs-2">
                                            Visited
                                        </div>
                                    </div>
                                </li>
                                <?php
                                $count = 1;
                                $query = "SELECT * FROM visits";
                                $rows = $this->db->query($query)->result();
                                foreach ($rows as $row) {

                                    $labels = array();

                                    if ($row->primary_l == 1) {
                                        $labels[] = "Primary";
                                    }

                                    if ($row->middle_l == 1) {
                                        $labels[] = "Middle";
                                    }

                                    if ($row->high_l == 1) {
                                        $labels[] = "High";
                                    }

                                    if ($row->high_sec_l == 1) {
                                        $labels[] = "Higher Sec.";
                                    }

                                    if ($row->academy_l == 1) {
                                        $labels[] = "Academy";
                                    }




                                ?>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <?php echo $row->visit_reason; ?>
                                            </div>
                                            <div class="col-xs-4">
                                                <?php echo implode(', ', $labels);  ?>

                                            </div>
                                            <div class="col-xs-2">
                                                <?php echo $row->session; ?>
                                            </div>
                                            <div class="col-xs-2">
                                                <?php echo $row->visited; ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>

                            <script src='<?php echo base_url("assets/lib/jquery/dist/jquery.min.js"); ?>'></script>
                            <script src='<?php echo base_url("assets/lib/jquery/dist/jquery-ui.js"); ?>'></script>

                            <script>
                                // jQuery function to execute when the form is submitted
                                $('#visits').submit(function(e) {

                                    // Prevent the default form submission behavior
                                    e.preventDefault();

                                    // Serialize form data into a query string
                                    var formData = $(this).serialize();

                                    // AJAX POST request to the server
                                    $.ajax({

                                        type: 'POST',
                                        url: '<?php echo site_url("visits/get_school_by_school_id") ?>', // URL to submit form data
                                        data: formData,
                                        success: function(response) {

                                            // Check the response from the server
                                            if (response === 'success') {
                                                // If the response is 'success', reload the page
                                                location.reload();
                                            } else {
                                                // If the response is not 'success', display it in the result_response div
                                                $('#result_response').html(response);
                                                $('.alert').hide().fadeOut(function() {
                                                    $('.alert').show().fadeIn();
                                                });
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            // If there's an error with the AJAX request, display an error message
                                            console.error(xhr.responseText);
                                            $('#result_response').html('An error occurred while processing your request.');

                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>

                </main>

            </div>

        </div>
    </div>
    <footer class="footer fixed-bottom">
        <div class="container text-center">
            &copy; 2024 Your Company. All rights reserved.
        </div>
    </footer>
</body>

</html>