<form id="visits" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
    <input type="hidden" required id="school_id" name="school_id" value="<?php echo $input->school_id; ?>" class="form-control">
    <input type="hidden" required id="schools_id" name="schools_id" value="<?php echo $input->schools_id; ?>" class="form-control">

    <div class="form-group row">
        <label for="visit_reason" class="col-sm-4 col-form-label">Visit Reason</label>

        <div class="col-sm-8">
            <?php
            $query = "SELECT registrationNumber FROM schools WHERE schools.schoolId = '" . $input->schools_id . "'";
            $reg_no = $this->db->query($query)->row()->registrationNumber;
            if ($reg_no > 0) {
                $options = array("Renewal", "Upgradation", "Change of Location", "Closure of School");
            } else {
                $options = array("New Registration");
            }
            foreach ($options as $option) {
                $checked = "";
                if ($option == $input->visit_reason) {
                    $checked = "checked";
                }

            ?>
                <span style="margin-left:5px"></span>
                <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="visit_reason" value="<?php echo $option; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option;  ?>
            <?php } ?>
        </div>


    </div>
    <div class="form-group row">
        <label for="visit_for_level" class="col-sm-4 col-form-label">Visit For Levels</label>
        <div class="col-sm-8">


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
            <input <?php if ($input->academy_l == 1) {
                        echo 'checked';
                    } ?> type="checkbox" name="academy_l" value="1" /> Academy
            <span style="margin-left: 5px"></span>



        </div>
    </div>
    <div class="form-group row" style="text-align:center">
        <div id="result_response"></div>
        <?php if ($input->visit_id == 0) { ?>
            <button type="submit" class="btn btn-primary">Add To Visit List</button>
        <?php } else { ?>
            <button type="submit" class="btn btn-primary">Update Visit List</button>
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
            url: '<?php echo site_url("visits/add_to_visit_list"); ?>', // URL to submit form data
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