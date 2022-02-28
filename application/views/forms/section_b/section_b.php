  <!-- Modal -->
  <script>
    function get_employee_edit_form(employee_id) {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("form/get_employee_edit_form"); ?>",
        data: {
          employee_id: employee_id,
          schools_id: <?php echo $school->schoolId; ?>,
          school_id: <?php echo $school_id; ?>,
          session_id: <?php echo $session_id; ?>

        }
      }).done(function(data) {

        $('#get_employee_edit_form_body').html(data);
      });

      $('#get_employee_edit_form_model').modal('toggle');
    }
  </script>
  <div class="modal fade" id="get_employee_edit_form_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="get_employee_edit_form_body">

        ...

      </div>
    </div>
  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2 style="display:inline;"><?php echo ucwords(strtolower($school->schoolName)); ?>

      </h2>
      <br />
      <small>
        <h4>S-ID: <?php echo $school->schools_id; ?> <?php if ($school->registrationNumber) { ?> - REG No: <?php echo $school->registrationNumber ?> <?php } ?></h4>
      </small>
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
              <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px"><strong>SECTION B (PHYSICAL FACILITIES)</strong><br />

              </h4>
            </div>

            <form class="form-horizontal" method="post" id="Form1" action="<?php echo base_url('form/update_form_b_data'); ?>">
              <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
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


                  <br />
                  <strong> Total Number Of Class Rooms: </strong>
                  <input min="0" type="number" required name="numberOfClassRoom" placeholder="No. of Classroom(s)" class="form-control" id="numberOfClassRoom" value="<?php echo $school_physical_facilities->numberOfClassRoom; ?>" />
                  <strong>Others Rooms </strong>
                  <input min="0" type="number" required name="numberOfOtherRoom" placeholder="Office/Staff room/ Store etc." class="form-control" id="numberOfOtherRoom" value="<?php echo $school_physical_facilities->numberOfOtherRoom; ?>" />

                  <strong> Total Area (in marlas): </strong>
                  <input min="0" type="number" required name="totalArea" placeholder="Enter total Area" class="form-control" id="totalArea" value="<?php echo $school_physical_facilities->totalArea; ?>" />
                  <strong>Covered Area (in Marlas): </strong>
                  <input onkeyup="check_total_area()" min="0" type="number" required name="coveredArea" placeholder="Enter Covered Area" class="form-control" id="coveredArea" value="<?php echo $school_physical_facilities->coveredArea; ?>" />
                  <small style="color:red" id="coveredAreaError"></small>



                </div>



              </div>
              <script>
                function set_number_of_toilets() {
                  if ($('#toilet').is(":checked")) {
                    $('#total_toilets').show();
                    $('#numberOfLatrines').val('');
                    $('#numberOfLatrines').prop('required', true);
                  } else {
                    $('#total_toilets').hide();
                    $('#numberOfLatrines').val('');
                    $('#numberOfLatrines').prop('required', false);
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


                          (Number of Toilets
                          <input <?php if (in_array($ph->physicalId, $facilities_physical_ids)) :  ?> required <?php endif; ?> min="1" style="width: 50px;" type="number" name="numberOfLatrines" id="numberOfLatrines" value="<?php echo $school_physical_facilities->numberOfLatrines; ?>">
                          )<span style="margin-left: 20px;"></span>

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

                  <?php if (!empty($academics)) : ?>
                    <?php foreach ($academics as $academic) : ?>

                      <?php if (in_array($academic->academicId, $academic_ids)) :  ?>
                        <?php $check = 'checked'; ?>
                      <?php else : ?>
                        <?php $check = ''; ?>
                      <?php endif; ?>
                      <input <?php if ($academic->academicId == 2) { ?> onclick="books_detail()" id="library" <?php } ?> <?php if ($academic->academicId == 4) { ?> onclick="number_of_computers()" id="computer_lab" <?php } ?> type="checkbox" name="academic_id[]" value="<?php echo $academic->academicId; ?>" <?php echo $check; ?> />
                      <?php echo $academic->academicTitle; ?>
                      <span style="margin-left: 20px;"></span>

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
                <div style="font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">

                  <strong style="font-size: 15px; margin-top:5px;">Co-Curricular:</strong>

                  <?php if (!empty($co_curriculars)) : ?>

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
                  <?php else : ?>
                    <span class="text-danger">No Co-Curricular found.</span>
                  <?php endif; ?>

                </div>



                <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                  <strong style="font-size: 15px; margin-top:5px;">Others:</strong>

                  <?php if (!empty($other)) : ?>
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
                  <?php else : ?>
                    <span class="text-danger">No Other found.</span>
                  <?php endif; ?>


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

              <div class="col-md-12">
                <div style="font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                  <?php if ($form_status->form_b_status == 1) { ?>
                    <input onclick="check_total_area()" class="btn btn-primary" type="submit" name="" value="Update Section B Data" />
                  <?php } else { ?>
                    <input onclick="check_total_area()" class="btn btn-danger" type="submit" name="" value="Add Section B Data" />
                  <?php } ?>
                  <?php if ($form_status->form_b_status == 1) { ?>
                    <a class="btn btn-success pull-right" href="<?php echo site_url("form/section_c/$school_id"); ?>">
                      Next Section (Students Enrolment) <i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i></a>

                  <?php } ?>
                </div>
              </div>
            </form>

          </div>
        </div>


      </div>

  </div>


  </section>

  </div>

  <script>
    $(document).ready(function() {
      $('#schoolStaffCnic').inputmask('99999-9999999-9');

    });
  </script>