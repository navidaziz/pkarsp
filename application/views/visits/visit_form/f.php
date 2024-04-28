<?php
$query = "SELECT * FROM hazards_with_associated_risks WHERE school_id = '" . $school_id . "'";
$hazards_hazard_with_associated_risks = $this->db->query($query)->row();
?>
<form id="visits" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />

    <input type="hidden" name="form" value="f" />
    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
    <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
    <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
    <?php $options = array("Yes", "No"); ?>
    <form class="form-horizontal" method="post" id="Form1" action="<?php echo base_url('form/update_form_g_data'); ?>">
        <table class="table table-bordered">
            <tr>
                <th style="width: 50%;">Exposed to floods:</th>
                <td>

                    <?php foreach ($options as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->exposedToFlood == $value) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>


                        <span style="margin-left: 20px;"></span> <input type="radio" <?php echo $check; ?> name="exposedToFlood" value="<?php echo $value; ?>" required> <?php echo $value; ?>

                    <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <th>Drowning (In case of nearby canal):</td>
                <td>

                    <?php foreach ($options as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->drowning == $value) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>


                        <span style="margin-left: 20px;"></span> <input type="radio" <?php echo $check; ?> name="drowning" value="<?php echo $value; ?>" required> <?php echo $value; ?>

                    <?php endforeach; ?>
                </td>
            </tr>

            <tr>
                <th>School Building Condition (Walls, Doors, windows)</td>
                <td>
                    <?php $condition = array("Good", "Satisfactory", "Poor");
                    $counter = 0; ?>
                    <?php foreach ($condition as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->buildingCondition == $value) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>

                        <span style="margin-left: 20px;"></span>
                        <input type="radio" <?php echo $check; ?> name="buildingCondition" value="<?php echo $value; ?>" required> <?php echo $value; ?>
                        <br />
                    <?php endforeach; ?>
                </td>
            </tr>

            <tr>
                <th>School Access route</td>
                <td>
                    <?php $safeUnsafe = array("Safe", "Unsafe"); ?>
                    <?php foreach ($safeUnsafe as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->accessRoute == $value) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>
                        <span style="margin-left: 20px;"></span>
                        <input onclick="<?php if ($value == 'Safe') { ?> $('#more_options').hide(); <?php } ?><?php if ($value == 'Unsafe') { ?>  $('#more_options').show(); <?php } ?>" type="radio" <?php echo $check; ?> name="accessRoute" value="<?php echo $value; ?>" required> <?php echo $value; ?>

                    <?php endforeach; ?>



                </td>
            </tr>

            <tr id="more_options" <?php if ($hazards_hazard_with_associated_risks->accessRoute == 'Safe') { ?>style="display: none;" <?php }  ?>>
                <th>
                    If Unsafe: Describe the following
                </th>
                <td>

                    <?php $counter = 0; ?>
                    <?php
                    $query = "SELECT * FROM `hazards_with_associated_risks_unsafe_list` WHERE school_id = '" . $school_id . "'";
                    $unsafeids = $this->db->query($query)->result();
                    $unsafe_ids = array();
                    foreach ($unsafeids as $unsafeid) {
                        $unsafe_ids[] = $unsafeid->unsafe_list_id;
                    }
                    $query = "SELECT * FROM `unsafe_list`";
                    $unsafe_list = $this->db->query($query)->result();
                    foreach ($unsafe_list as $un_list) : ?>
                        <?php if (in_array($un_list->unSafeListId, $unsafe_ids)) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>

                        <span style="margin-left: 20px;"></span>
                        <input class="unSafeList" type="checkbox" <?php echo $check; ?> name="unSafeList[]" value="<?php echo $un_list->unSafeListId; ?>"> <?php echo $un_list->unSafeListTitle; ?>
                        <br />
                    <?php endforeach; ?>
                </td>
            </tr>

            <tr>
                <th>Other buildings adjacent to School</td>
                <td>
                    <?php $safeUnsafe = array("Safe", "Unsafe"); ?>
                    <?php foreach ($safeUnsafe as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->adjacentBuilding == $value) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>


                        <span style="margin-left: 20px;"></span> <input type="radio" <?php echo $check; ?> name="adjacentBuilding" value="<?php echo $value; ?>" required> <?php echo $value; ?>

                    <?php endforeach; ?>
                </td>
            </tr>

            <tr>
                <th>Safe assembly points available for <br>
                    (i. Flood ii. Earthquake
                    iii. Fire iii. Human induce)</td>
                <td>
                    <?php foreach ($options as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->safeAssemblyPointsAvailable == $value) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>


                        <span style="margin-left: 20px;"></span> <input type="radio" <?php echo $check; ?> name="safeAssemblyPointsAvailable" value="<?php echo $value; ?>" required> <?php echo $value; ?>

                    <?php endforeach; ?>
                </td>
                <!-- <td>
                         <span style="margin-left: 20px;"></span> <input type="radio" name="safeAssemblyPointsAvailable" value="Yes" required> Yes
                         </td>
                        <td>
                         <span style="margin-left: 20px;"></span> <input type="radio" name="safeAssemblyPointsAvailable" value="No" required> No
                         </td> -->
            </tr>


            <tr>
                <th>Teacher trained on School Based Disaster Risk Management</td>
                <td>
                    <?php foreach ($options as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->disasterTraining == $value) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>


                        <span style="margin-left: 20px;"></span> <input type="radio" <?php echo $check; ?> name="disasterTraining" value="<?php echo $value; ?>" required> <?php echo $value; ?>

                    <?php endforeach; ?>
                </td>
            </tr>

            <tr>
                <th>School Improvement plan developed</td>
                <td>
                    <?php foreach ($options as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->schoolImprovementPlan == $value) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>


                        <span style="margin-left: 20px;"></span> <input type="radio" <?php echo $check; ?> name="schoolImprovementPlan" value="<?php echo $value; ?>" required> <?php echo $value; ?>

                    <?php endforeach; ?>
                </td>
            </tr>


            <tr>
                <th>School Disaster Management plan developed</td>
                <td>
                    <?php foreach ($options as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->schoolDisasterManagementPlan == $value) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>


                        <span style="margin-left: 20px;"></span> <input type="radio" <?php echo $check; ?> name="schoolDisasterManagementPlan" value="<?php echo $value; ?>" required> <?php echo $value; ?>

                    <?php endforeach; ?>
                </td>
            </tr>

            <tr>
                <th>Electrification condition</td>
                <td>
                    <?php
                    $counter = 0;
                    $check = ""; ?>
                    <?php foreach ($condition as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->electrification_condition_id == $key) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>
                        <span style="margin-left: 20px;"></span>
                        <input type="radio" <?php echo $check; ?> name="electrification_condition_id" value="<?php echo $key; ?>" required> <?php echo $value; ?>
                        <br />
                    <?php endforeach; ?>
                </td>
            </tr>


            <tr>
                <th>Proper ventilation system available</td>
                <td>
                    <?php foreach ($options as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->ventilationSystemAvailable == $value) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>


                        <span style="margin-left: 20px;"></span> <input type="radio" <?php echo $check; ?> name="ventilationSystemAvailable" value="<?php echo $value; ?>" required> <?php echo $value; ?>

                    <?php endforeach; ?>
                </td>
            </tr>

            <tr>
                <th>Expose to Chemicals in School Laboratory</td>
                <td>
                    <?php foreach ($options as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->chemicalsSchoolLaboratory == $value) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>


                        <span style="margin-left: 20px;"></span> <input type="radio" <?php echo $check; ?> name="chemicalsSchoolLaboratory" value="<?php echo $value; ?>" required> <?php echo $value; ?>

                    <?php endforeach; ?>
                </td>
            </tr>


            <tr>
                <th>Expose to Chemicals in school surrounding</td>
                <td>
                    <?php foreach ($options as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->chemicalsSchoolSurrounding == $value) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>


                        <span style="margin-left: 20px;"></span> <input type="radio" <?php echo $check; ?> name="chemicalsSchoolSurrounding" value="<?php echo $value; ?>" required> <?php echo $value; ?>

                    <?php endforeach; ?>
                </td>
            </tr>

            <tr>
                <th>Exposed to road accident</td>
                <td>
                    <?php foreach ($options as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->roadAccident == $value) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>


                        <span style="margin-left: 20px;"></span> <input type="radio" <?php echo $check; ?> name="roadAccident" value="<?php echo $value; ?>" required> <?php echo $value; ?>

                    <?php endforeach; ?>
                </td>
            </tr>

            <tr>
                <th>Safe drinking water available</td>
                <td>
                    <?php foreach ($options as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->safeDrinkingWaterAvailable == $value) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>


                        <span style="margin-left: 20px;"></span> <input type="radio" <?php echo $check; ?> name="safeDrinkingWaterAvailable" value="<?php echo $value; ?>" required> <?php echo $value; ?>

                    <?php endforeach; ?>
                </td>
            </tr>


            <tr>
                <th>Proper sanitation facilities available (Latrine, draining)</td>
                <td>
                    <?php foreach ($options as $key => $value) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->sanitationFacilities == $value) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>


                        <span style="margin-left: 20px;"></span> <input type="radio" <?php echo $check; ?> name="sanitationFacilities" value="<?php echo $value; ?>" required> <?php echo $value; ?>

                    <?php endforeach; ?>
                </td>
            </tr>

            <tr>
                <th>School Building Structure</td>
                <td>
                    <?php
                    $query = "SELECT * FROM `building_structure`";
                    $building_structure = $this->db->query($query)->result();
                    foreach ($building_structure as $b_structure) : ?>

                        <?php if ($hazards_hazard_with_associated_risks->building_structure_id == $b_structure->buildingStructureId) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>

                        <span style="margin-left: 20px;"></span> <input type="radio" name="building_structure_id" value="<?php echo $b_structure->buildingStructureId; ?>" required <?php echo $check; ?>> <?php echo $b_structure->buildingStructure; ?>
                        <br />
                    <?php endforeach; ?>
                </td>
            </tr>

            <tr>
                <th>School surrounded by the community</td>
                <td>
                    <?php $counter = 0; ?>
                    <?php
                    $query = "SELECT * FROM `hazards_surrounded`";
                    $hazards_surrounded = $this->db->query($query)->result();
                    foreach ($hazards_surrounded as $h_surrounded) : ?>
                        <?php if ($hazards_hazard_with_associated_risks->school_surrounded_by_id == $h_surrounded->hazardsSurroundedId) {
                            $check = "checked";
                        } else {
                            $check = '';
                        } ?>


                        <span style="margin-left: 20px;"></span>
                        <input type="radio" name="school_surrounded_by_id" value="<?php echo $h_surrounded->hazardsSurroundedId; ?>" required <?php echo $check; ?>> <?php echo $h_surrounded->hazardsSurroundedTitle; ?>
                        <br />
                    <?php endforeach; ?>
                </td>
            </tr>

        </table>
        <div class="block_div" style="margin-bottom: 35px;">
            <div class="row">
                <div id="result_response"></div>
                <div class="col-xs-4" style="text-align: center;">
                    <a class="btn btn-small" href='<?php echo site_url("visits/institute_visit_report/$visit_id/$schools_id/$school_id/e"); ?>'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                </div>

                <div class="col-xs-4" style="text-align: center;">
                    <button class="btn btn-small" type="submit" name="submitButton" value="same">Save (F)</button>
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
                                window.location.href = "<?php echo site_url("visits/institute_visit_report/$visit_id/$schools_id/$school_id/g"); ?>";
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