<?php if ($input->a == 1 and $input->b == 1 and $input->c == 1 and $input->d == 1 and $input->e == 1 and $input->f == 1 and $input->g == 1) { ?>


    <?php
    $query = "SELECT 
                 SUM(rooms) as rooms,
                 SUM(boys) as boys,
                 SUM(girls) as girls,
                 MAX(max_fee) as max_fee
                 FROM visit_details 
                 WHERE visit_id ='" . $visit_id . "'
                 AND school_id ='" . $school_id . "' 
                 AND schools_id ='" . $schools_id . "'";
    $class_summary = $this->db->query($query)->row();
    ?>
    <div class="row">

        <div class="col-xs-12">
            <h5>Visit Report Summary</h5>
            <table class="table1 table1_small">
                <tr>
                    <th>Max Fee</th>
                    <th>Fee Category</th>
                </tr>
                <tr>
                    <td><?php echo $class_summary->max_fee; ?></td>
                    <td>
                        <?php
                        if ($max_fee <= 2000) {
                            echo 'Category 1';
                        } elseif ($max_fee > 2000 && $max_fee <= 3500) {
                            echo 'Category 2';
                        } elseif ($max_fee > 3500 && $max_fee <= 6000) {
                            echo 'Category 3';
                        } elseif ($max_fee > 6000 && $max_fee <= 10000) {
                            echo 'Category 4';
                        } elseif ($max_fee > 10000 && $max_fee <= 15000) {
                            echo 'Category 5';
                        } elseif ($max_fee > 15000 && $max_fee <= 20000) {
                            echo 'Category 6';
                        } elseif ($max_fee > 20000) {
                            echo 'Category 7';
                        }
                        ?>
                    </td>
                </tr>
            </table>

            <br />

            <table class="table1 table1_small">
                <tr>
                    <td>Class Rooms</td>
                    <td><?php echo $total_class_rooms = $class_summary->rooms; ?></td>
                </tr>
                <tr>
                    <td>Staff Rooms (M)</td>
                    <td><?php echo $input->male_staff_rooms; ?></td>
                </tr>
                <tr>
                    <td>Staff Rooms (F)</td>
                    <td><?php echo $input->female_staff_rooms; ?></td>
                </tr>
                <tr>
                    <td>Principal Office</td>
                    <td><?php echo $input->principal_office; ?></td>
                </tr>
                <tr>
                    <td>Account Office</td>
                    <td><?php echo $input->account_office; ?></td>
                </tr>
                <tr>
                    <td>Reception</td>
                    <td><?php echo $input->reception; ?></td>
                </tr>
                <tr>
                    <td>Waiting Area</td>
                    <td><?php echo $input->waiting_area; ?></td>
                </tr>
            </table>
            <br />
            <table class="table1 table1_small">
                <tr>
                    <th>Washrooms</th>
                    <th>Males</th>
                    <th>Females</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>Washrooms</td>
                    <td><?php echo $input->male_washrooms; ?></td>
                    <td><?php echo $input->female_washrooms; ?></td>
                    <td><?php echo $input->male_washrooms + $input->female_washrooms; ?></td>
                </tr>
            </table>

            <br />
            <table class="table1 table1_small">
                <tr>
                    <th>Staff</th>
                    <th>Non Teaching Staff</th>
                    <th>Teaching Staff</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>Males</td>
                    <td><?php echo $input->non_teaching_male_staff; ?></td>
                    <td><?php echo $input->teaching_male_staff; ?></td>
                    <td><strong><?php echo $input->non_teaching_male_staff + $input->teaching_male_staff; ?></strong></td>
                </tr>
                <tr>
                    <td>Females</td>
                    <td><?php echo $input->non_teaching_female_staff; ?></td>
                    <td><?php echo $input->teaching_female_staff; ?></td>
                    <td><strong><?php echo $input->non_teaching_female_staff + $input->teaching_female_staff; ?></strong></td>
                </tr>

                <tr>
                    <td>Total</td>
                    <td><strong><?php echo $input->non_teaching_male_staff + $input->non_teaching_female_staff; ?></strong></td>
                    <td><strong><?php echo $input->teaching_male_staff + $input->teaching_female_staff; ?></strong></td>
                    <td><strong><?php echo $total_teachers = $input->non_teaching_male_staff + $input->non_teaching_female_staff + $input->teaching_male_staff + $input->teaching_female_staff; ?></strong></td>
                </tr>
            </table>


        </div>

        <div class="col-xs-12">
            <br />
            <table class="table1 table1_small">
                <tr>
                    <th>Subject Lab</th>
                    <th>Lab Status</th>
                    <th>Equipments</th>
                </tr>
                <?php if ($input->high_l == 1 && $input->high_sec_l == 0) { ?>
                    <tr>
                        <td>High Level</td>
                        <td><?php echo $input->high_level_lab; ?></td>
                        <td><?php echo ($input->high_level_lab == 'Yes') ? $input->high_level_lab_equipment : 'N/A'; ?></td>
                    </tr>
                <?php } ?>
                <?php if ($input->high_sec_l == 1) { ?>
                    <tr>
                        <td>Physics</td>
                        <td><?php echo $input->physics_lab; ?></td>
                        <td><?php echo ($input->physics_lab == 'Yes') ? $input->physics_lab_equipment : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td>Biology</td>
                        <td><?php echo $input->biology_lab; ?></td>
                        <td><?php echo ($input->biology_lab == 'Yes') ? $input->biology_lab_equipment : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td>Chemistry</td>
                        <td><?php echo $input->chemistry_lab; ?></td>
                        <td><?php echo ($input->chemistry_lab == 'Yes') ? $input->chemistry_lab_equipment : 'N/A'; ?></td>
                    </tr>
                <?php } ?>
            </table>

            <br />
            <table class="table1 table1_small">
                <tr>

                    <td>Computer Lab</td>
                    <td><?php echo $input->computer_lab; ?></td>
                </tr>
                <?php if ($input->computer_lab == 'Yes') { ?>
                    <tr>
                        <td>Total Working Computers</td>
                        <td><?php echo $input->total_working_computers; ?></td>
                    </tr>
                    <tr>
                        <td>Total Not Working Computers</td>
                        <td><?php echo $input->total_not_working_computers; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>Library</td>
                    <td><?php echo $input->library; ?></td>
                </tr>
                <?php if ($input->library == 'Yes') { ?>
                    <tr>
                        <td>Library Books Total</td>
                        <td><?php echo $input->library_books; ?></td>
                    </tr>
                <?php } ?>
            </table>
            <br />
            <table class="table1 table1_small">
                <tr>
                    <th>Student Teacher Radio</th>
                    <td><?php
                        $total_students = $class_summary->boys + $class_summary->girls;
                        echo round($total_students / $total_teachers, 1); ?></td>
                </tr>
                <tr>
                    <th>Student Class Rooms Radio</th>
                    <td><?php echo round($total_students / $total_class_rooms, 1); ?></td>
                </tr>
            </table>
            <br />
            <table class="table1 table1_small">
                <tr>
                    <th>Boys</th>
                    <th>Girls</th>
                    <th>Total Students</th>
                </tr>
                <tr>

                    <td><?php echo $class_summary->boys; ?></td>
                    <td><?php echo $class_summary->girls; ?></td>
                    <td><?php echo $total_students = $class_summary->boys + $class_summary->girls; ?></td>
                </tr>
            </table>

        </div>

    </div>
    <form id="visits" class="form-horizontal" enctype="multipart/form-data" method="post">
        <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
        <input type="hidden" name="form" value="h" />
        <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
        <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />

        <div class="row">
            <div class="col-xs-12">
                <h4>Finalised Visit Report</h4>
            </div>

            <div class="col-xs-12">
                <div class="form-group">
                    <label for="visited_by_officers" class="col-xs-4 col-form-label">Visited By Officers</label>
                    <div class="col-xs-8">
                        <input type="text" required id="visited_by_officers" name="visited_by_officers" value="<?php echo $input->visited_by_officers; ?>" class="form-control">
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="form-group">
                    <label for="visited_by_officials" class="col-xs-4 col-form-label">Visited By Officials</label>
                    <div class="col-xs-8">
                        <input type="text" required id="visited_by_officials" name="visited_by_officials" value="<?php echo $input->visited_by_officials; ?>" class="form-control">
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="form-group">
                    <label for="visit_date" class="col-xs-4 col-form-label">Visit Date</label>
                    <div class="col-xs-8">
                        <input type="date" required id="visit_date" name="visit_date" value="<?php echo $input->visit_date; ?>" class="form-control">
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

            <div class="col-xs-12" id="recommendation_levels_div" <?php if ($input->recommendation != 'Recommended') { ?>style="display: none;" <?php } ?>>
                <div class="form-group">
                    <label for="recommended_levels" class="col-xs-12 col-form-label">Recommended Levels <span class="required">*</span></label>
                    <div class="col-xs-12">
                        <?php if ($school->school_type_id == 1) { ?>
                            <?php if ($input->primary_l == 1) { ?>
                                <input <?php if ($input->r_primary_l == 1) {
                                            echo 'checked';
                                        } ?> type="checkbox" name="r_primary_l" value="1" /> Primary
                                <span style="margin-left: 5px"></span>
                            <?php } ?>
                            <?php if ($input->middle_l == 1) { ?>

                                <input <?php if ($input->r_middle_l == 1) {
                                            echo 'checked';
                                        } ?> type="checkbox" name="r_middle_l" value="1" /> Middle
                                <span style="margin-left: 5px"></span>
                            <?php } ?>
                            <?php if ($input->high_l == 1) { ?>
                                <input <?php if ($input->r_high_l == 1) {
                                            echo 'checked';
                                        } ?> type="checkbox" name="r_high_l" value="1" /> High
                                <span style="margin-left: 5px"></span>
                            <?php } ?>
                            <?php if ($input->high_sec_l == 1) { ?>
                                <input <?php if ($input->r_high_sec_l == 1) {
                                            echo 'checked';
                                        } ?> type="checkbox" name="r_high_sec_l" value="1" /> Higher Sec.
                                <span style="margin-left: 5px"></span>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($school->school_type_id == 7) { ?>
                            <?php if ($input->academy_l == 1) { ?>
                                <input <?php if ($input->r_academy_l == 1) {
                                            echo 'checked';
                                        } ?> type="checkbox" name="r_academy_l" value="1" /> Academy
                                <span style="margin-left: 5px"></span>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-xs-12" id="not_recommendation_remarks_div" <?php if ($input->recommendation != 'Not Recommended') { ?>style="display: none;" <?php } ?>>
                <div class="form-group">
                    <label for="not_recommendation_remarks" class="col-xs-12 col-form-label">Not Recommendation Remarks</label>
                    <div class="col-xs-12">
                        <textarea id="not_recommendation_remarks" name="not_recommendation_remarks" class="form-control"><?php echo $input->not_recommendation_remarks; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="col-xs-12" style="margin-top: 5px;">
                <div class="form-group">
                    <label for="other_remarks" class="col-xs-12 col-form-label">Any additional remarks?</label>
                    <div class="col-xs-12">
                        <textarea id="other_remarks" name="other_remarks" class="form-control"><?php echo $input->other_remarks; ?></textarea>
                    </div>
                </div>
            </div>

            <input name="report_location_latitude" id="report_location_latitude" type="hidden" value="" />
            <input name="report_location_longitude" id="report_location_longitude" type="hidden" value="" />
            <input name="report_location_altitude" id="report_location_altitude" type="hidden" value="" />

            <div class="col-xs-12" style="margin-top: 15px;">

                <p style="color: white;">Note: Kindly confirm that you have checked the agreement box before submitting the final report. Once submitted, changes to the visit report cannot be made.</p>
                <input type="checkbox" value="1" name="agree" /> I agree to submit this final report.

            </div>

            <div class="col-xs-12" style="margin-top:15px; margin-bottom: 40px;">
                <div id="result_response"></div>
                <div class="text-center">
                    <div class="col-xs-5">
                        <a class="btn btn-small" href='<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/g"); ?>'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                    </div>
                    <div class="col-xs-7">
                        <button class="btn btn-small" type="submit" name="submitButton" value="same">Submit (Final Report)</button>
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
                url: '<?php echo site_url("visit_app/add_visit_report"); ?>', // URL to submit form data
                data: formData,
                success: function(response) {
                    // Display response
                    if (response == 'success') {
                        switch (submitButtonValue) {
                            case "same":
                                location.reload();
                                break;
                            case "next":
                                window.location.href = "<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/g"); ?>";
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
<?php } else { ?>
    <div class="row">
        <div class="col-xs-12">
            <ul class="list-group">
                <li class="list-group-item <?php echo ($input->a == 1) ? 'list-group-item-success' : 'list-group-item-danger'; ?>">
                    1. Form A <?php echo ($input->a == 1) ? 'Completed' : 'Not Complete'; ?>
                </li>
                <li class="list-group-item <?php echo ($input->b == 1) ? 'list-group-item-success' : 'list-group-item-danger'; ?>">
                    2. Form B <?php echo ($input->b == 1) ? 'Completed' : 'Not Complete'; ?>
                </li>
                <li class="list-group-item <?php echo ($input->c == 1) ? 'list-group-item-success' : 'list-group-item-danger'; ?>">
                    3. Form C <?php echo ($input->c == 1) ? 'Completed' : 'Not Complete'; ?>
                </li>
                <li class="list-group-item <?php echo ($input->d == 1) ? 'list-group-item-success' : 'list-group-item-danger'; ?>">
                    4. Form D <?php echo ($input->d == 1) ? 'Completed' : 'Not Complete'; ?>
                </li>
                <li class="list-group-item <?php echo ($input->e == 1) ? 'list-group-item-success' : 'list-group-item-danger'; ?>">
                    5. Form E <?php echo ($input->e == 1) ? 'Completed' : 'Not Complete'; ?>
                </li>
                <li class="list-group-item <?php echo ($input->f == 1) ? 'list-group-item-success' : 'list-group-item-danger'; ?>">
                    6. Form F <?php echo ($input->f == 1) ? 'Completed' : 'Not Complete'; ?>
                </li>
                <li class="list-group-item <?php echo ($input->g == 1) ? 'list-group-item-success' : 'list-group-item-danger'; ?>">
                    7. Form G <?php echo ($input->g == 1) ? 'Completed' : 'Not Complete'; ?>
                </li>
                <li class="list-group-item <?php echo ($input->h == 1) ? 'list-group-item-success' : 'list-group-item-danger'; ?>">
                    8. Form H <?php echo ($input->h == 1) ? 'Completed' : 'Not Complete'; ?>
                </li>
                <!-- Add similar list items for forms D to H -->
            </ul>
        </div>
    </div>
<?php } ?>