<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>School Information</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PSRA</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!--   <meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0"> -->
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url("assets/images/site_images/favicon.png"); ?>" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href='<?php echo base_url("assets/lib/bootstrap/dist/css/bootstrap.min.css"); ?>'>
  <!-- Font Awesome -->
  <link rel="stylesheet" href='<?php echo base_url("assets/lib/font-awesome/css/font-awesome.min.css"); ?>'>
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href='<?php echo base_url("assets/dist/css/AdminLTE.min.css") ?>'>
  <!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href='<?php echo base_url("assets/dist/css/skins/skin-blue.min.css"); ?>'>
  <link rel="stylesheet" href='<?php echo base_url("assets/lib/jquery/dist/jquery-ui.css"); ?>'>
  <link rel="stylesheet" href='<?php echo base_url("assets/css/styles.css"); ?>'>

  <link rel="stylesheet" href='<?php echo base_url("assets/toastr/build/toastr.css"); ?>'>
  <!-- jQuery 3 -->
  <script src='<?php echo base_url("assets/lib/jquery/dist/jquery.min.js"); ?>'></script>
  <script src='<?php echo base_url("assets/lib/jquery/dist/jquery-ui.js"); ?>'></script>

  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url('assets/lib/plugins/iCheck'); ?>/all.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/lib'); ?>/select2/dist/css/select2.min.css">
  <link href="<?php echo base_url('assets/datatables/dataTables.bootstrap.css'); ?>" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url('assets/datatables/buttons.dataTables.min.css'); ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <link rel="stylesheet" href="//fonts.googleapis.com/earlyaccess/notonastaliqurdudraft.css">
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
          <h3 style="text-align: center;">PSRA Institute Registration Section A</h3>
          <form class="" method="post" enctype="multipart/form-data" id="create_form" action="<?php echo base_url('add_school/process_data'); ?>">



            <div class="col-md-4">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 10px; background-color: white;">
                <h4>Institute Details</h4>
                <div class="box-body">

                  <input type="hidden" name="reg_type_id" value="1">
                  <table class="table">
                    <tr>
                      <td>Institute Name</td>
                      <td><input type="text" id="name" required name="schoolName" value="" /> </td>
                    </tr>
                    <tr>
                      <td>Year of Establishment:</td>
                      <td>
                        <select name="e_month" require>
                          <option value="0">Select Month</option>
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
                        <select name="e_year" required>
                          <option value="0">Select Year</option>
                          <?php for ($years = 2021; $years >= 1950; $years--) { ?>
                            <option value="<?php echo $years; ?>"><?php echo $years; ?></option>
                          <?php } ?>
                        </select>
                        <!-- <input type="year" title="2021" max="<?php echo date('Y-m') ?>" id="yearOfEstiblishment" required name="yearOfEstiblishment" value="" /> -->
                      </td>
                    </tr>

                    <tr>
                      <td>Institute Contact No. (Landline) </td>
                      <td><input type="text" id="telePhoneNumber" required name="telePhoneNumber" value="" /> </td>
                    </tr>
                    <tr>
                      <td>Institute Contact No. (Mobile). </td>
                      <td><input type="text" id="schoolMobileNumber" required name="schoolMobileNumber" value="" /> </td>
                    </tr>

                    <tr>
                      <td>Institute Email</td>
                      <td><input type="email" id="principal_email" required name="principal_email" value="" /> </td>
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
                  <table style="width: 100%;">
                    <tr>
                      <td>District</td>
                      <td>Tehsil</td>
                      <td>UC/Cantonment</td>
                    </tr>
                    <tr>
                      <td><select style="width: 120px;" onchange="getTehsilsByDistrictId(this);" style="width:100%;" required="required" class="" name="district_id" id="district_id">
                          <option value="">Select District</option>
                          <?php foreach ($districts as $district) : ?>
                            <option value="<?php echo $district->districtId; ?>"><?php echo $district->districtTitle; ?></option>
                          <?php endforeach; ?>
                        </select> </td>

                      <td><select style="width: 120px;" required="required" class="" name="tehsil_id" onchange="getUcsByTehsilsId(this);" style="width: 100%;" id="tehsil_id">
                          <option value="">Select</option>

                        </select></td>

                      <td>
                        <select required onchange="check_uc();" style="width: 130px;" class="" name="uc_id" id="uc_id" style="width: 100%;">
                          <option value="">Select</option>
                        </select>
                      </td>
                    </tr>
                  </table>
                  <table style="width: 100%;">
                    <tr style="display: none;" id="others_uc">
                      <td>Write UC / Cantonment Name: </td>
                      <td><input type="text" id="uc_text" required name="uc_text" value="" /> </td>
                    </tr>
                    <tr>
                      <td>Village/City Name:</td>
                      <td> <input type="text" id="address" required name="address" value="" /> </td>
                    </tr>

                    <tr>
                      <td>
                        Postal Address </td>
                      <td><input type="text" id="postal_address" required name="postal_address" value="" /> </td>
                    </tr>

                    <tr>
                      <td>Latitude:<br />
                        <input style="width:100%" type="number" required placeholder="(Precision upto 6 decimal)" name="late" id="lat" step="any" />
                      </td>
                      <td>longitude:<br />
                        <input style="width:100%" type="number" required placeholder="(Precision upto 6 decimal)" name="longitude" id="lat" step="any" />
                      </td>
                    </tr>
                  </table>
                  <h4>Institute Owner Detail <small class="pull-right"><strong style="color:red; font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif;"> انسٹی ٹیوٹ کے مالک کی تفصیلات </strong></small></h4>
                  <p style="text-align: center; color:red; font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif;">

                    تفصیل وہی ہونی چاہیے جو اسٹامپ پیپر میں لکھی گئی ہو۔

                  </p>
                  <table class="table">
                    <tr>
                      <td>Owner Name</td>
                      <td><input type="text" required="required" name="userTitle" value="" id="userTitle" placeholder="Owner Name"></td>
                    </tr>
                    <tr>
                      <td>Owner Contact No.</td>
                      <td><input type="text" required="required" name="contactNumber" value="" id="contactNumber" placeholder="Mobile No."></td>
                    </tr>
                    <tr>
                      <td>Owner CNIC No.</td>
                      <td><input type="text" required="required" name="cnic" value="" id="cnic" placeholder="CNIC No."></td>
                    </tr>
                    <tr>
                      <td>Owner Gender</td>
                      <td>
                        <input type="radio" name="gender" value="1" required /> Male
                        <input type="radio" name="gender" value="2" required /> Female
                        <input type="radio" name="gender" value="3" required /> Other

                      </td>
                    </tr>
                    <tr>
                      <td>Address</td>
                      <td>
                        <input type="text" name="owner_address" value="" required />


                      </td>
                    </tr>
                  </table>
                </div>

              </div>
            </div>


            <div class="col-md-4">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height:500px;  margin: 5px; padding: 10px; background-color: white;">
                <div class="box-body">
                  <h4>Institute Others Details</h4>
                  <table class="table">
                    <tr>
                      <td colspan="2">
                        <strong>Institute Locality</strong>
                        <?php foreach ($locations as $location) { ?>
                          <input name="location" type="radio" value="<?= $location->locationTitle; ?>" required />
                          <?= $location->locationTitle; ?>
                        <?php } ?>
                      </td>
                    </tr>
                    <td colspan="2">
                      <strong>Institute Gender Education</strong>
                      <?php foreach ($gender_of_school as $gender) : ?>
                        <input type="radio" name="gender_type_id" value="<?= $gender->genderOfSchoolId; ?>" required /> <?= $gender->genderOfSchoolTitle; ?>
                      <?php endforeach; ?>
                    </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <strong>Institute Level (Current)</strong><br />

                        <?php foreach ($level_of_institute as $item) : ?>
                          <span style="margin-left: 10px;"></span>
                          <input type="radio" name="level_of_school_id" value="<?= $item->levelofInstituteId; ?>" required />
                          <?= $item->levelofInstituteTitle; ?>

                        <?php endforeach; ?>

                      </td>
                    </tr>
                    <tr>

                      <td colspan="2">
                        <strong> Institute Type:</strong><br />
                        <?php foreach ($school_types as $school_type) : ?>
                          <input <?php if ($school_type->typeId == 11) { ?> onclick="$('#school_type_other').show(); $('#ppcName').prop('required',false); $('#ppcCode').prop('required',false); $('#schoolTypeOther').prop('required',true); $('#ppc_school').hide();" <?php } ?> <?php if ($school_type->typeId == 2) { ?> onclick="$('#ppc_school').show(); $('#ppcName').prop('required',true); $('#ppcCode').prop('required',true); $('#schoolTypeOther').prop('required',false); $('#school_type_other').hide();" <?php } ?> <?php if ($school_type->typeId != 2 and $school_type->typeId != 11) { ?> onclick="$('#ppc_school').hide(); $('#ppcName').prop('required',false); $('#ppcCode').prop('required',false); $('#schoolTypeOther').prop('required',false); $('#school_type_other').hide()" <?php } ?> type="radio" name="school_type_id" value="<?= $school_type->typeId; ?>" required />
                          <?php echo $school_type->typeTitle; ?>

                          <?php if ($school_type->typeId == 2) { ?>
                            <div id="ppc_school" style="margin-left: 10px; margin-right: 10px; margin-top: 5px; display: none;">

                              <i>If the school is ppc then write the school name of gov school and EMIS code</i>
                              <table>
                                <tr>


                                  <td> Name of School: <input type="text" placeholder="Enter name of the gov. School" name="ppcName" class="form-control" id="ppcName" value="" />
                                  </td>
                                  <td>
                                    EMIS Code: <input type="text" placeholder="Enter EMIS Code" name="ppcCode" class="form-control" id="ppcCode" value="" />

                                  </td>
                                </tr>
                              </table>
                            </div>
                          <?php } ?>


                          <?php if ($school_type->typeId == 11) { ?>
                            <div id="school_type_other" style="margin-left: 10px; margin-right: 10px; margin-top: 5px; display: none;">
                              <input type="text" value="" name="schoolTypeOther" id="schoolTypeOther" />
                            </div>
                          <?php } ?>
                          <br />
                        <?php endforeach; ?>

                      </td>
                    </tr>



                    <tr>
                      <td colspan="2">
                        <strong>Medium of Instruction</strong>
                        <input type="radio" name="mediumOfInstruction" required value="Urdu"> Urdu
                        <input type="radio" name="mediumOfInstruction" required value="English"> English

                        <input type="radio" name="mediumOfInstruction" required value="Both"> Both

                      </td>
                    </tr>

                    <tr>
                      <td colspan="2">
                        <strong> Institute Nature of Management: </strong><br />
                        <input type="radio" name="management_id" value="1" required /> Individual
                        <input type="radio" name="management_id" value="2" required /> Registered Body/Firm
                        <input type="radio" name="management_id" value="3" required /> Association of Persons
                        <input type="radio" name="management_id" value="4" required /> Trust


                      </td>
                    </tr>
                  </table>
                </div>

              </div>
            </div>


            <div class="col-md-4">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 586px;  margin: 5px; padding: 10px; background-color: white;">
                <div class="box-body">


                  <h4>BISE Affiliation / Registration Details</h4>

                  <strong>Affiliated with BISE? </strong>
                  <input onclick="$('#bise_affiliation').show(); $('.bise_id').prop('required', true); $('.biseRegister').prop('required', true); " type="radio" value="Yes" name="biseAffiliated" required /> Yes
                  <input onclick="$('#bise_affiliation').hide(); $('.bise_id').prop('required', false); $('.biseRegister').prop('required', false); " type="radio" value="No" name="biseAffiliated" required /> No
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
                  <input required onclick="$('#bank_detail').show(); $('.bankDetail').prop('required', true);" type="radio" name="banka_acount_details" value="Yes" /> Yes
                  <input required onclick="$('#bank_detail').hide(); $('.bankDetail').prop('required', false);" type="radio" name="banka_acount_details" value="Yes" /> No
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
            <div style="clear: both;"></div>
            <div class="col-md-12">
              <div style=" font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 5px; padding: 10px; background-color: white;">
                <input class="btn btn-primary" type="submit" name="" value="Save And Continue With Above Data ">

              </div>
            </div>

          </form>
        </div>
      </div>


    </section>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src='<?php echo base_url("assets/lib/jquery/dist/jquery.min.js"); ?>'></script>
    <script type="text/javascript" src="<?php echo base_url('assets/datatables/tools/jquery.dataTables.min.js'); ?>"></script>


    <!-- dataTables Tools / -->

    <script type="text/javascript" src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js'); ?>"></script>

    <script type="text/javascript" src='<?php echo base_url("assets/toastr/build/toastr.min.js"); ?>'></script>

    <!-- <script type="text/javascript" src="<?php echo base_url('assets/lib/plugins/input-mask/jquery.inputmask.js'); ?>"></script> -->
    <!-- App -->
    <!-- <script type="text/javascript" src="<?php echo base_url('assets/js/app.js'); ?>" ></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/plugins.js'); ?>" ></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/plugins.form-components.js'); ?>" ></script> -->

    <!-- <script>
