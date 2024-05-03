<form id="visits" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
    <input type="hidden" name="form" value="d" />
    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
    <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
    <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />



    <div class="block_div">
        <div class="row">
            <div class="col-xs-12">


                <?php
                $levels = NULL;
                if ($input->primary_l == 1) {
                    $levels[] = 1;
                }

                if ($input->middle_l == 1) {
                    $levels[] = 2;
                }

                if ($input->high_l == 1) {
                    $levels[] = 3;
                }

                if ($input->high_sec_l == 1) {
                    $levels[] = 4;
                }

                if ($input->academy_l == 1) {
                    $levels[] = 5;
                }
                $o_a_levels = 0;
                if ($input->o_a_levels == 'No') {
                    $o_a_levels = '16,17,18,19,20';
                }

                $query = "SELECT * FROM levelofinstitute WHERE levelofInstituteId IN(" . implode(', ', $levels) . ")";
                $levels = $this->db->query($query)->result();
                foreach ($levels as $level) { ?>
                    <h4><?php echo $level->levelofInstituteTitle; ?></h4>
                    <table class="table1 table1_small">
                        <tr>
                            <th style="width: 100px;">Classes</th>
                            <th>Rooms</th>
                            <th>Boys</th>
                            <th>Girls</th>
                            <th>Max Fee</th>

                        </tr>
                        <?php
                        $classes = $this->db->query("SELECT * FROM class 
                        WHERE class.level_id = " . $level->levelofInstituteId . "
                        AND classId NOT IN (" . $o_a_levels . ")
                        order by level_id ASC, classId ASC")->result();
                        $count = 1;
                        $count2 = 1;
                        foreach ($classes  as $class) {

                            $query = "SELECT * FROM visit_details 
                            WHERE visit_id ='" . $visit_id . "'
                            AND school_id ='" . $school_id . "' 
                            AND schools_id ='" . $schools_id . "'
                            AND class_id = '" . $class->classId . "'";
                            $class_detail = $this->db->query($query)->row();



                        ?>

                            <tr>

                                <th style=""><?php echo $class->classTitle ?></th>
                                <td>
                                    <input required min="0" class="form-control" style="width: 50px; border:1px solid white !important" type="number" value="<?php echo $class_detail->rooms; ?>" name="classes[<?php echo $class->classId; ?>][rooms]" />

                                </td>
                                <td>
                                    <input required min="0" class="form-control" style="width: 40px; border:1px solid white !important" type="number" value="<?php echo $class_detail->boys; ?>" name="classes[<?php echo $class->classId; ?>][boys]" />

                                </td>
                                <td>
                                    <input required min="0" class="form-control" style="width: 40px; border:1px solid white !important" type="number" value="<?php echo $class_detail->girls; ?>" name="classes[<?php echo $class->classId; ?>][girls]" />

                                </td>
                                <td>
                                    <input required min="0" class="form-control" style="width: 60px; border:1px solid white !important" type="number" value="<?php echo $class_detail->max_fee; ?>" name="classes[<?php echo $class->classId; ?>][max_fee]" />

                                </td>

                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>


            </div>
            <div class="col-xs-12">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="avg_class_rooms_size" class="col-form-label">AVG C-Rooms Size</label>
                    </div>
                </div>
                <div class="col-xs-6">
                    <input type="text" required id="avg_class_rooms_size" name="avg_class_rooms_size" value="<?php echo $input->avg_class_rooms_size; ?>" class="form-control">
                </div>
            </div>


        </div>
    </div>




    <div class="block_div" style="margin-bottom: 35px;">
        <div class="row">
            <div id="result_response"></div>
            <div class="col-xs-4" style="text-align: center;">
                <a class="btn btn-small" href='<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/c"); ?>'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-xs-4" style="text-align: center;">
                <button class="btn btn-small" type="submit" name="submitButton" value="same">Save (D)</button>
            </div>

            <div class="col-xs-4" style="text-align: center;">
                <button class="btn btn-small" type="submit" name="submitButton" value="next">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
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
                            window.location.href = "<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/e"); ?>";
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