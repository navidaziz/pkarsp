<style type="text/css">
  fieldset {
    display: block;
    margin-inline-start: 2px;
    margin-inline-end: 2px;
    padding-block-start: 0.35em;
    padding-inline-start: 0.75em;
    padding-inline-end: 0.75em;
    padding-block-end: 0.625em;
    min-inline-size: min-content;
    border-width: 1px;
    border-style: groove;
    border: 1px solid #bbb;
    border-image: initial;
    font-size: 16px;

  }

  legend {
    width: auto;
    display: block;
    padding-inline-start: 2px;
    padding-inline-end: 2px;
    border-width: initial;
    border-style: none;
    border-color: initial;
    border-image: initial;
    font-size: 16px;

  }

  .message {
    overflow: hidden;
    text-overflow: ellipsis;

    letter-spacing: .2px;
    color: #202124;
    line-height: 20px;
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h2 style="display:inline;">
      <?php echo @ucfirst($title); ?>
    </h2>
    <small><?php echo @$description; ?></small>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
      <!-- <li><a href="#">Examples</a></li> -->
      <li class="active"><?php echo @ucfirst($title); ?></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo @ucfirst($title); ?></h3>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body">



        <div class="row">



          <div class="col-md-12">

            <fieldset style="background-color: #f9f6f6;">
              <legend></legend>
              <h3 style="text-align:center;width:100%;font-size:   24px;padding:10px;font-family: Arial, Helvetica, sans-serif;text-transform:  capitalize;margin-top:0 !important;margin-bottom: 0 !important; "> <?php echo $message_info->subject; ?></h3>
              <p class="" style="font-size: 14px;color:#e95837;text-align: center;"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date("l , dS F Y", strtotime($message_info->created_date)); ?></p>
              <div class="col-md-offset-1 col-md-10 col-sm-12 col-xs-12" style="min-height: 200px;">





                <div style="background-color: #fff;padding:20px;">



                  <div class="">


                    <?php //echo $message_info->discription;
                    $url_replace =  array(
                      'http://psra.gkp.pk/schoolReg/school/certificate',
                      'https://psra.gkp.pk/schoolReg/school/certificate',
                      'http://localhost/pkarsp/school/certificate'
                    );
                    $url_replace_to = site_url("print_file/certificate");
                    echo str_replace($url_replace, $url_replace_to, $message_info->discription);

                    ?>
                  </div>

                  <hr>
                  <?php if (count($attachments)) {
                    $counter = 1; ?>



                    <table class="table table-bordered bg-info">
                      <?php foreach ($attachments as $attachment) {
                        if ($attachment->folder) {
                          $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
                          $attachment_url = $root . "uploads/" . $attachment->folder . "/";
                        } else {
                          $attachment_url = 'http://psra.gkp.pk/schoolReg/assets/images/';
                        }
                      ?>
                        <tr>
                          <td><?php echo $counter++; ?></td>
                          <td><i class="fa fa-file"></i> <?php
                                                          $attach = explode('____', $attachment->attachment_name);


                                                          echo end($attach); ?>
                          </td>
                          <td>
                            <a target="_blank" class="btn btn-link" href="<?php echo  $attachment_url . '' . $attachment->attachment_name; ?>">

                              <i class="fa fa-download"></i> Download</a>
                          </td>
                        </tr>
                      <?php  }  ?>
                    </table>

                  <?php } ?>



                  <br />
                  <br />
                  <?php //var_dump($message_info);
                  $query = "SELECT school.status, school.file_status, school.schools_id, reg_type_id, regTypeTitle, sessionYearTitle
                    FROM school 
                    INNER JOIN reg_type ON(reg_type.regTypeId = school.reg_type_id)
                    INNER JOIN`session_year` ON(session_year.sessionYearId = school.session_year_id)
                    WHERE school.status =2 and school.file_status=5 and school.schoolId='" . $message_info->school_session_id . "'";
                  $school = $this->db->query($query)->row(); ?>

                  <?php if ($message_info->message_type == 'Deficiency' and $message_info->message_reason == 'Fee Deficiency') { ?>
                    <?php if ($school->status == 2 and $school->file_status == 5) { ?>
                      <script>
                        function validateForm() {
                          const challan_no = $('#challan_no').val();
                          const regex = /^[0-9]*$/;

                          if (challan_no.length < 6) {
                            event.preventDefault();
                            alert('There is an error in the stan number. The stan number contains six digits');
                            false;
                          }
                          if (!regex.test(challan_no)) {
                            event.preventDefault();
                            alert('The stan number contains digits only');
                            false;
                          }
                        }
                      </script>

                      <div class="">
                        <div class="alert alert-warning">
                          <div class="row">
                            <div class="col-md-6">
                              <div>
                                Please submit the bank's STAN number and date below after depositing the deficient amount.</div>
                            </div>
                            <div class="col-md-6" style="direction: rtl;">
                              براہ کرم کمی کی رقم جمع کرنے کے بعد نیچے بینک کا STAN نمبر اور تاریخ جمع کرائیں۔
                            </div>
                          </div>
                        </div>

                        <img width="100%" src="<?php echo site_url("assets/stan.jpeg"); ?>" />

                        <small><i>"STAN can be found on the upper right corner of bank generated receipt"</i></small>
                        <table class="table">
                          <tr>
                            <th>Challan For </th>
                            <th>Session</th>
                            <th>Bank Transaction Date</th>
                            <th>Bank Transaction No (STAN No)</th>
                            <th>Add Challan</th>
                          </tr>

                          <form onsubmit="return validateForm();" class="form-horizontal" method="post" enctype="multipart/form-data" id="role_form" action="<?php echo base_url('messages/school_message_details/' . $message_info->message_id); ?>">
                            <input type="hidden" name="school_id" value="<?php echo $message_info->school_session_id; ?>" />
                            <input type="hidden" name="apply_for" value="Deficiency" />

                            <tr>
                              <td>

                                <input type="hidden" name="reg_type_id" value="<?php echo $school->reg_type_id; ?>" />
                                <?php echo @$school->regTypeTitle; ?>

                              </td>
                              <td><?php echo @$school->sessionYearTitle; ?></td>
                              <td><input required name="challan_date" type="date" class="form-control" min="2018-01-01" max="<?php echo date('Y-m-d'); ?>" />
                              </td>
                              <td><input required maxlength="6" id="challan_no" name="challan_no" type="text" autocomplete="off" class="form-control" />
                              </td>
                              <td><input style="display: block;" type="submit" class="btn btn-info" name="deficiency_challan" value="Add Deficient Bank Challan" id="add_form" />
                              </td>
                            </tr>
                          </form>

                          <?php
                          $query = "SELECT * FROM bank_transaction where school_id = '" . $message_info->school_session_id . "'";
                          $session_bank_challans = $this->db->query($query)->result();
                          if ($session_bank_challans) {
                            foreach ($session_bank_challans as $session_bank_challan) { ?>
                              <tr>
                                <th><?php echo @$school->regTypeTitle; ?></th>
                                <th><?php echo @$school->sessionYearTitle; ?></th>
                                <th><?php echo $session_bank_challan->bt_no; ?></th>
                                <th><?php
                                    if ($session_bank_challan->bt_date) {
                                      echo date("d m, Y", strtotime($session_bank_challan->bt_date));
                                    }
                                    ?></th>
                                <th>
                                  <?php if ($school->status == 0 and $edit_allow) { ?>
                                    <a href="<?php echo site_url('school/remove_bank_challan/' . $schoolId . '/' . $session_bank_challan->bt_id); ?>"><small>
                                        <i>Remove</i>
                                      </small></a>
                                  <?php } ?>
                                </th>
                              </tr>

                            <?php } ?>

                            <tr>
                              <td colspan="5" style="text-align: center;">
                                <div class="alert alert-danger">
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div>To reprocess your case, click "Deficiency Completed" after entering your deficiency bank challan.</div>
                                    </div>
                                    <div class="col-md-6" style="direction: rtl;">
                                      اپنے کیس کو ری پروسیس کرنے کے لیے، اپنا ڈیفیشینسی بینک چالان داخل کرنے کے بعد "Deficiency Completed" پر کلک کریں۔
                                    </div>
                                  </div>
                                </div>
                                <form method="post" action="<?php echo base_url('messages/school_message_details/' . $message_info->message_id); ?>">
                                  <input type="hidden" name="school_id" value="<?php echo $message_info->school_session_id; ?>" />
                                  <input class="btn btn-danger" type="submit" name="deficiency_completed" value="Submit Deficiency Online" />
                                </form>
                              </td>
                            </tr>
                          <?php } else { ?>
                            <tr>
                              <td colspan="5" style="text-align: center;">
                                No Bank Challan Submitted.
                              </td>
                            </tr>
                          <?php } ?>
                        </table>

                      </div>


                </div>

              <?php } ?>
            <?php }
            ?>



              </div>



            </fieldset>
            <!--                           </div>
        </div> -->
          </div>

          <!-- /.box-body -->
        </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {

    $('#start_session').on('click', function(e) {
      e.preventDefault();

      var r = confirm("Are You Sure to Start New Session");

      if (r == true) {

        $('#start_session').prop('disabled', true);
        var id = 1;
        $.ajax({
          type: 'POST',
          url: "<?php echo base_url('school/renewal_as_a_whole_school') ?>",
          data: {
            "id": id
          },
          success: function(data) {
            alert("New Session Created For " + data + " Schools");
            $('#start_session').prop('disabled', false);
          },
          error: function(data) {
            alert("Failed");
            $('#start_session').prop('disabled', false);
          }
        });
      }


    });


    $('#current').on('click', function() {
      $("#current_sessin_model").modal('show');

    });
    $('#next').on('click', function() {
      $("#next_sessin_model").modal('show');

    });
  });
</script>