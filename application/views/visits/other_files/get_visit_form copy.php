<form id="visits" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label for="latitude" class="col-sm-6 col-form-label">Latitude</label>
                <div class="col-sm-6">
                    <input type="text" required id="latitude" name="latitude" value="<?php echo $input->latitude; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="longitude" class="col-sm-6 col-form-label">Longitude</label>
                <div class="col-sm-6">
                    <input type="text" required id="longitude" name="longitude" value="<?php echo $input->longitude; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="altitude" class="col-sm-6 col-form-label">Altitude</label>
                <div class="col-sm-6">
                    <input type="text" required id="altitude" name="altitude" value="<?php echo $input->altitude; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="precision" class="col-sm-6 col-form-label">Precision</label>
                <div class="col-sm-6">
                    <input type="text" required id="precision" name="precision" value="<?php echo $input->precision; ?>" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <label for="non_teaching_male_staff" class="col-sm-6 col-form-label">Non Teaching Male Staff</label>
                <div class="col-sm-6">
                    <input type="number" required id="non_teaching_male_staff" name="non_teaching_male_staff" value="<?php echo $input->non_teaching_male_staff; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="non_teaching_female_staff" class="col-sm-6 col-form-label">Non Teaching Female Staff</label>
                <div class="col-sm-6">
                    <input type="number" required id="non_teaching_female_staff" name="non_teaching_female_staff" value="<?php echo $input->non_teaching_female_staff; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="teaching_male_staff" class="col-sm-6 col-form-label">Teaching Male Staff</label>
                <div class="col-sm-6">
                    <input type="text" required id="teaching_male_staff" name="teaching_male_staff" value="<?php echo $input->teaching_male_staff; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="teaching_female_staff" class="col-sm-6 col-form-label">Teaching Female Staff</label>
                <div class="col-sm-6">
                    <input type="text" required id="teaching_female_staff" name="teaching_female_staff" value="<?php echo $input->teaching_female_staff; ?>" class="form-control">
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">

            <div class="form-group row">
                <label for="total_class_rooms" class="col-sm-6 col-form-label">Total Class Rooms</label>
                <div class="col-sm-6">
                    <input type="text" required id="total_class_rooms" name="total_class_rooms" value="<?php echo $input->total_class_rooms; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="avg_class_rooms_size" class="col-sm-6 col-form-label">Avg Class Rooms Size</label>
                <div class="col-sm-6">
                    <input type="text" required id="avg_class_rooms_size" name="avg_class_rooms_size" value="<?php echo $input->avg_class_rooms_size; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="male_staff_rooms" class="col-sm-6 col-form-label">Male Staff Rooms</label>
                <div class="col-sm-6">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->male_staff_rooms) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="male_staff_rooms" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="female_staff_rooms" class="col-sm-6 col-form-label">Female Staff Rooms</label>
                <div class="col-sm-6">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->female_staff_rooms) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="female_staff_rooms" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="principal_office" class="col-sm-6 col-form-label">Principal Office</label>
                <div class="col-sm-6">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->principal_office) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="principal_office" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="account_office" class="col-sm-6 col-form-label">Account Office</label>
                <div class="col-sm-6">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->account_office) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="account_office" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="reception_waiting_area" class="col-sm-6 col-form-label">Reception Waiting Area</label>
                <div class="col-sm-6">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->reception_waiting_area) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="reception_waiting_area" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="male_washrooms" class="col-sm-6 col-form-label">Male Washrooms</label>
                <div class="col-sm-6">
                    <input type="text" required id="male_washrooms" name="male_washrooms" value="<?php echo $input->male_washrooms; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="female_washrooms" class="col-sm-6 col-form-label">Female Washrooms</label>
                <div class="col-sm-6">
                    <input type="text" required id="female_washrooms" name="female_washrooms" value="<?php echo $input->female_washrooms; ?>" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <label for="total_male_students" class="col-sm-6 col-form-label">Total Male Students</label>
                <div class="col-sm-6">
                    <input type="text" required id="total_male_students" name="total_male_students" value="<?php echo $input->total_male_students; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="total_female_students" class="col-sm-6 col-form-label">Total Female Students</label>
                <div class="col-sm-6">
                    <input type="text" required id="total_female_students" name="total_female_students" value="<?php echo $input->total_female_students; ?>" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <label for="high_level_lab" class="col-sm-6 col-form-label">High Level Lab</label>
                <div class="col-sm-6">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->high_level_lab) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php if ($option == 'Yes') { ?> onclick="$('#high_level_lab_div').show();$('.high_level_lab_equipment').prop('required', true);" <?php } ?> <?php if ($option == 'No') { ?> onclick="$('#high_level_lab_div').hide();$('.high_level_lab_equipment').prop('required', false);$('.high_level_lab_equipment').prop('checked', false);" <?php } ?> <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="high_level_lab" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row" id="high_level_lab_div" <?php if ($input->high_level_lab == 'No') { ?>style="display: none;" <?php } ?>>
                <label for="high_level_lab_equipment" class="col-sm-6 col-form-label">High Level Lab Equipment</label>
                <div class="col-sm-6">
                    <?php
                    $options = array("Sufficient", "Deficient");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->high_level_lab_equipment and $input->high_level_lab == 'Yes') {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="high_level_lab_equipment" value="<?php echo $option; ?>" class="high_level_lab_equipment">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="physics_lab" class="col-sm-6 col-form-label">Physics Lab</label>
                <div class="col-sm-6">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->physics_lab) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php if ($option == 'Yes') { ?> onclick="$('#physics_lab_equipment_div').show();$('.physics_lab_equipment').prop('required', true);" <?php } ?> <?php if ($option == 'No') { ?> onclick="$('#physics_lab_equipment_div').hide();$('.physics_lab_equipment').prop('required', false);$('.physics_lab_equipment').prop('checked', false);" <?php } ?> <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="physics_lab" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row" id="physics_lab_equipment_div" <?php if ($input->physics_lab == 'No') { ?>style="display: none;" <?php } ?>>
                <label for="physics_lab_equipment" class="col-sm-6 col-form-label">Physics Lab Equipment</label>
                <div class="col-sm-6">
                    <?php
                    $options = array("Sufficient", "Deficient");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->physics_lab_equipment  and $input->physics_lab == 'Yes') {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="physics_lab_equipment" value="<?php echo $option; ?>" class="physics_lab_equipment">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="biology_lab" class="col-sm-6 col-form-label">Biology Lab</label>
                <div class="col-sm-6">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->biology_lab) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="biology_lab" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="biology_lab_equipment" class="col-sm-6 col-form-label">Biology Lab Equipment</label>
                <div class="col-sm-6">
                    <?php
                    $options = array("Sufficient", "Deficient");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->biology_lab_equipment) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="biology_lab_equipment" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="chemistry_lab" class="col-sm-6 col-form-label">Chemistry Lab</label>
                <div class="col-sm-6">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->chemistry_lab) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="chemistry_lab" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="chemistry_lab_equipment" class="col-sm-6 col-form-label">Chemistry Lab Equipment</label>
                <div class="col-sm-6">
                    <?php
                    $options = array("Sufficient", "Deficient");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->chemistry_lab_equipment) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="chemistry_lab_equipment" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="computer_lab" class="col-sm-6 col-form-label">Computer Lab</label>
                <div class="col-sm-6">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->computer_lab) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="computer_lab" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="total_working_computers" class="col-sm-6 col-form-label">Total Working Computers</label>
                <div class="col-sm-6">
                    <input type="text" required id="total_working_computers" name="total_working_computers" value="<?php echo $input->total_working_computers; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="total_non_working_computers" class="col-sm-6 col-form-label">Total Non Working Computers</label>
                <div class="col-sm-6">
                    <input type="number" required id="total_non_working_computers" name="total_non_working_computers" value="<?php echo $input->total_non_working_computers; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="library" class="col-sm-6 col-form-label">Library</label>
                <div class="col-sm-6">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->library) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="library" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="library_books" class="col-sm-6 col-form-label">Library Books</label>
                <div class="col-sm-6">
                    <input type="text" required id="library_books" name="library_books" value="<?php echo $input->library_books; ?>" class="form-control">
                </div>
            </div>
        </div>
    </div>





    <div class="form-group row">
        <label for="visited_by_officers" class="col-sm-6 col-form-label">Visited By Officers</label>
        <div class="col-sm-6">
            <input type="text" required id="visited_by_officers" name="visited_by_officers" value="<?php echo $input->visited_by_officers; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="visited_by_officials" class="col-sm-6 col-form-label">Visited By Officials</label>
        <div class="col-sm-6">
            <input type="text" required id="visited_by_officials" name="visited_by_officials" value="<?php echo $input->visited_by_officials; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="visit_date" class="col-sm-6 col-form-label">Visit Date</label>
        <div class="col-sm-6">
            <input type="date" required id="visit_date" name="visit_date" value="<?php echo $input->visit_date; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="recommendation" class="col-sm-6 col-form-label">Recommendation</label>
        <div class="col-sm-6">
            <input type="text" required id="recommendation" name="recommendation" value="<?php echo $input->recommendation; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="remarks" class="col-sm-6 col-form-label">Remarks</label>
        <div class="col-sm-6">
            <input type="text" required id="remarks" name="remarks" value="<?php echo $input->remarks; ?>" class="form-control">
        </div>
    </div>

    <div class="form-group row" style="text-align:center">
        <div id="result_response"></div>
        <?php if ($input->visit_id == 0) { ?>
            <button type="submit" class="btn btn-primary">Add Visit Report</button>
        <?php } else { ?>
            <button type="submit" class="btn btn-primary">Update Visit Report</button>
        <?php } ?>
    </div>
</form>
</div>

<script>
    $('#visits').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("visits/add_visit"); ?>', // URL to submit form data
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
</script>