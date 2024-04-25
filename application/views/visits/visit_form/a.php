<?php if (!$input->picture_1) { ?>
    <form id="visits" class="form-horizontal" enctype="multipart/form-data" method="post">
        <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
        <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
        <input type="hidden" name="form" value="picture_file" />
        <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
        <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
        <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
        <div class="alert alert-danger">
            <h5><i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: #AA4644;"></i> Required Photo Documentation for Official Visits</h5>
            Please take a picture of the institute board with both the assigned official and officer there. This photo will prove they were personally present during the visit and will be added to the visit report.
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="visited_by_officers" class="col-form-label">Take Picture or Upload an Image <span class="required">*</span></label>
                    </div>
                    <div class="col-xs-6">
                        <input name="picture_1" id="picture_1" type="file" accept="image/*" capture="camera" class="form-control" placeholder="Take Picture" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <div class="col-xs-4">
                                <label for="latitude" class="col-form-label">Latitude <span class="required">*</span></label>
                            </div>
                            <div class="col-sm-8">
                                <input type="number" step="any" required id="latitude" name="latitude" value="<?php echo $input->latitude; ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <div class="col-xs-4">
                                <label for="longitude" class="col-form-label">Longitude <span class="required">*</span></label>
                            </div>
                            <div class="col-sm-8">
                                <input type="number" step="any" required id="longitude" name="longitude" value="<?php echo $input->longitude; ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <div class="col-xs-4">
                                <label for="altitude" class="col-form-label">Altitude <span class="required">*</span></label>
                            </div>
                            <div class="col-sm-8">
                                <input type="number" min="0" step="any" id="altitude" name="altitude" value="<?php echo $input->altitude; ?>" class="form-control">
                                <input type="hidden" required id="precision" name="precision" value="0" class="form-control">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="block_div" style="margin-bottom: 35px;">
                <div class="row">
                    <div id="result_response"></div>
                    <div class="col-xs-12" style="text-align: center;">
                        <button class="btn btn-small" type="submit" name="submitButton" value="same">Upload Photo <i class="fa fa-upload" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        $('#visits').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this); // Create FormData object
            var submitButtonValue = $(document.activeElement).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url("visits/add_visit_report"); ?>', // URL to submit form data
                data: formData,
                contentType: false, // Not to set any content type header
                processData: false, // Not to process data
                success: function(response) {
                    // Display response
                    if (response == 'success') {
                        switch (submitButtonValue) {
                            case "same":
                                location.reload();
                                break;
                            case "next":
                                window.location.href = "<?php echo site_url("visits/institute_visit_report/$visit_id/$schools_id/$school_id/f"); ?>";
                                break;
                            default:
                                alert("Unknown button clicked");
                        }
                    } else {
                        $('#result_response').html(response);
                    }
                }
            });
        });


        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                $('#result_response').html("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            var altitude = position.coords.altitude || "Not available";
            $('#latitude').val(latitude);
            $('#longitude').val(longitude);
            $('#altitude').val(parseInt(altitude));
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    $('#result_response').html("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    $('#result_response').html("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    $('#result_response').html("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    $('#result_response').html("An unknown error occurred.");
                    break;
            }
        }



        // Call getLocation() when the page loads to prompt for permission
        window.onload = getLocation();
    </script>
<?php } else { ?>
    <div class="row">
        <div class="col-xs-12">
            <img style="width: auto; height:100px" src="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $input->picture_1; ?>" width="100%" />
        </div>
    </div>
    <form id="visits" class="form-horizontal" enctype="multipart/form-data" method="post">
        <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
        <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
        <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
        <input type="hidden" name="form" value="<?php echo $form; ?>" />
        <div class="block_div">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label for="visit_for_level" class="col-form-label">Visit For Levels <span class="required">*</span></label>
                        </div>
                        <div class="col-sm-12">
                            <?php if ($school->school_type_id == 1) { ?>
                                <input <?php if ($input->primary_l == 1) {
                                            echo 'checked';
                                        } ?> type="checkbox" name="primary_l" value="1" /> Primary
                                <span style="margin-left: 5px"></span>
                                <input <?php if ($input->middle_l == 1) {
                                            echo 'checked';
                                        } ?> type="checkbox" name="middle_l" value="1" /> Middle
                                <span style="margin-left: 5px"></span>
                                <input <?php if ($input->high_l == 1) {
                                            echo 'checked';
                                        } ?> type="checkbox" name="high_l" value="1" /> High
                                <span style="margin-left: 5px"></span>
                                <input <?php if ($input->high_sec_l == 1) {
                                            echo 'checked';
                                        } ?> type="checkbox" name="high_sec_l" value="1" /> Higher Sec.
                                <span style="margin-left: 5px"></span>
                            <?php } ?>
                            <?php if ($school->school_type_id == 7) { ?>
                                <input <?php if ($input->academy_l == 1) {
                                            echo 'checked';
                                        } ?> type="checkbox" name="academy_l" value="1" /> Academy
                                <span style="margin-left: 5px"></span>
                            <?php } ?>



                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="block_div">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-xs-3">
                            <label for="rent_aggrement_date" class="col-form-label">Co Edu. <span class="required">*</span></label>
                        </div>
                        <div class="col-xs-9">
                            <?php
                            $options = array("Boys", "Girls", "Co-Edu");
                            foreach ($options as $option) {
                                $checked = "";
                                if ($option == $input->gender_of_edu) {
                                    $checked = "checked";
                                }

                            ?>
                                <span style="margin-left:1px"></span>
                                <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="gender_of_edu" value="<?php echo $option; ?>" class="">
                                <?php echo $option;  ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-xs-3">
                            <label for="timing" class="col-form-label">Timing <span class="required">*</span></label>
                        </div>
                        <div class="col-xs-9">
                            <?php
                            $options = array("Morning", "Evening", "Both");
                            foreach ($options as $option) {
                                $checked = "";
                                if ($option == $input->timing) {
                                    $checked = "checked";
                                }

                            ?>
                                <span style="margin-left:5px"></span>
                                <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="timing" value="<?php echo $option; ?>" class="">
                                <span style="margin-left:3px"></span> <?php echo $option;  ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="col-xs-3">
                            <label for="o_a_levels" class="col-form-label">O-A levels <span class="required">*</span></label>
                        </div>
                        <div class="col-xs-9">
                            <?php
                            $options = array("Yes", "No");
                            foreach ($options as $option) {
                                $checked = "";
                                if ($option == $input->o_a_levels) {
                                    $checked = "checked";
                                }

                            ?>
                                <span style="margin-left:5px"></span>
                                <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="o_a_levels" value="<?php echo $option; ?>" class="">
                                <span style="margin-left:3px"></span> <?php echo $option;  ?>
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-xs-3">
                            <label for="land_type" class="col-form-label">Land Type <span class="required">*</span></label>
                        </div>
                        <div class="col-xs-9">
                            <?php
                            $options = array("Commercial", "Residential");
                            foreach ($options as $option) {
                                $checked = "";
                                if ($option == $input->land_type) {
                                    $checked = "checked";
                                }

                            ?>
                                <span style="margin-left:5px"></span>
                                <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="land_type" value="<?php echo $option; ?>" class="">
                                <span style="margin-left:3px"></span> <?php echo $option;  ?>
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-xs-3">
                            <label for="property_posession" class="col-form-label">Property <span class="required">*</span></label>
                        </div>
                        <div class="col-xs-9">
                            <?php
                            $options = array("Owned", "Donated", "Rented");
                            foreach ($options as $option) {
                                $checked = "";
                                if ($option == $input->property_posession) {
                                    $checked = "checked";
                                }

                            ?>
                                <span style="margin-left:5px"></span>
                                <input <?php if ($option == 'Rented') { ?> onclick="show_hide_rent_amount()" <?php } else { ?> onclick="hide_rent_amount()" <?php } ?>required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="property_posession" value="<?php echo $option; ?>" class="">
                                <span style="margin-left:3px"></span> <?php echo $option;  ?>
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <script>
                    function show_hide_rent_amount() {
                        var radio = document.getElementById('Rented');
                        var rentAmountInput = document.getElementById('rent_amount');
                        var rentAmountDiv = document.getElementById('rent_amount_div');

                        if (radio.checked) {
                            // Show the rent_amount_div
                            rentAmountDiv.style.display = 'block';
                            // Set the required attribute on the rent_amount input field
                            rentAmountInput.required = true;
                        } else {
                            // Hide the rent_amount_div
                            rentAmountDiv.style.display = 'none';
                            // Remove the required attribute from the rent_amount input field
                            rentAmountInput.removeAttribute('required');
                        }
                    }

                    function hide_rent_amount() {
                        var radio = document.getElementById('Rented');
                        var rentAmountInput = document.getElementById('rent_amount');
                        var rentAmountDiv = document.getElementById('rent_amount_div');
                        rentAmountDiv.style.display = 'none';
                        // Set the required attribute on the rent_amount input field
                        rentAmountInput.required = false;

                    }
                </script>
                <div id="rent_amount_div" <?php if ($input->property_posession != 'Rented') { ?> style="display: none;" <?php } ?>>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="col-xs-4">
                                <label for="rent_amount" class="col-form-label">Rent Amount <span class="required">*</span></label>
                            </div>
                            <div class="col-sm-8">
                                <input <?php if ($input->property_posession == 'Rented') { ?> required <?php } ?> type="number" step="any" id="rent_amount" name="rent_amount" value="<?php echo $input->rent_amount; ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>



        <div class="block_div">
            <div class="row">

                <div class="col-xs-4">
                    <div class="form-group">
                        <div class="col-xs-4">
                            <label for="latitude" class="col-form-label">Latitude <span class="required">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" step="any" required id="latitude" name="latitude" value="<?php echo $input->latitude; ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="form-group">
                        <div class="col-xs-4">
                            <label for="longitude" class="col-form-label">Longitude <span class="required">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" step="any" required id="longitude" name="longitude" value="<?php echo $input->longitude; ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="form-group">
                        <div class="col-xs-4">
                            <label for="altitude" class="col-form-label">Altitude <span class="required">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" min="0" step="any" required id="altitude" name="altitude" value="<?php echo $input->altitude; ?>" class="form-control">
                            <input type="hidden" required id="precision" name="precision" value="0" class="form-control">

                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <div class="col-xs-6">
                            <label for="total_area" class="col-form-label">Total Area (Marlas)<span class="required">*</span></label>
                        </div>
                        <div class="col-sm-6">
                            <input type="number" step="any" required id="total_area" name="total_area" value="<?php echo $input->total_area; ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <div class="col-xs-7">
                            <label for="covered_area" class="col-form-label">Covered Area (Marlas)<span class="required">*</span></label>
                        </div>
                        <div class="col-sm-5">
                            <input type="number" step="any" required id="covered_area" name="covered_area" value="<?php echo $input->covered_area; ?>" class="form-control">
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="block_div" style="margin-bottom: 35px;">
            <div class="row">
                <div id="result_response"></div>

                <div class="col-xs-6" style="text-align: center;">
                    <button class="btn btn-small" type="submit" name="submitButton" value="same">Save Form A</button>
                </div>

                <div class="col-xs-6" style="text-align: center;">
                    <button class="btn btn-small" type="submit" name="submitButton" value="next">Save & Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>

            </div>
        </div>


    </form>


    <script>
        $('#visits').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var submitButtonValue = $(document.activeElement).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url("visits/add_visit_report"); ?>', // URL to submit form data
                data: formData,
                success: function(response) {
                    // Display response
                    if (response == 'success') {
                        switch (submitButtonValue) {
                            case "same":
                                location.reload();
                                break;
                            case "next":
                                window.location.href = "<?php echo site_url("visits/institute_visit_report/$visit_id/$schools_id/$school_id/b"); ?>";
                                break;
                            default:
                                alert("Unknown button clicked");
                        }


                    } else {
                        $('#result_response').html(response);

                    }

                }
            });
        });
    </script>
<?php } ?>