<div class="alert alert-primary" role="alert" style="margin-bottom: 5px;">
    <h4>Instititute ID: <?php echo $school->schoolId ?></h4>

    <h3 class="alert-heading"><?php echo $school->schoolName; ?></h3>
    <h4>

        <?php
        if ($school->registrationNumber > 0) { ?> REGISTRATION NO:
            <?php echo $school->registrationNumber ?>
        <?php } else {
            echo '<span style="color:#721c24">Not Registered Yet!</span>';
        } ?>

    </h4>
    <hr>
    <p class="mb-0" style="text-align: left; color:inherit !important">
        <small style="color: inherit;">


            <?php if ($school->districtTitle) {
                echo " , District: <strong style='color: inherit;' >" . $school->districtTitle . "</strong>";
            } else {
                echo "District: Null";
            } ?>
            <?php if ($school->tehsil) {
                echo " , Tehsil: <strong style='color: inherit;' >" . $school->tehsil . "</strong>";
            } else {
                echo " , Tehsil: Null";
            } ?>

            <?php if ($school->uc) {
                echo " , Unionconsil: <strong style='color: inherit;' >" . $school->uc . "</strong>";
            } else {
                echo " , Unionconsil: Null";
            } ?>

            <?php if ($school->address) {
                echo " , Address:  <strong style='color: inherit;' >" . $school->address . "</strong>";
            } else {
                echo " Address: Null";
            } ?>
        </small>
    </p>


</div>

<form id="visits" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
    <input type="hidden" required id="schools_id" name="schools_id" value="<?php echo $school->schoolId; ?>" class="form-control">
    <?php
    $query = "SELECT ss.schoolId, sy.sessionYearTitle, 
    rt.regTypeTitle, ss.status, sy.status as session_status,
    ss.session_year_id
    FROM school as ss
    INNER JOIN session_year as sy ON(sy.sessionYearId = ss.session_year_id)
    INNER JOIN reg_type as rt ON(rt.regTypeId = ss.reg_type_id)
    WHERE ss.schools_id = '" . $school->schoolId . "'
    ORDER BY sy.sessionYearId ASC";
    $session = $this->db->query($query)->result(); ?>
    <div class="form-group row">
        <label for="school_id" class="col-sm-4 col-form-label">Session</label>
        <div class="col-sm-8">
            <?php
            $last_issued_session = $this->db->query($query)->row();
            if ($last_issued_session) {
                $last_issued_id = $last_issued_session->session_year_id;
            }
            foreach ($session as $option) {
            ?>
                <?php //if ($option->status == 2 or $option->session_status == 1 or $option->session_year_id == $last_issued_id) { 
                ?>
                <span style="margin-left:5px"></span>
                <input <?php if ($option->schoolId == $input->school_id) { ?>checked <?php } ?> required type="radio" id="<?php echo $option->schoolId; ?>" name="school_id" value="<?php echo $option->schoolId; ?>" class="">
                <?php //} 
                ?>
                <span style="margin-left:3px"></span> <?php echo $option->sessionYearTitle;  ?> (<?php echo $option->regTypeTitle; ?>) <br />
            <?php } ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="visit_reason" class="col-sm-4 col-form-label">Visit Reason</label>

        <div class="col-sm-8">
            <?php
            if ($school->registrationNumber > 0) {
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
    <div class="form-group row">
        <label for="visit_for_level" class="col-sm-4 col-form-label">Note</label>
        <div class="col-sm-8">
            <input class="form-control" style="width: 100%;" type="text" name="visit_note" value="<?php echo $input->visit_note; ?>" />
        </div>
    </div>


    <div class="form-group row" style="text-align:center">
        <div id="form_result_response"></div>
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
                    $('#form_result_response').html(response);
                }

            }
        });
    });
</script>