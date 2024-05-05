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
</head>
<style>

</style>

<body>



    <div class="container">
        <div class="row">

            <div class="col-sm-12">

                <main id="main" class="container">
                    <div class="row">
                        <div class="col-xs-12 col-lg-offset-3 col-lg-6">
                            <div class="m-b-md text-center">
                                <h1 id="title">PSRA VISIT APP</h1>
                                <img src=" https://psra.gkp.pk/institute/assets/admin/img/psra_log.png" class="menuLogo" style="vertical-align: middle;
    width: 100px;
    background-color: white;
    border-radius: 50px;
    padding: 10px;
    height: 100px;" />
                                <p id="description" class="description" style="color: white;" class="text-center">Private Schools Regulatory Authority</p>
                            </div>

                            <form id="visits" name="survey-form">
                                <fieldset>
                                    <label for="institute_id" id="institute_id_lable">
                                        Institute ID *
                                        <input required class="" type="number" id="institute_id" name="institute_id" placeholder="Enter Instititute ID" required />
                                    </label>
                                </fieldset>
                                <button id="submit" type="submit" class="btn">Search Institute</button>
                            </form>
                            <div id="result_response" style="padding-top: 10px;">

                            </div>
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
                                        url: '<?php echo site_url("visit_app/get_school_by_school_id") ?>', // URL to submit form data
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

</body>

</html>