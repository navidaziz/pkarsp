  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php $this->load->view('forms/form_header');   ?>


    <!-- Main content -->
    <section class="content" style="padding-top: 0px !important;">

      <?php $this->load->view('forms/navigation_bar');   ?>

      <div class="box box-primary box-solid">

        <div class="box-body">


          <div class="row">
            <?php
            $issued_levels[] = $school->level_of_school_id;
            $upgradation_levels[] = array();
            if ($school->reg_type_id == 4 or $school->reg_type_id == 1) { ?>
              <div class="col-md-12">
                <form class="form-horizontal" method="post" id="Form1" action="<?php echo base_url('form/update_levels'); ?>">



                  <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
                  <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
                  <input type="hidden" name="session_id" value="<?php echo $session_id; ?>">
                  <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 10px; padding: 10px; background-color: white;">



                    <?php if ($school->reg_type_id == 4) { ?>
                      <h4>Please select other levels for Upgradation</h4>
                    <?php } ?>
                    <?php if ($school->reg_type_id == 1) { ?>
                      <h4>Please select otherlevels for Registration</h4>
                    <?php } ?>
                    <?php $query = "SELECT * FROM `levelofinstitute` 
                      WHERE  school_type_id = '" . $school->school_type_id . "'
                      ORDER BY `levelofInstituteId` ASC";
                    $levels = $this->db->query($query)->result(); ?>
                    <table class="table" style="text-align: center;">
                      <tr>

                        <?php



                        $query = "SELECT MAX(schoolId) as pre_school_id FROM school 
		                    WHERE schools_id = $school->schools_id and status=1";
                        $previous_session = $this->db->query($query)->row();
                        if ($previous_session->pre_school_id) {
                          $query = "SELECT `primary`, `middle`, `high`, `high_sec` FROM school 
                                  WHERE new_certificate=1
                                  AND school.schoolId = $previous_session->pre_school_id";
                          $school_levels = $this->db->query($query)->row();
                          if ($school_levels) {
                            //$issued_levels = array();
                            if ($school_levels->primary == 1) {
                              $issued_levels[] = 1;
                            }
                            if ($school_levels->middle == 1) {
                              $issued_levels[] = 2;
                            }
                            if ($school_levels->high == 1) {
                              $issued_levels[] = 3;
                            }
                            if ($school_levels->high_sec == 1) {
                              $issued_levels[] = 4;
                            }
                          }
                        }

                        foreach ($levels as $level) { ?>
                          <th style="text-align: center;"> <?php echo $level->levelofInstituteTitle; ?></th>
                        <?php }   ?>
                      </tr>
                      <tr>
                        <?php
                        $upgradation_levels = explode(",", $school->upgradation_levels);

                        $upgradation = "";
                        foreach ($levels as $level) {
                        ?>

                          <td>

                            <?php if (in_array($level->levelofInstituteId, $issued_levels)) { ?>
                              <input type="hidden" name="levels[<?php echo $level->levelofInstituteId; ?>]" value="on" />

                              <i class="fa fa-check" aria-hidden="true"></i>
                            <?php } else { ?>


                              <input onChange="this.form.submit()" class="<?php echo $upgradation; ?>" <?php if (in_array($level->levelofInstituteId, $upgradation_levels)) { ?> checked readonly <?php } ?> type="checkbox" name="levels[<?php echo $level->levelofInstituteId; ?>]" />

                              <?php if ($level->levelofInstituteId == $school->level_of_school_id) {
                                $upgradation = "upgradation";

                              ?>

                                <i class="fa fa-check" aria-hidden="true"></i>
                              <?php } ?>
                            <?php } ?>
                          </td>
                        <?php }   ?>
                      </tr>
                    </table>


                  </div>
                </form>
              </div>
            <?php } ?>

            <div class="col-md-12">
              <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px"><strong>SECTION B (PHYSICAL FACILITIES)</strong><br />

              </h4>
            </div>

            <form class="form-horizontal" method="post" id="Form1" action="<?php echo base_url('form/update_form_b_data'); ?>">
              <?php if ($school->reg_type_id == 4 or $school->reg_type_id == 1) { ?>
                <?php if ($school->upgradation_levels) { ?>
                  <input type="hidden" name="upgradation_levels" value="<?php echo $school->upgradation_levels; ?>" />
                <?php } else { ?>
                  <input type="hidden" name="upgradation_levels" value="<?php echo implode(',', $issued_levels); ?>" />
                <?php } ?>
              <?php } ?>
              <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
              <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
              <input type="hidden" name="physicalFacilityId" value="<?php echo $school_physical_facilities->physicalFacilityId; ?>" />
              <input type="hidden" name="session_id" value="<?php echo $session_id; ?>">

              <div class="col-md-3">

                <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 10px; padding: 10px; background-color: white;">
                  <h3>Building Detail</h3>
                  <?php foreach ($buildings as $building) : ?>
                    <input <?php if ($building->physicalBuildingId == 2) { ?> onclick="$('#building_rent').show(); $( '#rent_amount' ).val(''); $( '#rent_amount' ).prop('required',true);" <?php } else { ?> onclick="$('#building_rent').hide(); $( '#rent_amount' ).val(''); $( '#rent_amount' ).prop('required',false);" <?php } ?> type="radio" value="<?php echo $building->physicalBuildingId; ?>" <?php if ($building->physicalBuildingId == $school_physical_facilities->building_id) { ?> checked <?php  } ?> name="building_id" required />
                    <strong> <?php echo $building->physicalBuildingTitle; ?> </strong>

                    <?php if ($building->physicalBuildingId == 2) { ?>
                      <span id="building_rent" <?php if ($building->physicalBuildingId != $school_physical_facilities->building_id) { ?>style="display: none;" <?php } ?>>
                        <br />
                        (Monthly Rent Amount (Rs.):
                        <input <?php if ($building->physicalBuildingId == $school_physical_facilities->building_id) { ?> required <?php  } ?> style="width: 90px;" type="number" name="rent_amount" value="<?php echo $school_physical_facilities->rent_amount; ?>" placeholder="" id="rent_amount" />

                      </span> <?php } ?>
                    <span style="margin-top: 10px; display: block;"> </span>
                  <?php endforeach; ?>

                  <strong>Land Type</strong><br />
                  <input required type="radio" name="land_type" value="commercial" <?php if ($school_physical_facilities->land_type == 'commercial') {
                                                                                      echo 'checked';
                                                                                    } ?> /> Commercial <span style="margin-left: 10px;"></span>
                  <input required type="radio" name="land_type" value="residential" <?php if ($school_physical_facilities->land_type == 'residential') {
                                                                                      echo 'checked';
                                                                                    } ?> /> Residential
                  <br />
                  <strong>Institute Timing</strong><br />
                  <input required type="radio" name="timing" value="morning" <?php if ($school_physical_facilities->timing == 'morning') {
                                                                                echo 'checked';
                                                                              } ?> /> Morning <span style="margin-left: 10px;"></span>
                  <input required type="radio" name="timing" value="evening" <?php if ($school_physical_facilities->timing == 'evening') {
                                                                                echo 'checked';
                                                                              } ?> /> Evening <span style="margin-left: 10px;"></span>

                  <input required type="radio" name="timing" value="both" <?php if ($school_physical_facilities->timing == 'both') {
                                                                            echo 'checked';
                                                                          } ?> /> Both

                  <br />
                  <strong> Total Number Of Class Rooms: </strong>
                  <input min="0" type="number" required name="numberOfClassRoom" placeholder="No. of Classroom(s)" class="form-control" id="numberOfClassRoom" value="<?php echo $school_physical_facilities->numberOfClassRoom; ?>" />
                  <strong>Others Rooms </strong>
                  <input min="0" type="number" required name="numberOfOtherRoom" placeholder="Office/Staff room/ Store etc." class="form-control" id="numberOfOtherRoom" value="<?php echo $school_physical_facilities->numberOfOtherRoom; ?>" />
                  <strong>Average Class Rooms Size (sq feet)</strong>
                  <input min="0" type="number" required name="avg_class_room_size" placeholder="" class="form-control" id="avg_class_room_size" value="<?php echo $school_physical_facilities->avg_class_room_size; ?>" />

                  <strong> Total Area (in Marla): </strong>
                  <input min="0" type="number" required name="totalArea" placeholder="Enter total Area" class="form-control" id="totalArea" value="<?php echo $school_physical_facilities->totalArea; ?>" />
                  <strong>Covered Area (in Marla): </strong>
                  <input onkeyup="check_total_area()" min="0" type="number" required name="coveredArea" placeholder="Enter Covered Area" class="form-control" id="coveredArea" value="<?php echo $school_physical_facilities->coveredArea; ?>" />
                  <small style="color:red" id="coveredAreaError"></small>



                </div>



              </div>
              <script>
                function set_number_of_toilets() {
                  if ($('#toilet').is(":checked")) {
                    $('#total_toilets').show();
                    //$('#numberOfLatrines').val('');
                    //$('#numberOfLatrines').prop('required', true);
                    $('.washrooms').prop('required', false);

                  } else {
                    $('#total_toilets').hide();
                    // $('#numberOfLatrines').val('');
                    // $('#numberOfLatrines').prop('required', false);
                    $('.washrooms').prop('required', false);
                  }
                }

                function books_detail() {
                  if ($('#library').is(":checked")) {
                    $('#books_detail').show();
                    $('.total_number_of_books').val('');
                    $('.total_number_of_books').prop('required', true);
                  } else {
                    $('#books_detail').hide();
                    $('.total_number_of_books').val('');
                    $('.total_number_of_books').prop('required', false);
                  }
                }

                function science_lab() {
                  if ($('#sciencelab').is(":checked")) {
                    $('#science_lab').show();
                    $('.science_lab').prop('required', true);
                  } else {
                    $('#science_lab').hide();
                    $('.science_lab').val('');
                    $('.science_lab').prop('checked', false);
                    $('.science_lab').prop('required', false);
                  }
                }

                function number_of_computers() {
                  if ($('#computer_lab').is(":checked")) {
                    $('#total_number_of_computer').show();
                    $('#numberOfComputer').val('');
                    $('#numberOfComputer').prop('required', true);
                  } else {
                    $('#total_number_of_computer').hide();
                    $('#numberOfComputer').val('');
                    $('#numberOfComputer').prop('required', false);
                  }
                }
              </script>

              <div class="col-md-6">
                <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                  <h5><strong class="">Whether the following facilities are available in the School?</strong></h5>
                  <strong style="font-size: 15px; margin-top:5px;">Physical:</strong>
                  <br />
                  <?php $query = "SELECT * FROM physical_facilities_physical_meta 
                                  WHERE  school_type_id like '%" . $school->school_type_id . "%'";
                  $physical = $this->db->query($query)->result();
                  ?>
                  <?php if (!empty($physical)) : ?>
                    <?php foreach ($physical as $ph) : ?>
                      <?php if (in_array($ph->physicalId, $facilities_physical_ids)) :  ?>
                        <?php $check = 'checked'; ?>
                      <?php else : ?>
                        <?php $check = ''; ?>
                      <?php endif; ?>
                      <input <?php if ($ph->physicalId == 2) { ?> onclick="set_number_of_toilets()" id="toilet" <?php } ?> type="checkbox" name="pf_physical_id[]" value="<?php echo $ph->physicalId; ?>" <?php echo $check; ?> />
                      <?php echo $ph->physicalTitle; ?>
                      <span style="margin-left: 20px;"></span>
                      <?php if ($ph->physicalId == 2) { ?>
                        <span id="total_toilets" <?php if (!in_array($ph->physicalId, $facilities_physical_ids)) :  ?> style="display: none;" <?php endif; ?>>
                          <table class="table">
                            <tr>
                              <th>Male Washrooms</th>
                              <th>Female Washrooms</th>
                            </tr>
                            <tr>
                              <td>
                                <input min="0" class="washrooms" type="number" value="<?php echo $school_physical_facilities->female_washrooms ?>" name="female_washrooms" />
                              </td>
                              <td>
                                <input min="0" class="washrooms" type="number" value="<?php echo $school_physical_facilities->male_washrooms ?>" name="male_washrooms" />
                              </td>
                            </tr>

                          </table>
                          <span style="display: none;">
                            (Number of Washrooms
                            <input <?php if (in_array($ph->physicalId, $facilities_physical_ids)) :  ?> <?php endif; ?> min="0" style="width: 50px;" type="number" name="numberOfLatrines" id="numberOfLatrines" value="<?php echo $school_physical_facilities->numberOfLatrines; ?>" />
                            )<span style="margin-left: 20px;"></span>
                          </span>

                        </span>
                      <?php } ?>


                    <?php endforeach; ?>
                  <?php else : ?>
                    <span class="text-danger">No Physical found.</span>
                  <?php endif; ?>





                </div>

                <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                  <strong style="font-size: 15px; margin-top:5px;">Academic:</strong>
                  <br />

                  <?php
                  $query = "SELECT * FROM physical_facilities_academic_meta WHERE  school_type_id like '%" . $school->school_type_id . "%'";
                  $academics = $this->db->query($query)->result();
                  //var_dump($academics);
                  if (!empty($academics)) : ?>
                    <?php foreach ($academics as $academic) : ?>

                      <?php if (in_array($academic->academicId, $academic_ids)) :  ?>
                        <?php $check = 'checked';
                        $required = 'required';
                        ?>
                      <?php else : ?>
                        <?php $check = '';
                        $required = '';
                        ?>
                      <?php endif; ?>
                      <input <?php if ($academic->academicId == 1) { ?> onclick="science_lab()" id="sciencelab" <?php } ?> <?php if ($academic->academicId == 2) { ?> onclick="books_detail()" id="library" <?php } ?> <?php if ($academic->academicId == 4) { ?> onclick="number_of_computers()" id="computer_lab" <?php } ?> type="checkbox" name="academic_id[]" value="<?php echo $academic->academicId; ?>" <?php echo $check; ?> />
                      <?php echo $academic->academicTitle; ?>
                      <span style="margin-left: 20px;"></span>
                      </span>


                      <?php if ($academic->academicId == 1) { ?>
                        <br />
                        <table id="science_lab" class="table table-bordered" style="margin-top: 10px; <?php if (!in_array($academic->academicId, $academic_ids)) {  ?>display: none; <?php } ?>">

                          <tbody>
                            <?php if ($school->level_of_school_id == 3 or (in_array(3, $upgradation_levels) and !in_array(4, $upgradation_levels))) { ?>
                              <tr>
                                <th>#</th>
                                <th colspan="2">HIGH LEVEL Lab: </th>

                              </tr>
                              <tr>
                                <th>1.</th>
                                <th>Dedicated Science Lab</th>
                                <th><input <?php if ($school_physical_facilities->high_science_lab == 'Yes') {
                                              echo 'checked';
                                            } ?> type="radio" class="science_lab" name="high_science_lab" value="Yes" <?php echo $required; ?> /> Yes
                                  <span style="margin-left: 10px;"></span>
                                  <input <?php if ($school_physical_facilities->high_science_lab == 'No') {
                                            echo 'checked';
                                          } ?> type="radio" class="science_lab" name="high_science_lab" value="No" <?php echo $required; ?> /> No
                                </th>

                              </tr>
                            <?php } ?>
                            <?php if ($school->level_of_school_id == 4 or  in_array(4, $upgradation_levels)) { ?>
                              <tr>
                                <th>#</th>
                                <th colspan="2">HIGHER Sec. LEVEL Science Labs: </th>

                              </tr>

                              <tr>
                                <th>1.</th>
                                <th>Dedicated Physics Lab</th>
                                <th><input <?php if ($school_physical_facilities->physics_lab == 'Yes') {
                                              echo 'checked';
                                            } ?> type="radio" class="science_lab" name="physics_lab" value="Yes" <?php echo $required; ?> /> Yes
                                  <span style="margin-left: 10px;"></span>
                                  <input <?php if ($school_physical_facilities->physics_lab == 'No') {
                                            echo 'checked';
                                          } ?> type="radio" class="science_lab" name="physics_lab" value="No" <?php echo $required; ?> /> No
                                </th>

                              </tr>
                              <tr>
                                <th>2.</th>
                                <th>Dedicated Chemistry Lab</th>
                                <th><input <?php if ($school_physical_facilities->chemistry_lab == 'Yes') {
                                              echo 'checked';
                                            } ?> type="radio" class="science_lab" name="chemistry_lab" value="Yes" <?php echo $required; ?> /> Yes
                                  <span style="margin-left: 10px;"></span>
                                  <input <?php if ($school_physical_facilities->chemistry_lab == 'No') {
                                            echo 'checked';
                                          } ?> type="radio" class="science_lab" name="chemistry_lab" value="No" <?php echo $required; ?> /> No
                                </th>

                              </tr>
                              <tr>
                                <th>3.</th>
                                <th>Dedicated Biology Lab</th>
                                <th><input <?php if ($school_physical_facilities->biology_lab == 'Yes') {
                                              echo 'checked';
                                            } ?> type="radio" class="science_lab" name="biology_lab" value="Yes" <?php echo $required; ?> /> Yes
                                  <span style="margin-left: 10px;"></span>
                                  <input <?php if ($school_physical_facilities->biology_lab == 'No') {
                                            echo 'checked';
                                          } ?> type="radio" class="science_lab" name="biology_lab" value="No" <?php echo $required; ?> /> No
                                </th>

                              </tr>
                            <?php } ?>

                          </tbody>
                        </table>

                      <?php } ?>

                      <?php if ($academic->academicId == 2) { ?>
                        <br />
                        <table id="books_detail" class="table table-bordered" style="margin-top: 10px; <?php if (!in_array($academic->academicId, $academic_ids)) {  ?>display: none; <?php } ?>">
                          <thead>
                            <th colspan="<?php echo count($book_types); ?>" class="text-center">

                              Library Book Detail</th>
                          </thead>
                          <tbody>
                            <tr>
                              <?php foreach ($book_types as $library) : ?>

                                <th><?php echo $library->bookType; ?></th>

                              <?php endforeach; ?>
                            </tr>
                            <tr>
                              <?php foreach ($book_types as $library) :
                                $query = "SELECT numberOfBooks FROM school_library 
                                        WHERE `book_type_id` = '" . $library->bookTypeId . "'
                                        AND school_id = '" . $school_id . "'";
                                $library_book_total = $this->db->query($query)->result()[0]->numberOfBooks;
                              ?>

                                <td>
                                  <input <?php if (in_array($academic->academicId, $academic_ids)) {  ?> required <?php } ?> class="total_number_of_books" style="width: 100%;" min="0" type="number" name="libary_books[<?php echo $library->bookTypeId; ?>]" value="<?php echo $library_book_total; ?>" />
                                </td>

                              <?php endforeach; ?>
                            </tr>
                          </tbody>
                        </table>
                        <br />
                      <?php } ?>

                      <?php if ($academic->academicId == 4) { ?>
                        <?php //if (!empty($school_physical_facilities->numberOfComputer)) : 
                        ?>
                        <span id="total_number_of_computer" style="<?php if (!in_array($academic->academicId, $academic_ids)) {  ?>display: none; <?php } ?>">
                          <span style="margin-left: 20px;"></span>
                          ( Number of Computers: <input style="width: 50px;" type="number" name="numberOfComputer" placeholder="0" id="numberOfComputer" value="<?php echo $school_physical_facilities->numberOfComputer; ?>" />)
                        </span>
                        <?php // endif; 
                        ?>
                      <?php } ?>

                    <?php endforeach; ?>
                  <?php else : ?>
                    <span class="text-danger">No Academic found.</span>
                  <?php endif; ?>



                </div>





              </div>

              <div class="col-md-3">


                <?php $query = "SELECT * FROM physical_facilities_co_curricular_meta 
                                  WHERE  school_type_id like '%" . $school->school_type_id . "%'";
                $co_curriculars = $this->db->query($query)->result();
                ?>
                <?php if (!empty($co_curriculars)) { ?>
                  <div style="font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">

                    <strong style="font-size: 15px; margin-top:5px;">Co-Curricular:</strong>
                    <?php foreach ($co_curriculars as $co_curricular) : ?>
                      <br />
                      <?php if (in_array($co_curricular->coCurricularId, $curricular_ids)) :  ?>
                        <?php $check = 'checked'; ?>
                      <?php else : ?>
                        <?php $check = ''; ?>
                      <?php endif; ?>
                      <input type="checkbox" name="co_curricular_id[]" value="<?php echo $co_curricular->coCurricularId; ?>" <?php echo $check; ?> />
                      <?php echo $co_curricular->coCurricularTitle; ?>
                      <span style="margin-left: 20px;"></span>
                    <?php endforeach; ?>
                  </div>

                <?php } ?>

                <?php $query = "SELECT * FROM physical_facilities_others_meta 
                                  WHERE  school_type_id like '%" . $school->school_type_id . "%'";
                $other = $this->db->query($query)->result();
                ?>
                <?php if (!empty($other)) { ?>
                  <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                    <strong style="font-size: 15px; margin-top:5px;">Others:</strong>
                    <?php foreach ($other as $oth) : ?>
                      <br />
                      <?php if (in_array($oth->otherId, $other_ids)) :  ?>
                        <?php $check = 'checked'; ?>
                      <?php else : ?>
                        <?php $check = ''; ?>
                      <?php endif; ?>

                      <input type="checkbox" name="other_id[]" value="<?php echo $oth->otherId; ?>" <?php echo $check; ?> />
                      <?php echo $oth->otherTitle; ?>
                      <span style="margin-left: 20px;"></span>
                    <?php endforeach; ?>
                  </div>
                <?php } ?>

                <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">

                  <?php
                  $query = "select gender_type_id FROM school WHERE schoolId = '" . $school_id . "'";
                  $school_gender = $this->db->query($query)->row();
                  ?>
                  <?php if ($school->registrationNumber or 1 == 1) { ?>
                    <strong> Gender of Education <small>(Institute)</small> </strong>

                    <br />
                    <input type="radio" name="gender_type_id" value="1" <?php if ($school_gender->gender_type_id === "1") {
                                                                          echo "checked";
                                                                        } ?> required /> Boys <span style="margin-left: 10px;"></span>
                    <input type="radio" name="gender_type_id" value="2" <?php if ($school_gender->gender_type_id === "2") {
                                                                          echo "checked";
                                                                        } ?> required /> Girls <span style="margin-left: 10px;"></span>

                    <input type="radio" name="gender_type_id" value="3" <?php if ($school_gender->gender_type_id === "3") {
                                                                          echo "checked";
                                                                        } ?> required /> Co-Education

                    <br />
                  <?php } else { ?>
                    <input type="hidden" name="gender_type_id" value="<?php echo $school_gender->gender_type_id ?>" />
                  <?php  } ?>

                  <?php
                  $query = "select a_o_level, telePhoneNumber, schoolMobileNumber, principal_email FROM schools WHERE schoolId = '" . $schools_id . "'";
                  $school_more_info = $this->db->query($query)->row();
                  //var_dump($a_o_level);
                  ?>
                  <?php if ($school->school_type_id == 1) { ?>
                    <?php if ($school->level_of_school_id >= 4 or  in_array(3, $upgradation_levels) or   in_array(4, $upgradation_levels)) { ?>

                      <strong> Do Institute offer O Level and A level </strong>

                      <br />
                      <input type="radio" name="a_o_level" value="1" <?php if ($school_more_info->a_o_level === "1") {
                                                                        echo "checked";
                                                                      } ?> required /> Yes <span style="margin-left: 10px;"></span>
                      <input type="radio" name="a_o_level" value="0" <?php if ($school_more_info->a_o_level === "0") {
                                                                        echo "checked";
                                                                      } ?> required /> No

                      <br />
                    <?php } else { ?>
                      <input type="hidden" name="a_o_level" value="0" />
                    <?php } ?>

                  <?php } ?>
                  <?php if ($school->registrationNumber) { ?>
                    <strong> Do you want to change institute contact details </strong> <br />
                    Telephone No: <input id="telePhoneNumber" class="form-control" required type="text" value="<?php echo $school_more_info->telePhoneNumber; ?>" name="telePhoneNumber" /> <br />
                    Mobile No: <input id="schoolMobileNumber" class="form-control" required type="text" value="<?php echo $school_more_info->schoolMobileNumber; ?>" name="schoolMobileNumber" />
                    Email Address: <small>(Optional)</small>
                    <input class="form-control" type="email" value="<?php echo $school_more_info->principal_email; ?>" name="principal_email" />

                    <br />
                    <br />
                  <?php } else { ?>
                    <input id="telePhoneNumber" type="hidden" value="<?php echo $school_more_info->telePhoneNumber; ?>" name="telePhoneNumber" /> <br />
                    <input id="schoolMobileNumber" type="hidden" value="<?php echo $school_more_info->schoolMobileNumber; ?>" name="schoolMobileNumber" />
                    <input class="form-control" type="hidden" value="<?php echo $school_more_info->principal_email; ?>" name="principal_email" />


                  <?php } ?>

                  <strong> <?php echo $session_detail->sessionYearTitle; ?> session head of institute, <i>Principal, Head Master, Director etc</i> </strong>
                  <?php
                  $query = "select principal_cnic,principal,principal_contact_no FROM school WHERE schoolId = '" . $school_id . "'";
                  $principal = $this->db->query($query)->row();
                  ?>

                  <table class="table">
                    <tr>
                      <td style="width: 10px;"> Name: </td>
                      <td> <input type="text" name="principal" value="<?php if ($principal->principal) {
                                                                        echo $principal->principal;
                                                                      } ?>" style="width: 100%;" required /></td>
                    </tr>
                    <tr>
                      <td> CNIC: </td>
                      <td> <input maxlength="15" id="principal_cnic" type="text" name="principal_cnic" value="<?php if ($principal->principal_cnic) {
                                                                                                                echo $principal->principal_cnic;
                                                                                                              } ?>" style="width: 100%;" required /></td>
                    </tr>
                    <tr>
                      <td> Contact: </td>
                      <td> <input maxlength="15" id="principal_contact_no" type="text" name="principal_contact_no" value="<?php if ($principal->principal_contact_no) {
                                                                                                                            echo $principal->principal_contact_no;
                                                                                                                          } ?>" style="width: 100%;" required /></td>
                    </tr>
                  </table>


                </div>


              </div>
              <script>
                function check_total_area() {
                  coveredArea = parseInt($('#coveredArea').val());
                  totalArea = parseInt($('#totalArea').val());

                  if (coveredArea > totalArea) {
                    //alert("Coverd Area not greater than, Total Area.");
                    $('#coveredArea').val('');
                    $('#coveredAreaError').html("Coverd Area not greater than, Total Area.");
                    return false;
                  } else {
                    $('#coveredAreaError').html("");
                  }

                }
              </script>




          </div>



          <div style="font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">



            <div class="row">
              <div class="col-md-6">
                <?php if ($form_status->form_b_status == 1) { ?>
                  <input style="margin: 3px;" onclick="check_total_area()" class="btn btn-primary" type="submit" name="update" value="Update Section B Data" />
                <?php } else { ?>
                  <input style="margin: 3px;" onclick="check_total_area()" class="btn btn-danger" type="submit" name="update" value="Add Section B Data" />
                <?php } ?>
              </div>
              <div class="col-md-6">
                <?php if ($form_status->form_b_status == 1) { ?>
                  <button name="update" value="save_next" class="btn btn-success" onclick="check_total_area()">
                    Save and Next (Students Enrolment) <i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i>
                  </button>

                  <!-- <a class="btn btn-success" style="margin: 5px;" href="<?php echo site_url("form/section_c/$school_id"); ?>">
                    Next Section (Students Enrolment) <i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i>
                  </a> -->
                <?php } ?>
              </div>

            </div>
          </div>
          </form>

        </div>


      </div>

  </div>


  </section>

  </div>

  <script src="<?php echo base_url('assets/lib/plugins/input-mask/jquery.inputmask.js'); ?>"></script>

  <script>
    $(document).ready(function() {
      $('#telePhoneNumber').inputmask('99999999999');
      $('#schoolMobileNumber').inputmask('(9999)-9999999');
      $('#principal_contact_no').inputmask('(9999)-9999999');
      $('#principal_cnic').inputmask('99999-9999999-9');

      $("#principal_cnic").inputmask({
        "mask": "99999-9999999-9"
      }, {
        oncomplete: function() {
          //Do something
        }
      });


    });
  </script>