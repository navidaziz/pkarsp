<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>School Information</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- STYLESHEETS -->
  <!--[if lt IE 9]><script src="js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/cloud-admin.css">
  <link href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- DATE RANGE PICKER -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <!-- UNIFORM -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/uniform/css/uniform.default.min.css" />
  <!-- ANIMATE -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/animatecss/animate.min.css" />
  <link rel="stylesheet" href="//fonts.googleapis.com/earlyaccess/notonastaliqurdudraft.css">
  <style>
    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
      padding: 1px !important;
    }

    .required:after {
      content: " *";
      color: red;
    }
  </style>
</head>

<body class="log in" style="position: relative;
    height: 100%;
    background-image: url(<?php echo site_url("assets/" . ADMIN_DIR . "img/background.jpg"); ?>);
    background-size: cover;
    ">
  <!-- PAGE -->
  <section id="page">

    <section>
      <div class="container">
        <div class="row">
          <h3 style="text-align: center;">PSRA Institute Registration Form (Section A)</h3>
          <form class="" method="post" enctype="multipart/form-data" id="create_form" action="<?php echo base_url('add_school/process_data'); ?>">

            <div class="col-md-3">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height:600px;  margin: 5px; padding: 10px; background-color: white;">
                <div class="box-body">
                  <h4>Institute Information</h4>
                  <script>
                    function hide_and_show(school_type) {
                      if (school_type == 7) {
                        $('.p_input').prop('checked', false);
                        $('.p_div').hide();
                        $('.a_div').show();
                        $('#affiliated_no').prop('checked', true);
                        $('#bise_affiliation').hide();
                        $('.bise_id').prop('required', false);
                        $('.biseRegister').prop('required', false);
                        $('#bise_no').prop('checked', true);
                        $('#bank_detail').hide();
                        $('.bankDetail').prop('required', false);
                        $('.a_input').prop('checked', true);
                        $('#levels').hide();
                        $('.mediumOfInstruction').prop('checked', true);
                      } else {
                        $('.p_input').prop('checked', false);
                        $('.a_input').prop('checked', false);
                        $('.p_div').show();
                        $('.a_div').hide();
                        $('#levels').show();
                        $('.mediumOfInstruction').prop('checked', false);
                      }

                    }
                  </script>
                  <table class="table">

                    <tr>
                      <td colspan="2">
                        <strong class="required"> Institute Type</strong><br />
                        <?php foreach ($school_types as $school_type) : ?>
                          <input onclick="hide_and_show('<?php echo $school_type->typeId; ?>')" type="radio" name="school_type_id" value="<?= $school_type->typeId; ?>" required />
                          <?php echo $school_type->typeTitle; ?>

                        <?php endforeach; ?>

                      </td>
                    </tr>

                    <tr id="levels">
                      <td colspan="2">
                        <strong class="required">Institute Level (Current)</strong><br />

                        <?php foreach ($level_of_institute as $item) : ?>

                          <span class="<?php if ($item->levelofInstituteId == 5) {
                                          echo 'a_div';
                                        } else {
                                          echo 'p_div';
                                        } ?>">
                            <input class="<?php if ($item->levelofInstituteId == 5) {
                                            echo 'a_input';
                                          } else {
                                            echo 'p_input';
                                          } ?>" type="radio" name="level_of_school_id" value="<?= $item->levelofInstituteId; ?>" required />
                            <?php echo $item->levelofInstituteTitle; ?>
                            <br />
                          </span>


                        <?php endforeach; ?>

                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <strong class="required">Institute Locality</strong><br />
                        <?php foreach ($locations as $location) { ?>
                          <input name="location" type="radio" value="<?= $location->locationTitle; ?>" required />
                          <?= $location->locationTitle; ?><br />
                        <?php } ?>
                      </td>
                    </tr>
                    <td colspan="2">
                      <strong class="required">Institute Gender Education</strong><br />
                      <?php foreach ($gender_of_school as $gender) : ?>
                        <input type="radio" name="gender_type_id" value="<?= $gender->genderOfSchoolId; ?>" required /> <?= $gender->genderOfSchoolTitle; ?>
                        <br />
                      <?php endforeach; ?>
                    </td>
                    </tr>



                    <tr class="p_div">
                      <td colspan="2">
                        <strong class="required">Medium of Instruction</strong><br />
                        <input class="mediumOfInstruction" type="radio" name="mediumOfInstruction" required value="Urdu"> Urdu <br />
                        <input class="mediumOfInstruction" type="radio" name="mediumOfInstruction" required value="English"> English <br />
                        <input class="mediumOfInstruction" type="radio" name="mediumOfInstruction" required value="Both"> Both

                      </td>
                    </tr>

                    <tr>
                      <td colspan="2">
                        <strong class="required"> Institute Nature of Management </strong><br />
                        <input type="radio" name="management_id" value="1" required /> Individual
                        <br />
                        <input type="radio" name="management_id" value="2" required /> Registered Body / Firm
                        <br />
                        <input type="radio" name="management_id" value="3" required /> Association of Persons
                        <br />
                        <input type="radio" name="management_id" value="4" required /> Trust


                      </td>
                    </tr>
                  </table>
                </div>

              </div>
            </div>

            <div class="col-md-5">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 600px;  margin: 5px; padding: 10px; background-color: white;">
                <h4>Institute Details</h4>
                <div class="box-body">

                  <input type="hidden" name="reg_type_id" value="1">
                  <table class="table">
                    <tr>
                      <td class="required">Institute Name</td>
                      <td><input class="form-control" type="text" id="name" required name="schoolName" value="" /> </td>
                    </tr>
                    <tr>
                      <td class="required">Year of Establishment:</td>
                      <td>
                        <select class="form-control" style="width:49%; display:inline" name="e_month" required>
                          <option value="">Select Month</option>
                          <?php
                          $months = array(
                            '01' => 'Jan',
                            '02' => 'Feb',
                            '03' => 'Mar',
                            '04' => 'Apr',
                            '05' => 'May',
                            '06' => 'Jun',
                            '07' => 'Jul',
                            '08' => 'Aug',
                            '09' => 'Sep',
                            '10' => 'Oct',
                            '11' => 'Nov',
                            '12' => 'Dec'
                          );
                          foreach ($months as $index => $month) { ?>
                            <option value="<?php echo $index; ?>"><?php echo $month; ?></option>
                          <?php }  ?>
                        </select>
                        <select class="form-control" style="width:49%; display:inline;" name="e_year" required>
                          <option value="">Select Year</option>
                          <?php for ($years = date('Y'); $years >= 1950; $years--) { ?>
                            <option value="<?php echo $years; ?>"><?php echo $years; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td class="required">Institute Contact No. (Landline) </td>
                      <td><input class="form-control" type="text" id="telePhoneNumber" required name="telePhoneNumber" value="" /> </td>
                    </tr>
                    <tr>
                      <td class="required">Institute Contact No. (Mobile)</td>
                      <td><input class="form-control" type="text" id="schoolMobileNumber" required name="schoolMobileNumber" value="" /> </td>
                    </tr>

                    <tr>
                      <td>Institute Email</td>
                      <td><input class="form-control" type="email" id="principal_email" name="principal_email" value="" /> </td>
                    </tr>
                    <tr>
                      <script>
                        function getTehsilsByDistrictId(selected) {
                          $.ajax({
                            type: 'POST',
                            url: "<?php echo base_url('registration/get_tehsils_by_district_id') ?>/",
                            data: {
                              "id": selected.value
                            },
                            success: function(data) {
                              $("#tehsil_id").html(data);
                            }
                          });
                        }
                      </script>
                      <script>
                        function getUcsByTehsilsId(selected) {

                          $.ajax({
                            type: 'POST',
                            url: "<?php echo base_url('registration/get_ucs_by_tehsils_id') ?>/",
                            data: {
                              "id": selected.value
                            },
                            success: function(data) {
                              $("#uc_id option").remove();
                              $("#uc_id").append(data);
                            }

                          });
                        }

                        function check_uc() {
                          var selectBox = document.getElementById("uc_id");
                          var selectedValue = selectBox.options[selectBox.selectedIndex].value;
                          if (selectedValue == '0') {
                            $('#others_uc').show();
                            $('#uc_text').prop('required', true);

                          } else {
                            $('#others_uc').hide();
                            $('#uc_text').prop('required', false);
                          }
                        }
                      </script>
                    </tr>
                  </table>
                  <h4>Institute Address Details</h4>

                  <div class="form-group col-md-4">
                    <label class="required" for="district">District</label>
                    <select class="form-control" onchange="getTehsilsByDistrictId(this);" required="required" name="district_id" id="district_id">
                      <option value="">Select District</option>
                      <?php foreach ($districts as $district) : ?>
                        <option value="<?php echo $district->districtId; ?>"><?php echo $district->districtTitle; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label class="required" for="tehsil">Tehsil</label>
                    <select class="form-control" required="required" name="tehsil_id" onchange="getUcsByTehsilsId(this);" id="tehsil_id">
                      <option value="">Select</option>

                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label class="required" for="uc">UC / Cantonment</label>
                    <select class="form-control" required onchange="check_uc();" name="uc_id" id="uc_id">
                      <option value="">Select</option>
                    </select>
                  </div>


                  <table style="width: 100%;">
                    <tr style="display: none;" id="others_uc">
                      <td>Write UC / Cantonment Name: </td>
                      <td><input class="form-control" type="text" id="uc_text" required name="uc_text" value="" /> </td>
                    </tr>
                    <tr>
                      <td class="required">Village/City Name:</td>
                      <td> <input class="form-control" type="text" id="address" required name="address" value="" /> </td>
                    </tr>

                    <tr>
                      <td class="required">
                        Postal Address </td>
                      <td><input class="form-control" type="text" id="postal_address" required name="postal_address" value="" /> </td>
                    </tr>

                  </table>
                  <br />
                  <div style="border: 1px solid lightgray; padding:5px; border-radius:5px">
                    <h6>GPS Coordinates of institute <small class="pull-right"> e.g (34.952621 , 72.331113) </small>
                    </h6>
                    <table style="width: 100%;">
                      <tr>
                        <td><strong class="required">Latitude:</strong><br />
                          <input class="form-control" style="width:100%" type="text" required placeholder="e.g 34.952621" name="late" id="late" step="any" />
                        </td>
                        <td><strong class="required">longitude:</strong><br />
                          <input class="form-control" style="width:100%" type="text" required placeholder="e.g 72.331113" name="longitude" id="long" step="any" />
                        </td>
                      </tr>
                    </table>
                  </div>


                </div>

              </div>
            </div>





            <div class="col-md-4">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 600px;  margin: 5px; padding: 10px; background-color: white;">
                <div class="box-body">

                  <h4>Institute Owner Detail <span class="pull-right" style="text-align: center; font-size:9px; color:red;  font-family: 'Noto Nastaliq Urdu Draft', serif;">
                      تفصیل وہی ہونی چاہیے جو اسٹامپ پیپر میں لکھی گئی ہو۔
                    </span></h4>
                  <p style="text-align: center; color:red;  font-family: 'Noto Nastaliq Urdu Draft', serif;">

                  </p>
                  <table class="table">
                    <tr>
                      <td class="required">Owner Name</td>
                      <td><input class="form-control" type="text" required="required" name="userTitle" value="" id="userTitle" placeholder="Owner Name"></td>
                    </tr>
                    <tr>
                      <td class="required">Owner Contact No.</td>
                      <td><input class="form-control" type="text" required="required" name="contactNumber" value="" id="contactNumber" placeholder="Mobile No."></td>
                    </tr>
                    <tr>
                      <td class="required">Owner CNIC No.</td>
                      <td><input class="form-control" type="text" required="required" name="cnic" value="" id="cnic" placeholder="CNIC No."></td>
                    </tr>
                    <tr>
                      <td class="required">Owner Gender</td>
                      <td>
                        <input type="radio" name="gender" value="1" required /> Male
                        <input type="radio" name="gender" value="2" required /> Female
                        <input type="radio" name="gender" value="3" required /> Other

                      </td>
                    </tr>
                    <tr>
                      <td class="required">Address</td>
                      <td>
                        <input class="form-control" type="text" name="owner_address" value="" required />


                      </td>
                    </tr>
                  </table>
                  <div class="p_div">
                    <h4>BISE Affiliation / Registration Details</h4>

                    <strong>Affiliated with BISE? </strong>
                    <input class="p_input" id="affiliated_yes" onclick="$('#bise_affiliation').show(); $('.bise_id').prop('required', true); $('.biseRegister').prop('required', true); " type="radio" value="Yes" name="biseAffiliated" required /> Yes
                    <input class="p_input" id="affiliated_no" onclick="$('#bise_affiliation').hide(); $('.bise_id').prop('required', false); $('.biseRegister').prop('required', false); " type="radio" value="No" name="biseAffiliated" required /> No
                    <div id="bise_affiliation" style="display: none;">
                      <br />

                      <strong> BISE Affiliation</strong>

                      <br />
                      <?php foreach ($bise_list as $bise) : ?>
                        <input <?php if ($bise->biseName == 'Other') { ?> onclick="$('#BiseOther').show(); $('#otherBiseName').prop('required', true);" <?php } else { ?> onclick="$('#BiseOther').hide(); $('#otherBiseName').prop('required', false);" <?php } ?> type="radio" class="bise_id" name="bise_id" value="<?= $bise->biseId; ?>"><?= $bise->biseName; ?>
                        <?php if ($bise->biseName == 'Other') { ?>

                          <div id="BiseOther" style="margin-left: 13px; margin-right: 13px; display: none;">

                            Other BISE Name


                            <input type="text" placeholder="Enter Other BISE Name" name="otherBiseName" id="otherBiseName" /></td>

                          </div>
                        <?php  } ?>
                        <br />
                      <?php endforeach; ?>
                      <h4>BISE Registration Details</h4>
                      <strong>BISE Registered</strong>
                      <input onclick="$('#bise_registration_date').show(); $('#biseregistrationNumber').prop('required', true);" type="radio" value="Yes" name="biseRegister" class="biseRegister" required /> Yes
                      <input onclick="$('#bise_registration_date').hide(); $('#biseregistrationNumber').prop('required', false);" type="radio" value="No" name="biseRegister" class="biseRegister" required /> No


                      <div id="bise_registration_date" style="display: none;">
                        <p>Write date of last registration as per your level of school.</p>
                        <table class="table table-bordered">
                          <tr>
                            <td>Registration No.</td>
                            <td> <input type="text" placeholder="Registration Number" name="biseregistrationNumber" id="biseregistrationNumber" />
                            </td>
                          </tr>

                          <tr>
                            <td>Primary:</td>
                            <td> <input type="date" id="primaryRegDate" name="primaryRegDate" /> </td>
                          </tr>
                          <tr>
                            <td>Middle:</td>
                            <td> <input type="date" id="middleRegDate" name="middleRegDate" /> </td>
                          </tr>
                          <tr>
                            <td>High:</td>
                            <td> <input type="date" id="highRegDate" name="highRegDate" /> </td>
                          </tr>
                          <tr>
                            <td>H.Secy/Inter College:</td>
                            <td> <input type="date" id="interRegDate" name="interRegDate" /> </td>
                          </tr>
                        </table>
                      </div>

                    </div>
                    <h4>Institute Bank Detail </h4>
                    <strong>Bank Account: </strong>
                    <input class="p_input" id="bise_yes" required onclick="$('#bank_detail').show(); $('.bankDetail').prop('required', true);" type="radio" name="banka_acount_details" value="Yes" /> Yes
                    <input class="p_input" id="bise_no" required onclick="$('#bank_detail').hide(); $('.bankDetail').prop('required', false);" type="radio" name="banka_acount_details" value="Yes" /> No
                    <div id="bank_detail" style="display: none;">
                      <br />
                      <br />
                      <table class="table table-bordered">
                        <tr>
                          <td>Account Type:</td>
                          <td>
                            <input type="radio" class="bankDetail" name="accountTitle" value="Individual" class="flat-red" checked="checked"> Individual
                            <input type="radio" class="bankDetail" name="accountTitle" value="Designated" class="flat-red"> Designated
                            <input type="radio" class="bankDetail" name="accountTitle" value="Joint" class="flat-red"> Joint
                          </td>
                        </tr>
                        <tr>
                          <td>Bank Account No:</td>
                          <td> <input class="bankDetail" type="text" placeholder="Institution Bank Account No" name="bankAccountNumber" id="BankAccountNumber" /></td>
                        </tr>
                        <tr>
                          <td>Bank Title:</td>
                          <td> <input class="bankDetail" type="text" placeholder="Institution Bank Account No" name="bankAccountName" id="bankAccountName" /></td>
                        </tr>
                        <tr>
                          <td>Bank Branch Code:</td>
                          <td> <input class="bankDetail" type="text" name="bankBranchCode" placeholder="Enter Bank Branch Address" id="bankBranchCode" /></td>
                        </tr>
                        <tr>
                          <td>Bank Branch Address:</td>
                          <td> <input class="bankDetail" type="text" name="bankBranchAddress" placeholder="Enter Bank Branch Address" id="BankBranchAddress" /></td>
                        </tr>
                      </table>

                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col-md-12">
              <div style=" font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 5px; padding: 10px; background-color: white;">

                <a class="btn btn-danger" href="<?php echo site_url('login/logout'); ?>"> Logout </a>
                <button class="btn btn-primary">Save And Continue With Above Data <i class="fa fa-arrow-right" aria-hidden="true"></i></button>


              </div>
            </div>

          </form>
        </div>
      </div>


    </section>
    <!--/PAGE -->
    <!-- JAVASCRIPTS -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- JQUERY -->
    <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/jquery/jquery-2.0.3.min.js"></script>
    <!-- JQUERY UI-->
    <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
    <!-- BOOTSTRAP -->
    <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/bootstrap-dist/js/bootstrap.min.js"></script>

    <!-- UNIFORM -->
    <script type="text/javascript" src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/uniform/jquery.uniform.min.js"></script>
    <!-- BACKSTRETCH -->
    <script type="text/javascript" src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/backstretch/jquery.backstretch.min.js"></script>
    <!-- CUSTOM SCRIPT -->
    <script src="<?php echo base_url('assets/lib/plugins/input-mask/jquery.inputmask.js'); ?>"></script>

    <script>
      $(document).ready(function() {
        $('#telePhoneNumber').inputmask('99999999999');
        $('#cnic').inputmask('99999-9999999-9');
        $('#contactNumber').inputmask('(9999)-9999999');
        //$('#telePhoneNumber').inputmask('(9999)-9999999');
        $('#schoolMobileNumber').inputmask('(9999)-9999999');

        $('#late').inputmask('99.9999999');
        $('#long').inputmask('99.9999999');


      });
    </script>
</body>

</html>