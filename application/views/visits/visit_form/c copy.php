<form id="visits" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />




    <div class="block_div">
        <div class="row">

            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="male_staff_rooms" class="col-form-label">Staff Rooms (M)</label>
                    </div>
                </div>
                <div class="col-xs-5">
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
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="female_staff_rooms" class="col-form-label">Staff Rooms (F)</label>
                    </div>
                </div>
                <div class="col-xs-5">
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
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="principal_office" class="col-form-label">Principal Office</label>
                    </div>
                </div>
                <div class="col-xs-5">
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
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="account_office" class="col-form-label">Account Office</label>
                    </div>
                </div>
                <div class="col-xs-5">
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

            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="reception" class="col-form-label">Reception</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->reception) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="reception" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="waiting_area" class="col-form-label">Waiting Area</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->waiting_area) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="waiting_area" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="male_washrooms" class="col-form-label">Washrooms (M)</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <input type="text" required id="male_washrooms" name="male_washrooms" value="<?php echo $input->male_washrooms; ?>" class="form-control">
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="female_washrooms" class="col-form-label">Washrooms (F)</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <input type="text" required id="female_washrooms" name="female_washrooms" value="<?php echo $input->female_washrooms; ?>" class="form-control">
                </div>
            </div>



            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="non_teaching_male_staff" class="col-form-label">Non Teaching Staff (M)</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <input type="number" required id="non_teaching_male_staff" name="non_teaching_male_staff" value="<?php echo $input->non_teaching_male_staff; ?>" class="form-control">
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="non_teaching_female_staff" class="col-form-label">Non Teaching Staff (F)</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <input type="number" required id="non_teaching_female_staff" name="non_teaching_female_staff" value="<?php echo $input->non_teaching_female_staff; ?>" class="form-control">
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="teaching_male_staff" class="col-form-label">Teaching Staff (M)</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <input type="text" required id="teaching_male_staff" name="teaching_male_staff" value="<?php echo $input->teaching_male_staff; ?>" class="form-control">
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="teaching_female_staff" class="col-form-label">Teaching Staff (F)</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <input type="text" required id="teaching_female_staff" name="teaching_female_staff" value="<?php echo $input->teaching_female_staff; ?>" class="form-control">
                </div>
            </div>


            <?php if ($input->high_l == 1 and $input->high_sec_l == 0) { ?>
                <div class="col-xs-12">
                    <div class="col-xs-7">
                        <div class="form-group">
                            <label for="high_level_lab" class="col-form-label">High Level Lab</label>
                        </div>
                    </div>
                    <div class="col-xs-7">
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
                <div class="col-xs-12" id="high_level_lab_div" <?php if ($input->high_level_lab == 'No') { ?>style="display: none;" <?php } ?>>
                    <div class="col-xs-7">
                        <div class="form-group">
                            <label for="high_level_lab_equipment" class="col-form-label">High Level Lab Equipments</label>
                        </div>
                    </div>
                    <div class="col-xs-5">
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
            <?php } ?>

            <?php if ($input->high_sec_l == 1) { ?>
                <div class="col-xs-12">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="physics_lab" class="col-form-label">Physics Lab</label>
                        </div>
                    </div>
                    <div class="col-xs-8">
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
                <div class="col-xs-12" id="physics_lab_equipment_div" <?php if ($input->physics_lab == 'No') { ?>style="display: none;" <?php } ?>>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="physics_lab_equipment" class="col-form-label">Phy. Lab Equipments</label>
                        </div>
                    </div>
                    <div class="col-xs-8">
                        <?php
                        $options = array("Sufficient", "Deficient");
                        foreach ($options as $option) {
                            $checked = "";
                            if ($option == $input->physics_lab_equipment  and $input->physics_lab == 'Yes') {
                                $checked = "checked";
                            }

                        ?>
                            <span style="margin-left:5px"></span>
                            <input <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="physics_lab_equipment" value="<?php echo $option; ?>" class="physics_lab_equipment">
                            <span style="margin-left:3px"></span> <?php echo $option;  ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="biology_lab" class="col-form-label">Biology Lab</label>
                        </div>
                    </div>
                    <div class="col-xs-8">
                        <?php
                        $options = array("Yes", "No");
                        foreach ($options as $option) {
                            $checked = "";
                            if ($option == $input->biology_lab) {
                                $checked = "checked";
                            }

                        ?>
                            <span style="margin-left:5px"></span>
                            <input <?php if ($option == 'Yes') { ?> onclick="$('#biology_lab_equipment_div').show();$('.biology_lab_equipment').prop('required', true);" <?php } ?> <?php if ($option == 'No') { ?> onclick="$('#biology_lab_equipment_div').hide();$('.biology_lab_equipment').prop('required', false);$('.biology_lab_equipment').prop('checked', false);" <?php } ?> <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="biology_lab" value="<?php echo $option; ?>" class="">
                            <span style="margin-left:3px"></span> <?php echo $option;  ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-xs-12" id="biology_lab_equipment_div" <?php if ($input->biology_lab == 'No') { ?>style="display: none;" <?php } ?>>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="biology_lab_equipment" class="col-form-label">Biol. Lab Equipments</label>
                        </div>
                    </div>
                    <div class="col-xs-8">
                        <?php
                        $options = array("Sufficient", "Deficient");
                        foreach ($options as $option) {
                            $checked = "";
                            if ($option == $input->biology_lab_equipment  and $input->biology_lab == 'Yes') {
                                $checked = "checked";
                            }

                        ?>
                            <span style="margin-left:5px"></span>
                            <input <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="biology_lab_equipment" value="<?php echo $option; ?>" class="biology_lab_equipment">
                            <span style="margin-left:3px"></span> <?php echo $option;  ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="chemistry_lab" class="col-form-label">Chemistry Lab</label>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <?php
                        $options = array("Yes", "No");
                        foreach ($options as $option) {
                            $checked = "";
                            if ($option == $input->chemistry_lab) {
                                $checked = "checked";
                            }

                        ?>
                            <span style="margin-left:5px"></span>
                            <input required <?php if ($option == 'Yes') { ?> onclick="$('#chemistry_lab_equipment_div').show();$('.chemistry_lab_equipment').prop('required', true);" <?php } ?> <?php if ($option == 'No') { ?> onclick="$('#chemistry_lab_equipment_div').hide();$('.chemistry_lab_equipment').prop('required', false);$('.chemistry_lab_equipment').prop('checked', false);" <?php } ?> <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="chemistry_lab" value="<?php echo $option; ?>" class="">
                            <span style="margin-left:3px"></span> <?php echo $option;  ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-xs-12" id="chemistry_lab_equipment_div" <?php if ($input->chemistry_lab == 'No') { ?>style="display: none;" <?php } ?>>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="chemistry_lab_equipment" class="col-form-label">Chem. Lab Equipments</label>
                        </div>
                    </div>
                    <div class="col-xs-8">
                        <?php
                        $options = array("Sufficient", "Deficient");
                        foreach ($options as $option) {
                            $checked = "";
                            if ($option == $input->chemistry_lab_equipment  and $input->chemistry_lab == 'Yes') {
                                $checked = "checked";
                            }

                        ?>
                            <span style="margin-left:5px"></span>
                            <input <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="chemistry_lab_equipment" value="<?php echo $option; ?>" class="chemistry_lab_equipment">
                            <span style="margin-left:3px"></span> <?php echo $option;  ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <div class="col-xs-12">
                <div class="col-xs-4">
                    <div class="form-group">
                        <label for="computer_lab" class="col-form-label">Computer Lab</label>
                    </div>
                </div>
                <div class="col-xs-7">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->computer_lab) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php if ($option == 'Yes') { ?> onclick="$('#computers_div').show();$('.computers').prop('required', true);" <?php } ?> <?php if ($option == 'No') { ?> onclick="$('#computers_div').hide();$('.computers').prop('required', false);$('.computers').val('');" <?php } ?> <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="computer_lab" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div id="computers_div" <?php if ($input->computer_lab == 'No') { ?>style="display: none;" <?php } ?>>
                <div class="col-xs-12">
                    <div class="col-xs-7">
                        <div class="form-group">
                            <label for="total_working_computers" class="col-form-label">Total Working Computers</label>
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <input type="text" id="total_working_computers" name="total_working_computers" value="<?php echo $input->total_working_computers; ?>" class="form-control computers">
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-7">
                        <div class="form-group">
                            <label for="total_not_working_computers" class="col-form-label">Total Not Working Computers</label>
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <input type="number" id="total_not_working_computers" name="total_not_working_computers" value="<?php echo $input->total_not_working_computers; ?>" class="form-control computers">
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="library" class="col-form-label">Library</label>
                    </div>
                </div>
                <div class="col-xs-7">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->library) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php if ($option == 'Yes') { ?> onclick="$('#library_books_div').show();$('.library_books').prop('required', true);" <?php } ?> <?php if ($option == 'No') { ?> onclick="$('#library_books_div').hide();$('.library_books').prop('required', false);$('.library_books').val('');" <?php } ?> <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="library" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div id="library_books_div" <?php if ($input->library == 'No') { ?>style="display: none;" <?php } ?>>
                <div class="col-xs-12">
                    <div class="col-xs-7">
                        <div class="form-group">
                            <label for="library_books" class="col-form-label">Library Books Total</label>
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <input type="text" id="library_books" name="library_books" value="<?php echo $input->library_books; ?>" class="form-control library_books">
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group row">
                    <label for="visited_by_officers" class="col-form-label">Visited By Officers</label>
                    <div class="col-xs-6">
                        <input type="text" required id="visited_by_officers" name="visited_by_officers" value="<?php echo $input->visited_by_officers; ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="visited_by_officials" class="col-form-label">Visited By Officials</label>
                    <div class="col-xs-6">
                        <input type="text" required id="visited_by_officials" name="visited_by_officials" value="<?php echo $input->visited_by_officials; ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="visit_date" class="col-form-label">Visit Date</label>
                    <div class="col-xs-8">
                        <input type="date" required id="visit_date" name="visit_date" value="<?php echo $input->visit_date; ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="recommendation" class="col-form-label">Recommendation</label>
                    <div class="col-xs-8">
                        <?php
                        $options = array("Recommended", "Not Recommended");
                        foreach ($options as $option) {
                            $checked = "";
                            if ($option == $input->timing) {
                                $checked = "checked";
                            }

                        ?>
                            <span style="margin-left:5px"></span>
                            <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="recommendation" value="<?php echo $option; ?>" class="">
                            <span style="margin-left:3px"></span> <?php echo $option;  ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="remarks" class="col-form-label">Remarks</label>
                    <textarea required id="remarks" name="remarks" class="form-control"><?php echo $input->remarks; ?></textarea>

                </div>
                <div class="form-group row">
                    <label for="remarks" class="col-form-label">Do you have any other suggestions for changes?</label>
                    <textarea required id="any_changes" name="any_changes" class="form-control"><?php echo $input->any_changes; ?></textarea>

                </div>
            </div>
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