$(document).ready(function(){
  "use strict";

 // App.init(); // Init layout and core plugins
  Plugins.init(); // Init all plugins
  FormComponents.init(); // Init all form-specific plugins
});
</script> -->

    <!-- Bootstrap 3.3.7 -->
    <script src='<?php echo base_url("assets/lib/bootstrap/dist/js/bootstrap.min.js") ?>'></script>
    <!-- SlimScroll -->
    <script src='<?php echo base_url("assets/lib/jquery-slimscroll/jquery.slimscroll.min.js"); ?>'></script>
    <!-- FastClick -->
    <script src='<?php echo base_url("assets/lib/fastclick/lib/fastclick.js") ?>'></script>
    <!-- AdminLTE App -->
    <script src='<?php echo base_url("assets/dist/js/adminlte.js") ?>'></script>
    <!-- AdminLTE for demo purposes -->
    <script src='<?php echo base_url("assets/dist/js/demo.js"); ?>'></script>


    <!-- iCheck 1.0.1 -->
    <script src="<?php echo base_url('assets/lib/plugins/iCheck'); ?>/icheck.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url('assets/lib'); ?>/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url('assets/lib/plugins/input-mask/jquery.inputmask.js'); ?>"></script>

    <script>
      $(document).ready(function() {
        $('#telePhoneNumber').inputmask('(9999)-9999999');
        $('#cnic').inputmask('99999-9999999-9');
        $('#contactNumber').inputmask('(9999)-9999999');
        $('#schoolMobileNumber').inputmask('(9999)-9999999');



      });
    </script>

    <!-- /JAVASCRIPTS -->
</body>

</html>