<form id="visits" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
    <input type="hidden" name="form" value="h" />
    <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
    <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
    <input type="hidden" required id="visited_by_officials" name="visited_by_officials" value="NULL" class="form-control">
    <input type="hidden" required id="visited_by_officers" name="visited_by_officers" value="NULL" class="form-control">

    <div class="row">


        <div class="col-xs-12">
            <div class="form-group">
                <label for="visit_date" class="col-xs-4 col-form-label">Visit Date</label>
                <div class="col-xs-8">
                    <input type="date" required id="visit_date" name="visit_date" value="<?php echo date('Y-m-d'); ?>" class="form-control" />
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="form-group">
                <label for="recommendation" class="col-xs-6 col-form-label">Recommendation</label>
                <div class="col-xs-6">
                    <?php
                    $options = array("Recommended", "Not Recommended");
                    foreach ($options as $option) {
                        $checked = ($option == $input->recommendation) ? "checked" : "";
                    ?>
                        <input <?php if ($option == 'Recommended') { ?> onclick="$('#recommendation_levels_div').show();$('#not_recommendation_remarks_div').hide();$('#not_recommendation_remarks').prop('required', false);" <?php } else { ?> onclick="$('#recommendation_levels_div').hide();$('#not_recommendation_remarks_div').show();$('#not_recommendation_remarks').prop('required', true);" <?php } ?> required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="recommendation" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:10px"><?php echo $option; ?></span><br />
                    <?php } ?>
                </div>
            </div>
        </div>



        <div class="col-xs-12" style="margin-top:15px; margin-bottom: 40px;">
            <div id="result_response"></div>
            <div class="text-center">
                <div class="col-xs-12">
                    <button class="btn btn-small" type="submit" name="submitButton" value="same">Submit</button>
                </div>
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
            url: '<?php echo site_url("visits/marked_as_visited"); ?>', // URL to submit form data
            data: formData,
            success: function(response) {
                // Display response
                if (response == 'success') {
                    location.reload();
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
        $('#report_location_latitude').val(latitude);
        $('#report_location_longitude').val(longitude);
        $('#report_location_altitude').val(parseInt(altitude));
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
    window.onload = getLocation();
</script>