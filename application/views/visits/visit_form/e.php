<?php
$query = "SELECT * FROM security_measures WHERE school_id = '" . $school_id . "'";
$school_security_measures = $this->db->query($query)->row();
?>

<form id="visits" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />

    <input type="hidden" name="form" value="e" />
    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
    <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
    <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />



    <div class="col-xs-12">
        <div class="col-xs-3">
            <div class="form-group">
                <label for="securityStatus" class="col-form-label">Security Statu</label>
            </div>
        </div>

        <div class="col-xs-9">
            <?php
            $query = "SELECT * FROM `security_status`";
            $options = $this->db->query($query)->result();
            foreach ($options as $option) {
                $checked = "";
                if ($option->securityStatusId == $school_security_measures->securityStatus) {
                    $checked = "checked";
                } ?>
                <span style="margin-left:5px"></span>
                <input name="securityStatus" id="<?php echo $option->securityStatusTitle; ?>" required <?php echo $checked ?> type="radio" value="<?php echo $option->securityStatusId; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option->securityStatusTitle;  ?>
            <?php } ?>
        </div>
    </div>




    <div class="col-xs-12">
        <div class="col-xs-3">
            <div class="form-group">
                <label for="securityProvided" class="col-form-label">Type of Security Provided</label>
            </div>
        </div>

        <div class="col-xs-9">
            <?php
            $query = "SELECT * FROM `security_provided`";
            $options = $this->db->query($query)->result();
            foreach ($options as $option) {
                $checked = "";
                if ($option->securityProvidedId == $school_security_measures->securityProvided) {
                    $checked = "checked";
                } ?>
                <span style="margin-left:5px"></span>
                <input name="securityProvided" id="<?php echo $option->securityProvidedTitle; ?>" required <?php echo $checked ?> type="radio" value="<?php echo $option->securityProvidedId; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option->securityProvidedTitle;  ?>
                <br />
            <?php } ?>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="col-xs-3">
            <div class="form-group">
                <label for="security_personnel_status_id" class="col-form-label">Status of Security Personnel</label>
            </div>
        </div>

        <div class="col-xs-9">
            <?php
            $query = "SELECT * FROM `security_personnel`";
            $options = $this->db->query($query)->result();
            foreach ($options as $option) {
                $checked = "";
                if ($option->SecurityPersonnelId == $school_security_measures->security_personnel_status_id) {
                    $checked = "checked";
                } ?>
                <span style="margin-left:5px"></span>
                <input name="security_personnel_status_id" id="<?php echo $option->SecurityPersonnelTitle; ?>" required <?php echo $checked ?> type="radio" value="<?php echo $option->SecurityPersonnelId; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option->SecurityPersonnelTitle;  ?>
            <?php } ?>
        </div>
    </div>



    <div class="col-xs-12">
        <div class="col-xs-6">
            <div class="form-group">
                <label for="securityPersonnel" class="col-form-label">Security Personnel (in Nos)</label>
            </div>
        </div>
        <div class="col-xs-6">
            <input type="text" required id="securityPersonnel" name="securityPersonnel" value="<?php echo $school_security_measures->securityPersonnel; ?>" class="form-control" />
        </div>
    </div>


    <div class="col-xs-12">
        <div class="col-xs-7">
            <div class="form-group">
                <label for="security_according_to_police_dept" class="col-form-label">Whether security is inline with instruction of Police Department ?</label>
            </div>
        </div>

        <div class="col-xs-5">
            <?php
            $options = array("Yes", "No");
            foreach ($options as $option) {
                $checked = "";
                if ($option == $school_security_measures->security_according_to_police_dept) {
                    $checked = "checked";
                } ?>
                <span style="margin-left:5px"></span>
                <input name="security_according_to_police_dept" id="<?php echo $option; ?>" required <?php echo $checked ?> type="radio" value="<?php echo $option; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option;  ?>
            <?php } ?>
        </div>
    </div>


    <div class="col-xs-12">
        <div class="col-xs-7">
            <div class="form-group">
                <label for="cameraInstallation" class="col-form-label">CCTVs Camera System Installed</label>
            </div>
        </div>

        <div class="col-xs-5">
            <?php
            $options = array("Yes", "No");
            foreach ($options as $option) {
                $checked = "";
                if ($option == $school_security_measures->cameraInstallation) {
                    $checked = "checked";
                } ?>
                <span style="margin-left:5px"></span>
                <input name="cameraInstallation" id="<?php echo $option; ?>" required <?php echo $checked ?> type="radio" value="<?php echo $option; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option;  ?>
            <?php } ?>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="col-xs-6">
            <div class="form-group">
                <label for="camraNumber" class="col-form-label">Number of CCTVs Cameras</label>
            </div>
        </div>
        <div class="col-xs-6">
            <input type="text" required id="camraNumber" name="camraNumber" value="<?php echo $school_security_measures->exitDoorsNumber; ?>" class="form-control" />
        </div>
    </div>

    <div class="col-xs-12">
        <div class="col-xs-7">
            <div class="form-group">
                <label for="dvrMaintained" class="col-form-label">DVR Maintained</label>
            </div>
        </div>

        <div class="col-xs-5">
            <?php
            $options = array("Yes", "No");
            foreach ($options as $option) {
                $checked = "";
                if ($option == $school_security_measures->dvrMaintained) {
                    $checked = "checked";
                } ?>
                <span style="margin-left:5px"></span>
                <input name="dvrMaintained" id="<?php echo $option; ?>" required <?php echo $checked ?> type="radio" value="<?php echo $option; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option;  ?>
            <?php } ?>
        </div>
    </div>




    <div class="col-xs-12">
        <div class="col-xs-7">
            <div class="form-group">
                <label for="cameraOnline" class="col-form-label">CCTVs Online Accessibility</label>
            </div>
        </div>

        <div class="col-xs-5">
            <?php
            $options = array("Yes", "No");
            foreach ($options as $option) {
                $checked = "";
                if ($option == $school_security_measures->cameraOnline) {
                    $checked = "checked";
                } ?>
                <span style="margin-left:5px"></span>
                <input name="cameraOnline" id="<?php echo $option; ?>" required <?php echo $checked ?> type="radio" value="<?php echo $option; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option;  ?>
            <?php } ?>
        </div>
    </div>




    <div class="col-xs-12">
        <div class="col-xs-7">
            <div class="form-group">
                <label for="walkThroughGate" class="col-form-label">Emergency Exit Door Availability</label>
            </div>
        </div>

        <div class="col-xs-5">
            <?php
            $options = array("Yes", "No");
            foreach ($options as $option) {
                $checked = "";
                if ($option == $school_security_measures->emergencyDoorsNumber) {
                    $checked = "checked";
                } ?>
                <span style="margin-left:5px"></span>
                <input name="emergencyDoorsNumber" id="<?php echo $option; ?>" required <?php echo $checked ?> type="radio" value="<?php echo $option; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option;  ?>
            <?php } ?>
        </div>
    </div>


    <div class="col-xs-12">
        <div class="col-xs-6">
            <div class="form-group">
                <label for="exitDoorsNumber" class="col-form-label">Number of Exit Doors</label>
            </div>
        </div>
        <div class="col-xs-6">
            <input type="text" required id="exitDoorsNumber" name="exitDoorsNumber" value="<?php echo $school_security_measures->exitDoorsNumber; ?>" class="form-control" />
        </div>
    </div>

    <div class="col-xs-12">
        <div class="col-xs-6">
            <div class="form-group">
                <label for="avg_class_rooms_size" class="col-form-label">Boundary Wall Height (In Feet)</label>
            </div>
        </div>
        <div class="col-xs-6">
            <input type="text" required id="boundryWallHeight" name="boundryWallHeight" value="<?php echo $school_security_measures->boundryWallHeight; ?>" class="form-control" />
        </div>
    </div>


    <div class="col-xs-12">
        <div class="col-xs-7">
            <div class="form-group">
                <label for="wiresProvided" class="col-form-label">Barbed Wires Provided</label>
            </div>
        </div>

        <div class="col-xs-5">
            <?php
            $options = array("Yes", "No");
            foreach ($options as $option) {
                $checked = "";
                if ($option == $school_security_measures->wiresProvided) {
                    $checked = "checked";
                } ?>
                <span style="margin-left:5px"></span>
                <input name="wiresProvided" id="<?php echo $option; ?>" required <?php echo $checked ?> type="radio" value="<?php echo $option; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option;  ?>
            <?php } ?>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="col-xs-7">
            <div class="form-group">
                <label for="watchTower" class="col-form-label">Watch Tower</label>
            </div>
        </div>

        <div class="col-xs-5">
            <?php
            $options = array("Yes", "No");
            foreach ($options as $option) {
                $checked = "";
                if ($option == $school_security_measures->watchTower) {
                    $checked = "checked";
                } ?>
                <span style="margin-left:5px"></span>
                <input name="watchTower" id="<?php echo $option; ?>" required <?php echo $checked ?> type="radio" value="<?php echo $option; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option;  ?>
            <?php } ?>
        </div>
    </div>


    <div class="col-xs-12">
        <div class="col-xs-6">
            <div class="form-group">
                <label for="licensedWeapon" class="col-form-label">Number of Licensed Weapon(s)</label>
            </div>
        </div>
        <div class="col-xs-6">
            <input type="text" required id="licensedWeapon" name="licensedWeapon" value="<?php echo $school_security_measures->licensedWeapon; ?>" class="form-control" />
        </div>
    </div>


    <div class="col-xs-12">
        <div class="col-xs-3">
            <div class="form-group">
                <label for="walkThroughGate" class="col-form-label">License issued by whom:</label>
            </div>
        </div>

        <div class="col-xs-9">
            <?php
            $query = "SELECT * FROM `security_license_issued`";
            $options = $this->db->query($query)->result();
            foreach ($options as $option) {
                $checked = "";
                if ($option->licenseIssuedId == $school_security_measures->license_issued_by_id) {
                    $checked = "checked";
                } ?>
                <span style="margin-left:5px"></span>
                <input name="license_issued_by_id" id="<?php echo $option->licenseIssuedTitle; ?>" required <?php echo $checked ?> type="radio" value="<?php echo $option->licenseIssuedId; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option->licenseIssuedTitle;  ?> <br />
            <?php } ?>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="avg_class_rooms_size" class="col-form-label">License No(s):</label>
                <textarea required id="licenseNumber" name="licenseNumber" class="form-control"><?php echo $school_security_measures->licenseNumber; ?></textarea>
            </div>
        </div>
    </div>


    <div class="col-xs-12">
        <div class="col-xs-6">
            <div class="form-group">
                <label for="avg_class_rooms_size" class="col-form-label">Ammunition Status (In Nos.)</label>
            </div>
        </div>
        <div class="col-xs-6">
            <input type="text" required id="ammunitionStatus" name="ammunitionStatus" value="<?php echo $school_security_measures->ammunitionStatus; ?>" class="form-control">
        </div>
    </div>


    <div class="col-xs-12">
        <div class="col-xs-7">
            <div class="form-group">
                <label for="walkThroughGate" class="col-form-label">Metal Detector</label>
            </div>
        </div>

        <div class="col-xs-5">
            <?php
            $options = array("Yes", "No");
            foreach ($options as $option) {
                $checked = "";
                if ($option == $school_security_measures->metalDetector) {
                    $checked = "checked";
                } ?>
                <span style="margin-left:5px"></span>
                <input name="metalDetector" id="<?php echo $option; ?>" required <?php echo $checked ?> type="radio" value="<?php echo $option; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option;  ?>
            <?php } ?>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="col-xs-7">
            <div class="form-group">
                <label for="walkThroughGate" class="col-form-label">Walkthrough gate:</label>
            </div>
        </div>

        <div class="col-xs-5">
            <?php
            $options = array("Yes", "No");
            foreach ($options as $option) {
                $checked = "";
                if ($option == $school_security_measures->walkThroughGate) {
                    $checked = "checked";
                } ?>
                <span style="margin-left:5px"></span>
                <input name="walkThroughGate" id="<?php echo $option; ?>" required <?php echo $checked ?> type="radio" value="<?php echo $option; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option;  ?>
            <?php } ?>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="col-xs-7">
            <div class="form-group">
                <label for="gateBarrier" class="col-form-label">Main Gate Barrier:</label>
            </div>
        </div>

        <div class="col-xs-5">
            <?php
            $options = array("Yes", "No");
            foreach ($options as $option) {
                $checked = "";
                if ($option == $school_security_measures->gateBarrier) {
                    $checked = "checked";
                } ?>
                <span style="margin-left:5px"></span>
                <input name="gateBarrier" id="<?php echo $option; ?>" required <?php echo $checked ?> type="radio" value="<?php echo $option; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option;  ?>
            <?php } ?>
        </div>
    </div>

    <div class="block_div" style="margin-bottom: 35px;">
        <div class="row">
            <div id="result_response"></div>
            <div class="col-xs-4" style="text-align: center;">
                <a class="btn btn-small" href='<?php echo site_url("visits/institute_visit_report/$visit_id/$schools_id/$school_id/d"); ?>'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-xs-4" style="text-align: center;">
                <button class="btn btn-small" type="submit" name="submitButton" value="same">Save F-E</button>
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
</script>