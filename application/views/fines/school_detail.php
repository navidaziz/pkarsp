<!-- <div class="modal-header">
  <h4 style="border-left: 20px solid #9FC8E8;  padding-left:5px;" class="pull-left">
    School Detail - <?php echo $school->schools_id ?>
  </h4>
  <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div> -->
<div class="modal-body">

  <div class="row">
    <div class="col-md-4" style="padding-right: 1px; padding-left: 1px;">


      <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 5px; padding: 5px; background-color: white;">
        <div style="text-align:center">
          <h3>
            <?php echo ucwords(strtolower($school->schoolName)); ?><br />

          </h3>
          <h4> School ID: <?php echo $school->schools_id ?>
            <?php if ($school->registrationNumber > 0) { ?> <span style="margin-left: 20px;"></span> Reg. ID:
              <?php echo $school->registrationNumber ?>
            <?php } ?>
          </h4>
          <small>
            <?php if ($school->division) {
              echo "Zone: <strong>" . $school->division . "</strong>";
            } ?>
            <?php if ($school->districtTitle) {
              echo " / District: <strong>" . $school->districtTitle . "</strong>";
            } ?>
            <?php if ($school->tehsilTitle) {
              echo " / Tehsil: <strong>" . $school->tehsilTitle . "</strong>";
            } ?>

            <?php if ($school->ucTitle) {
              echo " / Unionconsil: <strong>" . $school->ucTitle . "</strong>";
            } ?></small>
        </div>

        <table class="table table2">
          <tr>
            <td><strong>Contact Detail </strong><br />
              <?php if ($school->telePhoneNumber) { ?>Telephone: <?php echo $school->telePhoneNumber ?> <?php } ?><br />
            <?php if ($school->schoolMobileNumber) { ?>Mobile: <?php echo $school->schoolMobileNumber ?> <?php } ?><br />
          <?php if ($school->principal_email) { ?>Email: <?php echo $school->principal_email ?> <?php } ?><br />
        Level: <?php if (!empty($school->levelofInstituteTitle)) : ?>
          <?php echo $school->levelofInstituteTitle; ?>
        <?php endif; ?>
        <br />
        Type: <?php if (!empty($school->typeTitle)) : ?>
          <strong><?php echo $school->typeTitle; ?></strong>
          <?php if (!empty($school->schoolTypeOther)) : ?>
            <strong><?php echo $school->schoolTypeOther; ?></strong>
          <?php endif; ?>
        <?php endif; ?>
        <br />Gen. Edu. <?php if (!empty($school->genderOfSchoolTitle)) : ?>
          <strong><?php echo $school->genderOfSchoolTitle; ?></strong>
        <?php endif; ?>
            </td>
            <td>
              <strong>Owner Detail </strong><br />
              <?php if ($school->userTitle) { ?>Name: <?php echo $school->userTitle ?> <?php } ?><br />
            <?php if ($school->cnic) { ?>CNIC: <?php echo $school->cnic ?> <?php } ?><br />
          <?php if ($school->contactNumber) { ?>Contact No: <?php echo $school->contactNumber ?> <?php } ?><br />

        Institute established: <strong>
          <?php echo date('M Y', strtotime($school->yearOfEstiblishment)); ?></strong><br />

        <?php if (!empty($school->biseregistrationNumber)) { ?>
          <?php echo "BISE Registration No: " . $school->biseregistrationNumber; ?>
          <?php if ($school->bise_verified == "Yes") { ?>
            <strong style="color:green"> Verified </strong>
            <br />
            <?php if (!empty($school->primaryRegDate)) : ?>
              <?php echo "Primary Registeration Date: " . $school->primaryRegDate; ?>
              <br>
            <?php endif; ?>
            <?php if (!empty($school->middleRegDate)) : ?>
              <?php echo "Middle Registeration Date: " . $school->middleRegDate; ?>
              <br>
            <?php endif; ?>
            <?php if (!empty($school->highRegDate)) : ?>
              <?php echo "High Registeration Date: " . $school->highRegDate; ?>
              <br>
            <?php endif; ?>
            <?php if (!empty($school->interRegDate)) : ?>
              <?php echo "H.Secy/Inter College Registeration Date: " . $school->interRegDate; ?>
              <br>
            <?php endif; ?>
          <?php } else { ?>
            <strong style="color:red"> Not Verified </strong>
          <?php } ?>
        <?php } else { ?>
          BISE Rregistration: <strong>No</strong>
        <?php } ?>
        <br />


            </td>
          </tr>
        </table>
        <?php
        $query = "SELECT SUM(`fine_amount`) as fine_total 
                                  FROM `school_fine_history` 
                                  WHERE school_id= '" . $schools_id . "'
                                  AND is_deleted = 0;";
        $total_fine = $this->db->query($query)->result()[0]->fine_total;
        ?>
        <div class="col-md-6">
          <div class="thumbnail">
            <h4>Total Fine: <?php echo $total_fine; ?></h4>
          </div>
        </div>
        <?php
        $query = "SELECT SUM(`deposit_amount`) as paid 
                                  FROM `fine_payments` 
                                  WHERE school_id= '" . $schools_id . "'
                                  AND is_deleted = 0;";
        $total_paid = $this->db->query($query)->result()[0]->paid;
        ?>
        <div class="col-md-6">
          <div class="thumbnail">
            <h4>Total Paid: <?php
                            if ($total_paid) {
                              echo "Rs. " . $total_paid;
                            } else {
                              echo "Rs. 0.00";
                            } ?></h4>
          </div>
        </div>
        <div class="form-group" style="padding-top:8px;">

          <div class="col-md-6">
            <label class="control-label" for="gender">Fine Category:</label>
            <select class="form-control select2" id="fine_category" form="Form1" name="fine_category" style="width: 100%;">

              <option value="">Select Fine Category</option>
              <option value="1">Salary issue</option>
              <option value="2">Fee related issue</option>
              <option value="3">Observance of holidays, closure and opening etc. of schools</option>
              <option value="4">Non observance of SOPs/hygiene etc</option>
              <option value="5">Corporal Punishment / Mishandling</option>
              <option value="6">Teacher Appointment/Termination</option>
              <option value="7">SLC related Issues</option>
              <option value="8">Gen/Misc</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="control-label" for="numberOfClassroom">Amount:</label>
            <input onkeyup="inWords()" type="number" value="" name="amount" placeholder="Example 2000 etc." class="form-control" form="Form1" id="amount" />

          </div>
          <div class="col-md-12">
            <div style="text-transform: capitalize; font-weight: bold;  margin:1px; padding:1px; text-align:right" id="number_to_words"></div>
          </div>


          <div class="col-md-6">
            <label class="control-label" for="File No.">Letter / File Number</label>
            <input type="text" value="" name="file_number" placeholder="" class="form-control" id="file_number" />

          </div>
          <div class="col-md-6">
            <label class="control-label" for="File No.">Date</label>
            <input type="date" value="" name="file_date" placeholder="" class="form-control" id="file_date" />

          </div>


          <div class="col-md-12">
            <label class="control-label" for="numberOfClassroom">Remarks:</label>
            <textarea class="form-control" placeholder="Remarks about fine" cols="50" rows="5" name="remarks" id="remarks"></textarea>
          </div>

          <div class="col-sm-12" style="text-align: center;">
            <script>
              var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '];
              var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];



              function inWords() {

                num = $('#amount').val();
                if ((num = num.toString()).length > 9) return 'overflow';
                n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
                if (!n) return;
                var str = '';
                str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
                str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
                str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
                str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
                str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
                $('#number_to_words').text(str)
              }

              function add_new_fine() {
                fine_category = $('#fine_category').val();
                if (fine_category == '') {
                  alert("Fine Category Required");
                  return false;
                }

                var amount = $('#amount').val();
                if (amount == '') {
                  alert("Amount Required");
                  return false;
                }

                var remarks = $('#remarks').val();
                if (remarks == '') {
                  alert("Fine Detail Remarks Required");
                  return false;
                }

                var password = $('#password').val();
                if (password == '') {
                  alert("Account Password Required.");
                  return false;
                }

                var file_number = $('#file_number').val();
                if (file_number == '') {
                  alert("File Number Required.");
                  return false;
                }

                var file_date = $('#file_date').val();
                if (file_date == '') {
                  alert("File Date Required.");
                  return false;
                }





                $.ajax({
                    method: "POST",
                    url: "<?php echo site_url('fines/add_fine'); ?>",
                    data: {
                      schools_id: <?php echo $schools_id; ?>,
                      fine_category: fine_category,
                      amount: amount,
                      remarks: remarks,
                      password: password,
                      file_number: file_number,
                      file_date: file_date
                    },
                  })
                  .done(function(respose) {
                    if (respose == 0) {
                      alert("Error Try Again");

                    } else {
                      $.ajax({
                          method: "POST",
                          url: "<?php echo site_url('fines/view_school_detail'); ?>",
                          data: {
                            schools_id: <?php echo $schools_id; ?>,
                          },
                        })
                        .done(function(respose) {
                          $('#view_school_detail_body').html(respose);
                        });
                    }

                  });



              }

              function add_payment(history_id) {


                var stan_no = $('#stan_no_' + history_id).val();
                if (stan_no == '') {
                  alert("STAN Required.");
                  return false;
                }
                var deposit_date = $('#deposit_date_' + history_id).val();
                if (deposit_date == '') {
                  alert("Deposit Date Required.");
                  return false;
                }
                var deposit_amount = $('#deposit_amount_' + history_id).val();
                if (deposit_amount == '') {
                  alert("Deposit Amount Required.");
                  return false;
                }

                var max = parseInt($('#deposit_amount_' + history_id).attr('max'));
                if (deposit_amount > max) {
                  alert("paid amount must be less than or equal fined amount.");
                  return false;
                }


                if (confirm("Are you sure you want to Add Payment ?")) {
                  $.ajax({
                      method: "POST",
                      url: "<?php echo site_url('fines/add_fine_payment'); ?>",
                      data: {
                        schools_id: <?php echo $schools_id; ?>,
                        history_id: history_id,
                        stan_no: stan_no,
                        deposit_date: deposit_date,
                        deposit_amount: deposit_amount
                      },
                    })
                    .done(function(respose) {
                      if (respose == 0) {
                        alert("Error Try Again");

                      } else {
                        $.ajax({
                            method: "POST",
                            url: "<?php echo site_url('fines/view_school_detail'); ?>",
                            data: {
                              schools_id: <?php echo $schools_id; ?>,
                            },
                          })
                          .done(function(respose) {
                            $('#view_school_detail_body').html(respose);
                          });
                      }
                    });
                } else {
                  return false;
                }
              }


              function delete_fine(history_id) {
                if (confirm("Are you sure you want to delete ?")) {
                  $.ajax({
                      method: "POST",
                      url: "<?php echo site_url('fines/delete_fine'); ?>",
                      data: {
                        schools_id: <?php echo $schools_id; ?>,
                        history_id: history_id
                      },
                    })
                    .done(function(respose) {
                      if (respose == 0) {
                        alert("Error Try Again");

                      } else {
                        $.ajax({
                            method: "POST",
                            url: "<?php echo site_url('fines/view_school_detail'); ?>",
                            data: {
                              schools_id: <?php echo $schools_id; ?>,
                            },
                          })
                          .done(function(respose) {
                            $('#view_school_detail_body').html(respose);
                          });
                      }
                    });
                } else {
                  return false;
                }
              }

              function delete_payment(history_id, fine_payment_id) {

                if (confirm("Are you sure you want to delete ?")) {
                  $.ajax({
                      method: "POST",
                      url: "<?php echo site_url('fines/delete_fine_payment'); ?>",
                      data: {
                        schools_id: <?php echo $schools_id; ?>,
                        history_id: history_id,
                        fine_payment_id: fine_payment_id
                      },
                    })
                    .done(function(respose) {
                      if (respose == 0) {
                        alert("Error Try Again");

                      } else {
                        $.ajax({
                            method: "POST",
                            url: "<?php echo site_url('fines/view_school_detail'); ?>",
                            data: {
                              schools_id: <?php echo $schools_id; ?>,
                            },
                          })
                          .done(function(respose) {
                            $('#view_school_detail_body').html(respose);
                          });
                      }
                    });
                } else {
                  return false;
                }
              }

              function waive_off_fine(fine_id) {
                wo_detail = $('#wo_' + fine_id).val();
                if (wo_detail == '') {
                  alert("Wavie Off Detail Required");
                  return false;
                } else {
                  $.ajax({
                      method: "POST",
                      url: "<?php echo site_url('fines/waive_off_fine'); ?>",
                      data: {
                        schools_id: <?php echo $schools_id; ?>,
                        history_id: fine_id,
                        wo_detail: wo_detail
                      },
                    })
                    .done(function(respose) {
                      if (respose == 0) {
                        alert("Error Try Again");

                      } else {
                        $.ajax({
                            method: "POST",
                            url: "<?php echo site_url('fines/view_school_detail'); ?>",
                            data: {
                              schools_id: <?php echo $schools_id; ?>,
                            },
                          })
                          .done(function(respose) {
                            $('#view_school_detail_body').html(respose);
                          });
                      }

                    });

                }
              }

              function remove_wavid_off(fine_id) {

                if (confirm("Are you sure to remove ?")) {

                  $.ajax({
                      method: "POST",
                      url: "<?php echo site_url('fines/remove_waive_off'); ?>",
                      data: {
                        schools_id: <?php echo $schools_id; ?>,
                        history_id: fine_id,
                      },
                    })
                    .done(function(respose) {
                      if (respose == 0) {
                        alert("Error Try Again");

                      } else {
                        $.ajax({
                            method: "POST",
                            url: "<?php echo site_url('fines/view_school_detail'); ?>",
                            data: {
                              schools_id: <?php echo $schools_id; ?>,
                            },
                          })
                          .done(function(respose) {
                            $('#view_school_detail_body').html(respose);
                          });
                      }

                    });
                }

              }
            </script>
            Account Password: <input type="password" name="password" id="password" class="form-control" style="width: 150px;" />
            <button class="btn btn-danger" onclick="add_new_fine()">Add New Fine</button>
          </div>


          <div class="clearfix"></div>

        </div>

      </div>

    </div>

    <div class="col-md-8" style="padding-right: 1px; padding-left: 1px;">
      <div class="row" style="margin-left: 10px; margin-right: 10px;">
        <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
          <h4> <i class="fa fa-info-circle" aria-hidden="true"></i>
            Fine's
            <button type="button pull-right" style="margin-right: 20px;" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </h4>

          <?php $query = "SELECT `school_fine_history`.*, 
          (SELECT SUM(`deposit_amount`)  FROM `fine_payments` 
          WHERE `fine_payments`.`fine_id` = `school_fine_history`.`history_id`
          AND `fine_payments`.`is_deleted` = 0
          ) as total_payment  
          FROM `school_fine_history` WHERE school_id = '" . $schools_id . "'  AND is_deleted = 0";
          $fines = $this->db->query($query)->result(); ?>

          <?php
          $count = 1;
          foreach ($fines as $fine) { ?>
            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;   margin: 5px; padding: 5px; background-color: white;">
              <div class="col-md-6">

                <div>
                  <span class="pull-left">
                    <?php echo $count++; ?>
                    <strong <?php if ($fine->is_fined == 0) { ?>style="text-decoration: line-through !important;" <?php } ?>>
                      Total Fine: <?php echo $fine->fine_amount ?>
                    </strong>
                  </span>
                  <span class="pull-right">

                    <strong <?php if ($fine->is_fined == 0) { ?>style="text-decoration: line-through !important;" <?php } ?>>File No: <?php echo $fine->file_number ?>
                      Date: <?php
                            if ($fine->file_date) {
                              echo date('d M, Y', strtotime($fine->file_date));
                            } ?>
                      Status: <?php echo $fine->is_fined ?>
                      <button class="btn btn-link" style="padding: 0px; margin: 0px;" onclick="delete_fine(<?php echo $fine->history_id ?>)" aria-hidden="true">×</button>
                    </strong>

                  </span>
                </div>

                <div class="clearfix"></div>

                <p <?php if ($fine->is_fined == 0) { ?>style="text-decoration: line-through !important;" <?php } ?>>
                  <?php echo $fine->remarks ?>
                </p>

                <?php

                $total_paid = $fine->fine_amount - $fine->total_payment;

                if ($fine->is_fined == 1 and $total_paid != 0) { ?>
                  <div style="text-align: center; ">
                    <button onclick="$('#waive_off_form').toggle()" class="btn btn-warning btn-sm"> <span class="fa fa-hand-stop-o"></span> Waive Off</button>
                  </div>
                  <div id="waive_off_form" style="display: none;">
                    <strong>Wavie Off Detail</strong>
                    <br />
                    <textarea style="width: 100%; padding:5px" id="wo_<?php echo $fine->history_id ?>"></textarea>
                    <div style="text-align: center;"><button onclick="waive_off_fine('<?php echo $fine->history_id ?>');" class="btn btn-primary"><span class="fa fa-hand-stop-o"></span> Waive Off Fine</button></div>
                  </div>
                <?php } ?>

              </div>
              <div class="col-md-6">
                <?php


                if ($fine->is_fined == 1) { ?>
                  <table style="width: 100%;">
                    <tr>

                      <th>STAN No</th>
                      <th>Date</th>
                      <th>Amount</th>
                      <th>Add</th>
                    </tr>
                    <?php



                    if ($fine->total_payment != $fine->fine_amount) { ?>
                      <tr>

                        <td><input style="width: 100px;" type="number" value="" name="stan_no" id="stan_no_<?php echo $fine->history_id ?>" /> </td>
                        <td><input style="width: 130px;" type="date" value="" name="deposit_date" id="deposit_date_<?php echo $fine->history_id ?>" /> </td>
                        <td><input min="0" max="<?php echo $fine->fine_amount; ?>" style="width: 100px;" type="number" value="" name="deposit_amount" id="deposit_amount_<?php echo $fine->history_id ?>" /> </td>
                        <td><button onclick="add_payment(<?php echo $fine->history_id ?>)" class="btn btn-success btn-sm">Add</button> </td>
                      </tr>
                    <?php } ?>
                    <?php
                    $query = "SELECT * FROM fine_payments WHERE is_deleted = 0 AND  fine_id = '" . $fine->history_id . "' and school_id = '" . $schools_id . "'";
                    $fine_payments = $this->db->query($query)->result();
                    foreach ($fine_payments as $fine_payment) { ?>
                      <tr>
                        <td><?php echo $fine_payment->stan_no ?></td>
                        <td><?php echo $fine_payment->deposit_date ?></td>
                        <td><?php echo $fine_payment->deposit_amount ?></td>
                        <td>
                          <button class="btn btn-link" style="padding: 0px; margin: 0px;" onclick="delete_payment('<?php echo $fine->history_id ?>','<?php echo $fine_payment->fine_payment_id;  ?>')" aria-hidden="true">×</button>

                        </td>
                      </tr>
                    <?php     }
                    ?>
                    <tr>
                      <th>Total Fine: Rs. <?php echo $fine->fine_amount ?></th>
                      <th>Fine Paid: Rs.<?php echo $fine->total_payment ?></th>
                      <th>Fine Remained: Rs.<?php echo $fine->fine_amount - $fine->total_payment ?></th>
                      <th></th>
                    </tr>
                  </table>
                <?php  } else { ?>
                  <div class="alert alert-warning">
                    <strong> <span class="fa fa-hand-stop-o"></span> Fine Wavied Off Detail</strong>
                    <br />
                    <p><?php echo $fine->wo_detail; ?></p>
                    <div style="text-align: right;">
                      <button onclick="remove_wavid_off('<?php echo $fine->history_id ?>')" class="btn btn-danger btn-sm">Remove Wavied Off</button>
                    </div>
                  </div>
                <?php  } ?>
              </div>

              <div class="clearfix"></div>
            </div>
          <?php } ?>


        </div>

      </div>

    </div>




  </div>