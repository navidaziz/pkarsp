  <!-- Modal -->
  <script>
    function update_class_fee_detail(class_id) {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("form/update_class_fee_from"); ?>",
        data: {
          schools_id: <?php echo $school->schoolId; ?>,
          class_id: class_id,
          school_id: <?php echo $school_id; ?>,
          session_id: <?php echo $session_id; ?>
        }
      }).done(function(data) {

        $('#update_class_ages_body').html(data);
      });

      $('#update_class_ages').modal('toggle');
    }
  </script>
  <div class="modal fade" id="update_class_ages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="update_class_ages_body">

        ...

      </div>
    </div>
  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2 style="display:inline;">
        <?php echo ucwords(strtolower($school->schoolName)); ?>
      </h2>
      <br />
      <h4>S-ID: <?php echo $school->schools_id; ?>
        <?php if ($school->registrationNumber) { ?> - REG No: <?php echo $school->registrationNumber ?> <?php } ?></h4>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active"><?php echo @ucfirst($title); ?>s Session: <?php echo $session_detail->sessionYearTitle; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="padding-top: 0px !important;">

      <?php $this->load->view('forms/navigation_bar');   ?>

      <div class="box box-primary box-solid">


        <div class="box-body">
          <div class="row">

            <div class="col-md-12">
              <style>
                .table>tbody>tr>td,
                .table>tbody>tr>th,
                .table>tfoot>tr>td,
                .table>tfoot>tr>th,
                .table>thead>tr>td,
                .table>thead>tr>th {
                  padding: 5px !important;
                }
              </style>



              <p>
              <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px"><strong>SECTION G</strong> (Hazards with Associated Risks)<br />
                <small style="color: red;">
                  Note: Every option is mandatory.
                </small>
              </h4>

              </small>
              </p>



              <form class="form-horizontal" method="post" id="Form1" action="<?php echo base_url('form/update_form_g_data'); ?>">
                <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
                <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />

                <input type="hidden" name="hazardsWithAssociatedRisksId" value="<?php echo $hazards_hazard_with_associated_risks->hazardsWithAssociatedRisksId; ?>">
                <?php date_default_timezone_set("Asia/Karachi");
                $dated = date("d-m-Y h:i:sa"); ?>

                <?php $options = array("Yes", "No"); ?>

                <div class="col-md-12">
                  <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 10px; padding: 10px; background-color: white;">
                    <table class="table table-bordered">
                      <tr>
                        <th style="width: 500px;">Exposed to floods:</th>
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


                            <span style="margin-left: 20px;"></span> <input type="radio" <?php echo $check; ?> name="buildingCondition" value="<?php echo $value; ?>" required> <?php echo $value; ?>

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
                          <span id="more_options" <?php if ($hazards_hazard_with_associated_risks->accessRoute == 'Safe') { ?>style="display: none;" <?php }  ?>>
                            <br />
                            <br />
                            <span style="margin-left: 20px;"></span> If Unsafe: Describe the following
                            <br />
                            <?php $counter = 0; ?>
                            <?php foreach ($unsafe_list as $un_list) : ?>
                              <?php if (in_array($un_list->unSafeListId, $unsafe_ids)) {
                                $check = "checked";
                              } else {
                                $check = '';
                              } ?>


                              <span style="margin-left: 20px;"></span>
                              <input class="unSafeList" type="checkbox" <?php echo $check; ?> name="unSafeList[]" value="<?php echo $un_list->unSafeListId; ?>"> <?php echo $un_list->unSafeListTitle; ?>

                            <?php endforeach; ?>
                          </span>
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



                            <span style="margin-left: 20px;"></span> <input type="radio" <?php echo $check; ?> name="electrification_condition_id" value="<?php echo $key; ?>" required> <?php echo $value; ?>

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
                          <?php foreach ($building_structure as $b_structure) : ?>

                            <?php if ($hazards_hazard_with_associated_risks->building_structure_id == $b_structure->buildingStructureId) {
                              $check = "checked";
                            } else {
                              $check = '';
                            } ?>

                            <span style="margin-left: 20px;"></span> <input type="radio" name="building_structure_id" value="<?php echo $b_structure->buildingStructureId; ?>" required <?php echo $check; ?>> <?php echo $b_structure->buildingStructure; ?>

                          <?php endforeach; ?>
                        </td>
                      </tr>

                      <tr>
                        <th>School surrounded by the community</td>
                        <td>
                          <?php $counter = 0; ?>
                          <?php foreach ($hazards_surrounded as $h_surrounded) : ?>
                            <?php if ($hazards_hazard_with_associated_risks->school_surrounded_by_id == $h_surrounded->hazardsSurroundedId) {
                              $check = "checked";
                            } else {
                              $check = '';
                            } ?>


                            <span style="margin-left: 20px;"></span> <input type="radio" name="school_surrounded_by_id" value="<?php echo $h_surrounded->hazardsSurroundedId; ?>" required <?php echo $check; ?>> <?php echo $h_surrounded->hazardsSurroundedTitle; ?>

                          <?php endforeach; ?>
                        </td>
                      </tr>

                    </table>
                  </div>
                </div>

                <div class="col-md-12">
                  <div style=" font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                    <a class="btn btn-success pull-left" href="<?php echo site_url("form/section_f/$school_id"); ?>">
                      <i class="fa fa-arrow-left" aria-hidden="true" style="margin-right: 10px;"></i> Previous Section ( Security Measures ) </a>
                    <?php if ($form_status->form_g_status == 1) { ?>
                      <span style="margin-left: 20px;"></span> <input class="btn btn-primary" type="submit" name="" value="Update Section G Data" />
                    <?php } else { ?>
                      <span style="margin-left: 20px;"></span> <input class="btn btn-danger" type="submit" name="" value="Add Section G Data" />

                    <?php } ?>
                    <?php if ($form_status->form_g_status == 1) { ?>
                      <a class="btn btn-success pull-right" href="<?php echo site_url("form/section_h/$school_id"); ?>"> Next Section ( Fee Concession ) <i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i></a>
                    <?php } ?>
                  </div>
                </div>

                <?php

                echo $form_complete;

                ?>


              </form>

            </div>

          </div>
        </div>


      </div>

    </section>

  </div>