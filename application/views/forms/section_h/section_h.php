  <!-- Modal -->
  <script>
    // function update_class_fee_detail(class_id) {
    //   $.ajax({
    //     type: "POST",
    //     url: "<?php //echo site_url("form/update_class_fee_from"); 
                  ?>",
    //     data: {
    //       schools_id: <?php //echo $school->schoolId; 
                          ?>,
    //       class_id: class_id,
    //       school_id: <?php //echo $school_id; 
                        ?>,
    //       session_id: <?php //echo $session_id; 
                          ?>
    //     }
    //   }).done(function(data) {

    //     $('#update_class_ages_body').html(data);
    //   });

    //   $('#update_class_ages').modal('toggle');
    // }
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
    <?php $this->load->view('forms/form_header');   ?>

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
              <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px"><strong>SECTION H</strong> ( Institute Vehicles list / Fee Concession / Pashtu, Regional languages / Textbooks )<br />
                <small style="color: red;">
                  Note: Every option is mandatory. you can fill with min value of 0.
                </small>
              </h4>

              </small>
              </p>




              <div class="col-md-12">
                <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 10px; padding: 10px; background-color: white;">
                  <h4>Institute Vehicles Detail</h4>
                  <script>
                    function delete_vehicle_date(vehicle_id) {
                      $.ajax({
                          method: "POST",
                          url: "<?php echo site_url('Temp_controller/delete_vehicle_data'); ?>",
                          data: {
                            vehicle_id: vehicle_id,
                            school_id: <?php echo $schools_id; ?>
                          }
                        })
                        .done(function(msg) {
                          $('#vehicle_list').html(msg);
                        });
                    }

                    function add_vehicle_info() {
                      var vehicle_number = $('#vehicle_number').val();
                      if (vehicle_number == '') {
                        alert('Please enter Vehicle No');
                        return false;
                      }
                      var vehicle_model_year = $('#vehicle_model_year').val();
                      if (vehicle_model_year == '' || vehicle_model_year == 0) {
                        alert('Please Select Vehicle Model Year.');
                        return false;
                      }



                      var type_of_vehicle = $('#type_of_vehicle').val();
                      if (type_of_vehicle == '') {
                        alert('Type of Vehicle Required');
                        return false;
                      }

                      var total_seats = $('#total_seats').val();
                      if (total_seats == '') {
                        alert('Total Seats Required');
                        return false;
                      }
                      if (total_seats > 100) {
                        alert('Please mention seats between 5 and 100.');
                        return false;
                      }
                      if (total_seats < 5) {
                        alert('Seats should not be less than 5.');
                        return false;
                      }

                      var expiry_of_fit_certificate = $('#expiry_of_fit_certificate').val();
                      $.ajax({
                          method: "POST",
                          url: "<?php echo site_url('Temp_controller/temp_vehicle'); ?>",
                          data: {
                            vehicle_number: vehicle_number,
                            vehicle_model_year: vehicle_model_year,
                            total_seats: total_seats,
                            type_of_vehicle: type_of_vehicle,
                            expiry_of_fit_certificate: expiry_of_fit_certificate,
                            school_id: <?php echo $schools_id; ?>
                          }
                        })
                        .done(function(msg) {
                          $('#vehicle_list').html(msg);
                          $('#total_seats').val("");
                          $('#vehicle_number').val("");
                          $('#vehicle_model_year').val("");
                        });
                    }
                  </script>
                  <div style="margin: 5px; padding:5px; background-color: #F1F2F4;">
                    <div class="row">
                      <div class="form-group col-md-2">
                        <label for="vehicle_number">Vehicle No</label>
                        <input placeholder="Vehicle Number" class="form-control" type="text" id="vehicle_number" name="vehicle_number" required>
                      </div>
                      <div class="form-group col-md-2">
                        <label for="vehicle_model_year">Model Year</label>
                        <select class="form-control" name="vehicle_model_year" id="vehicle_model_year" required>
                          <option value="0">Select Year</option>
                          <?php for ($years = 2023; $years >= 1950; $years--) { ?>
                            <option value="<?php echo $years; ?>"><?php echo $years; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group col-md-2">
                        <label for="type_of_vehicle">Type of Vehicle</label>
                        <input placeholder="Couster, Bus, Van, Coach etc" class="form-control" style="width: 100% !important;" type="text" id="type_of_vehicle" name="type_of_vehicle" required>
                      </div>
                      <div class="form-group col-md-2">
                        <label for="expiry_of_fit_certificate"><small>Fitness Certificate (Expiry Date)</small></label>
                        <input class="form-control" style="width: 100% !important;" type="date" id="expiry_of_fit_certificate" name="expiry_of_fit_certificate" required>
                      </div>
                      <div class="form-group col-md-2">
                        <label for="total_seats">Total No. of Seats</label>
                        <input placeholder="10, 20, 50 etc" class="form-control" min="5" max="100" style="width: 100% !important;" title="10" type="number" id="total_seats" name="total_seats" required>

                      </div>
                      <div class="form-group col-md-2">

                        <br />
                        <input onclick="add_vehicle_info()" type="button" class="btn btn-primary btn-sm" value="Add Vehicle Detail">

                      </div>
                    </div>
                  </div>

                  <div class="table-responsive" id="vehicle_list">
                    <table class="table" style="font-size: 13px;">
                      <tr>
                        <th>S/No</td>
                        <th>Vehicle No.</th>
                        <th>Model Year</th>
                        <th>Type of Vehicle</th>
                        <th>Fitness Certificate (Expiry Date)</th>
                        <th>Total No. of Seats</th>
                        <th>Action</th>
                      </tr>
                      <?php $query = "SELECT * FROM school_vehicles WHERE school_id = '" . $schools_id . "'";
                      $school_vehicles = $this->db->query($query)->result();
                      if ($school_vehicles) {
                        $count = 1;
                        foreach ($school_vehicles as $school_vehicle) { ?>
                          <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $school_vehicle->vehicle_number; ?></td>
                            <td><?php echo $school_vehicle->vehicle_model_year; ?></td>
                            <td><?php echo $school_vehicle->type_of_vehicle; ?></td>
                            <td><?php
                                // echo $school_vehicle->expiry_of_fit_certificate;
                                if ($school_vehicle->expiry_of_fit_certificate != '0000-00-00') {
                                  echo date('d M, Y', strtotime($school_vehicle->expiry_of_fit_certificate));
                                } ?></td>
                            <td><?php echo $school_vehicle->total_seats; ?></td>

                            <td><a href="#" onclick="delete_vehicle_date(<?php echo $school_vehicle->vehicle_id ?>)">delete</a></td>

                          </tr>
                        <?php } ?>
                      <?php } ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="col-md-6">
                <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 10px; padding: 10px; background-color: white;">
                  <h4>Fee Concession</h4>
                  <small style="color: red;">
                    Note: Every option is mandatory. you can fill with min value of 0.
                  </small>
                  <form method="post" action="<?php echo site_url("form/update_form_h_data"); ?>">
                    <input type="hidden" name="school_id" value="<?php echo $school_id ?>" />
                    <input type="hidden" name="schools_id" value="<?php echo $schools_id ?>" />

                    <input type="hidden" name="session_id" value="<?php echo $session_id ?>" />
                    <table class="table table-bordered">
                      <thead class="small_font">
                        <tr>
                          <th>#</th>
                          <th>Concession Type</th>
                          <th>Total Students On Fee Concession</th>
                          <th>Fee Concession (In Precentage)</th>

                        </tr>
                      </thead>
                      <tbody class="small_font">
                        <?php $counter = 1; ?>
                        <?php
                        $query = "SELECT * FROM `concession_type`";
                        $fee_cencession_types = $this->db->query($query)->result();

                        ?>
                        <?php foreach ($fee_cencession_types as $fee_cencession_type) :
                          $query = "SELECT * FROM `fee_concession`
                            WHERE school_id = '" . $school_id . "'
                            AND concession_id = '" . $fee_cencession_type->concessionTypeId . "'";
                          $concession = $this->db->query($query)->result()[0];
                        ?>
                          <tr>
                            <th><?php echo $counter; ?></th>
                            <th><?php echo $fee_cencession_type->concessionTypeTitle; ?>

                            </th>
                            <td><input min="0" required type="number" style="width: 100px;" name="concession_types[<?php echo $fee_cencession_type->concessionTypeId; ?>][numberOfStudent]" value="<?php echo $concession->numberOfStudent; ?>" /></td>
                            <td><input min="0" max="100" required type="number" name="concession_types[<?php echo $fee_cencession_type->concessionTypeId; ?>][percentage]" value="<?php echo $concession->percentage; ?>" /> <strong> % </strong></td>

                          </tr>
                          <?php $counter++; ?>
                        <?php endforeach; ?>


                        </td>


                      </tbody>
                    </table>

                </div>
                <?php

                $query = "SELECT level_of_school_id as max_level, 
              session_year_id as session_id,
              schoolId as current_session_school_id 
              FROM school
              WHERE schoolId = '" . $school_id . "'
              AND schools_id = '" . $schools_id . "'";
                $current_session = $this->db->query($query)->row();
                $max_level = $current_session->max_level;

                $query = "SELECT * FROM textbooks 
                                      WHERE school_id = '" . $schools_id . "' 
                                      AND session_id = '" . $current_session->session_id . "'";
                $text_book = $this->db->query($query)->row();
                ?>
                <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 10px; padding: 10px; background-color: white;">
                  <h4>Pashtu / Regional languages</h4>
                  Whether Pashtu / Regional languages are being taught in your school ?
                  <span style="margin: 5px;"></span>
                  <input <?php if ($text_book->regional_language == 'Yes') { ?> checked <?php } ?> onclick="$('#language').show(); $('#comment').hide(); $('.level_language').attr('required', 'true')" required type="radio" name="regional_language" value="Yes" id=""> Yes
                  <span style="margin: 10px;"></span>
                  <input <?php if ($text_book->regional_language == 'No') { ?> checked <?php } ?> onclick="$('#language').hide(); $('#comment').show();  $('.level_language').removeAttr('required'); $('.lang2').removeAttr('required');" required type="radio" name="regional_language" value="No" id=""> No

                  <div id="language" style="margin-top: 10px; <?php if (!$text_book) { ?> display:none <?php } ?> <?php if ($text_book->regional_language == 'No') { ?> display:none <?php } ?>">

                    Pashtu / Regional languages are being taught in <br />
                    <?php


                    $min_level = array();
                    echo  $query = "select SUM(`s`.`enrolled`) as total FROM
                `age_and_class` as `s` 
            where `s`.`class_id` in (1,2,3,4,5,6,7)
            AND `s`.`school_id` = '" . $current_session->current_session_school_id . "'";
                    $primary = $this->db->query($query)->row()->total;
                    if ($primary) {
                      $min_level[] = 1;
                    }

                    $query = "select SUM(`s`.`enrolled`) as total FROM
          `age_and_class` as `s` 
      where `s`.`class_id` in (9,10,11)
      AND `s`.`school_id` = '" . $current_session->current_session_school_id . "'";
                    $middle = $this->db->query($query)->row()->total;
                    if ($middle) {
                      $min_level[] = 2;
                    }
                    $query = "select SUM(`s`.`enrolled`) as total FROM
          `age_and_class` as `s` 
      where `s`.`class_id` in (12,13)
      AND `s`.`school_id` = '" . $current_session->current_session_school_id . "'";
                    $high = $this->db->query($query)->row()->total;
                    if ($high) {
                      $min_level[] = 3;
                    }

                    $query = "select SUM(`s`.`enrolled`) as total FROM
          `age_and_class` as `s` 
      where `s`.`class_id` in (14,15)
      AND `s`.`school_id` = '" . $current_session->current_session_school_id . "'";
                    $high_sec = $this->db->query($query)->row()->total;
                    if ($high_sec) {
                      $min_level[] = 4;
                    }

                    var_dump($min_level);
                    // its only for renewal and registration
                    // if (!$min_level) {
                    //   $min_level = 1;
                    // } else {
                    //   $min_level = min($min_level);
                    // }

                    // echo $query = "SELECT * FROM `levelofinstitute` WHERE levelofInstituteId >='" . $min_level . "' 
                    // AND levelofInstituteId<= '" . $max_level . "'";
                    echo $query = "SELECT * FROM `levelofinstitute` 
                              WHERE levelofInstituteId IN(" . implode(",", $min_level) . ")";

                    $levels = $this->db->query($query)->result();



                    foreach ($levels as $key => $level) {

                      if ($text_book) {
                        if ($level->levelofInstituteId == 1) {
                          $rg = $text_book->rl_primary;
                          if ($rg) {
                            $level_language = 'Yes';
                          } else {
                            $level_language = 'No';
                          }
                        }
                        if ($level->levelofInstituteId == 2) {
                          $rg = $text_book->rl_middle;
                          if ($rg) {
                            $level_language = 'Yes';
                          } else {
                            $level_language = 'No';
                          }
                        }
                        if ($level->levelofInstituteId == 3) {
                          $rg = $text_book->rl_high;
                          if ($rg) {
                            $level_language = 'Yes';
                          } else {
                            $level_language = 'No';
                          }
                        }
                        if ($level->levelofInstituteId == 4) {
                          $rg = $text_book->rl_high_sec;
                          if ($rg) {
                            $level_language = 'Yes';
                          } else {
                            $level_language = 'No';
                          }
                        }
                      }
                    ?>
                      <strong><?php echo $level->levelofInstituteTitle; ?>-Level</strong> classes ?
                      <span style="margin: 5px;"></span>
                      <input class="level_language" <?php if ($level_language == 'Yes' && $text_book) { ?> checked <?php } ?> onclick="$('#level_language_<?php echo $level->levelofInstituteId; ?>').show(); $('.language_<?php echo $level->levelofInstituteId; ?>').attr('required', 'true')" type="radio" name="rg[<?php echo $level->levelofInstituteId; ?>]" value="Yes" id=""> Yes
                      <span style="margin: 10px;"></span>
                      <input class="level_language" <?php if ($level_language == 'No' && $text_book) { ?> checked <?php } ?> onclick="$('#level_language_<?php echo $level->levelofInstituteId; ?>').hide(); $('.language_<?php echo $level->levelofInstituteId; ?>').removeAttr('required'); $('.language_<?php echo $level->levelofInstituteId; ?>').prop('checked', false);" type="radio" name="rg[<?php echo $level->levelofInstituteId; ?>]" value="No" id=""> No

                      <div class="btn btn-primary" id="level_language_<?php echo $level->levelofInstituteId; ?>" <?php if (!$text_book) { ?>style="display:none" <?php } ?> <?php if ($text_book && $level_language == 'No') { ?>style="display:none" <?php } ?>>
                        Select Language:
                        <span style="margin: 10px;"></span>
                        <input <?php if ($rg == 'Pashtu') { ?> checked <?php } ?> class="lang2 language_<?php echo $level->levelofInstituteId; ?>" type="radio" name="language[<?php echo $level->levelofInstituteId; ?>]" value="Pashtu" /> Pashto
                        <span style="margin: 5px;"></span>
                        <input <?php if ($rg == 'Hindko') { ?> checked <?php } ?> class="lang2 language_<?php echo $level->levelofInstituteId; ?>" type="radio" name="language[<?php echo $level->levelofInstituteId; ?>]" value="Hindko" /> Hindko
                        <span style="margin: 5px;"></span>
                        <input <?php if ($rg == 'Khowar') { ?> checked <?php } ?> class="lang2 language_<?php echo $level->levelofInstituteId; ?>" type="radio" name="language[<?php echo $level->levelofInstituteId; ?>]" value="Khowar" /> Khowar
                        <span style="margin: 5px;"></span>
                        <input <?php if ($rg == 'Seraiki') { ?> checked <?php } ?> class="lang2 language_<?php echo $level->levelofInstituteId; ?>" type="radio" name="language[<?php echo $level->levelofInstituteId; ?>]" value="Seraiki" /> Seraiki
                        <span style="margin: 5px;"></span>
                        <input <?php if ($rg == 'Kohistani') { ?> checked <?php } ?> class="lang2 language_<?php echo $level->levelofInstituteId; ?>" type="radio" name="language[<?php echo $level->levelofInstituteId; ?>]" value="Kohistani" /> Kohistani
                        <span style="margin: 5px;"></span>
                      </div>
                      <br />
                    <?php } ?>

                  </div>

                  <div id="comment" style="margin-top: 10px; <?php if (!$text_book) { ?> display:none <?php } ?><?php if ($text_book->regional_language == 'Yes') { ?> display:none <?php } ?>">
                    <strong>Please comment</strong>
                    <textarea style="width: 100%; border-radius:5px; padding-top:2px;" name="comment"><?php echo $text_book->comment; ?></textarea>
                  </div>

                </div>

              </div>
              <div class="col-md-6">

                <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 236px;  margin: 3px; padding: 3px; background-color: white;">


                  <input type="hidden" name="session_id" value="<?php echo $current_session->session_id; ?>" />


                  <h4>Which Textbooks being taught in school?</h4>

                  <small id="emailHelp" class="form-text text-muted" style="color: green;">
                    If the publisher's name isn't listed, please search 'Other' option and select. write the publisher's name in the provided box.
                    <br />
                    <p style="font-family: 'Noto Nastaliq Urdu Draft', serif; direction: ltr; color:red; text-align:right ">
                      اگر پبلشر کا نام نہیں ہے تو، براہ کرم 'دیگر' آپشن تلاش کریں اور منتخب کریں۔ فراہم کردہ باکس میں پبلشر کا نام لکھیں۔
                    </p>
                  </small>

                  <strong>Which publisher's textbooks are being taught in</strong>
                  <?php

                  $query = "SELECT * FROM `publishers`";
                  $publishers = $this->db->query($query)->result();


                  $publisher_id = 0;
                  foreach ($levels as $key => $level) { ?>
                    <div style="margin: 5px; padding:5px; background-color: #F1F2F4;">
                      <div class="form-group">
                        <label for="<?php echo $level->levelofInstituteTitle; ?>">
                          <strong><?php echo $level->levelofInstituteTitle; ?>-Level</strong> classes?
                        </label>
                        <select class="publisher_list form-control" style="width: 100% !important;" id="<?php echo $level->levelofInstituteTitle; ?>" name="levels[<?php echo $level->levelofInstituteId; ?>]" required>
                          <option value="">Select Publisher</option>
                          <?php
                          if ($text_book) {
                            if ($level->levelofInstituteId == 1) {
                              $publisher_id = $text_book->primary;
                            }
                            if ($level->levelofInstituteId == 2) {
                              $publisher_id = $text_book->middle;
                            }
                            if ($level->levelofInstituteId == 3) {
                              $publisher_id = $text_book->high;
                            }
                            if ($level->levelofInstituteId == 4) {
                              $publisher_id = $text_book->high_sec;
                            }
                          }
                          foreach ($publishers as $publisher) { ?>
                            <option <?php if ($publisher_id == $publisher->id) { ?>selected <?php } ?> value="<?php echo $publisher->id; ?>"><?php echo $publisher->publisher_name; ?></option>
                          <?php } ?>
                          <option value="other">Other</option>
                        </select>

                        <div style="border:1px solid blue; background-color:#DFEEFC;  padding:5px; margin:5px; display:none;" id="<?php echo $level->levelofInstituteId; ?>_other_div">

                          Please write the names of textbook publishers whose books are being taught at <?php echo $level->levelofInstituteTitle; ?>-Level</strong> classes.

                          <input minlength="10" class="control-form" style="width: 100%;" type="text" value="" name="<?php echo $level->levelofInstituteId; ?>_other" id="<?php echo $level->levelofInstituteId; ?>_other" />
                        </div>




                      </div>
                    </div>

                  <?php } ?>


                </div>

              </div>
            </div>
            <div style="text-align: center;">
              <?php if ($form_status->form_h_status == 1) { ?>
                <span style="margin-left: 20px;"></span> <input class="btn btn-primary" type="submit" name="" value="Update Section H Data" />
              <?php } else { ?>
                <input class="btn btn-danger" type="submit" name="" value="Add Section H Data" />
              <?php } ?>
            </div>




            <script>
              $(document).ready(function() {
                <?php foreach ($levels as $key => $level) { ?>
                  $("#<?php echo $level->levelofInstituteTitle ?>").on('select2:select', function(e) {
                    // Your code here for the first dropdown
                    //console.log("Dropdown 1 selected: " + e.params.data.value);
                    if (e.params.data.text == 'Other') {
                      $('#<?php echo $level->levelofInstituteId ?>_other_div').show();
                      $('#<?php echo $level->levelofInstituteId ?>_other').attr("required", true);
                    } else {
                      $('#<?php echo $level->levelofInstituteId ?>_other_div').hide();
                      $('#<?php echo $level->levelofInstituteId ?>_other').removeAttr("required");
                    }
                  });
                <?php } ?>
              });
            </script>







          </div>

          <div style="font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">

            <div class="row">
              <div class="col-md-6">
                <a class="btn btn-success" style="margin: 2px;" href="<?php echo site_url("form/section_g/$school_id"); ?>">
                  <i class="fa fa-arrow-left" aria-hidden="true" style="margin-right: 10px;"></i> Previous Section ( Hazards with Associated Risk ) </a>

              </div>

              <div class="col-md-6">
                <?php if ($form_status->form_h_status == 1) { ?>
                  <a class="btn btn-success" style="margin: 2px;" href="<?php echo site_url("form/submit_bank_challan/$school_id"); ?>"> Next Section (Bank Challan) <i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i></a>
                <?php } ?>
              </div>
            </div>
          </div>

        </div>


      </div>

    </section>

  </div>