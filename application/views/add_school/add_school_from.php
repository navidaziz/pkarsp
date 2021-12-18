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
  <!-- FONTS -->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151551956-1"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-151551956-1');
  </script>
  <style type="text/css">
    .node {
      color: white !important;
    }

    #loading {
      display: none;
      position: fixed;
      z-index: 100000000;
      top: 40%;
      left: 40%;
      background-color: transparent;

    }

    @media (max-width: 991px) {

      .main-header .navbar-custom-menu a,
      .main-header .navbar-right a {
        color: gray;
        background: transparent;
      }
    }

    @media (max-width: 767px) {
      .skin-blue .main-header .navbar .dropdown-menu li a {
        color: gray;
      }
    }

    .bg-success {
      background-color: #fff !important;
      border-left: 6px solid red;
    }


    th {
      background-color: #9fc8e8;
    }

    thead {
      background-color: #9fc8e8;
    }

    .heading {
      background-color: #9fc8e8;
    }

    select.form-control,
    .form-control {
      border: 1px solid #8f8f8f;
      padding: 0 10px;
      height: 25px;
      display: inline-block;

      font-weight: normal;
      font-size: 14px;
      color: #000000;

    }

    .form-control:focus {


      -moz-box-shadow: 0px 0px 5px #79b7e7, inset 0 2px 2px #8f8f8f;
      -webkit-box-shadow: 0px 0px 5px #79b7e7, inset 0 2px 2px #8f8f8f;
      box-shadow: 0px 0px 5px #79b7e7, inset 0 2px 2px #8f8f8f;

    }

    textarea:focus {
      -moz-box-shadow: 0px 0px 5px #79b7e7, inset 0 2px 2px #8f8f8f;
      -webkit-box-shadow: 0px 0px 5px #79b7e7, inset 0 2px 2px #8f8f8f;
      box-shadow: 0px 0px 5px #79b7e7, inset 0 2px 2px #8f8f8f;




    }

    textarea {
      padding-top: 20px;
    }

    .content-wrapper {
      min-height: 100%;
      background-color: #fff;
      z-index: 800;
    }

    .shadow {
      -moz-box-shadow: 3px 3px 5px 6px #ccc;
      -webkit-box-shadow: 3px 3px 5px 6px #ccc;
      box-shadow: 3px 3px 5px 6px #ccc;
    }

    .box {
      background-color: #dfeffc;
    }

    .table {
      background-color: #dfeffc;
    }

    .light-blue {
      background-color: #dfeffc;
    }

    input[type=submit] {
      color: #fff;
    }

    table {
      margin: top:40px !important;
      font-size: 13px;
    }

    label {
      font-weight: 400;
      font-size: 14px;
      font-family: Arial;
      margin-bottom: 0;

    }

    .box-header {
      background-color: #9fc8e8 !important;
      text-transform: uppercase;
      font-size: 14px;
      color: black !important;
    }

    .skin-blue .sidebar a {
      color: black;
      font-weight: 700;
      font-size: 15px;
    }

    .skin-blue .sidebar-menu>li:hover>a,
    .skin-blue .sidebar-menu>li.active>a,
    .skin-blue .sidebar-menu>li.menu-open>a {
      background-color: #d0e5f5;
      color: black;
    }

    .skin-blue .sidebar-menu>li>.treeview-menu {
      margin-top: 0;
      background: #d0e5f5;
    }

    .skin-blue .sidebar-menu .treeview-menu>li>a:hover {
      color: red;
    }

    .skin-blue .sidebar-menu .treeview-menu>li>a {
      color: black;
      font-size: 13px;
      font-weight: 600;
    }

    .node {
      color: red !important;
    }

    a.btn-link {
      color: black !important;
      font-size: 13px !important;
      font-weight: bold;
      text-decoration: underline;
    }
    }

    body {
      font-family: Arial;
    }

    .btn {
      border-radius: 5px !important;
    }

    html {
      zoom: 90%;
    }

    .table {
      background-color: #dfeffc;
    }

    .modal-content {
      background-color: #dfeffc;
    }

    .content-header>.breadcrumb>li>a {
      color: #444;
      text-decoration: none;
      display: inline-block;
      font-size: larger !important;
      color: #5C9CCC !important;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
      padding: 3px !important;

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

    <section id="login_bg" <?php if ($this->input->get('register') != 1) { ?>class="visible" <?php } ?>>
      <div class="container">
        <div class="row" style="margin: 10px; margin-top: 10px;">
          <form class="" method="post" enctype="multipart/form-data" id="create_form" action="<?php echo base_url('add_school/process_data'); ?>">



            <div class="col-md-4">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 10px; padding: 10px; background-color: white;">
                <h3>Institute Detail</h3>
                <div class="box-body">

                  <input type="hidden" name="reg_type_id" value="1">
                  <table class="table">
                    <tr>
                      <td>Institute Name</td>
                      <td><input type="text" id="name" required name="schoolName" value="" /> </td>
                    </tr>
                    <tr>
                      <td>Year of Establishment:</td>
                      <td><input type="month" id="yearOfEstiblishment" required name="yearOfEstiblishment" value="" /> </td>
                    </tr>

                    <tr>
                      <td>Institute Contact No. </td>
                      <td><input type="number" id="telePhoneNumber" required name="telePhoneNumber" value="" /> </td>
                    </tr>
                    <tr>
                      <td>Contact No (Mobile). </td>
                      <td><input type="number" id="schoolMobileNumber" required name="schoolMobileNumber" value="" /> </td>
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
                      </script>
                    </tr>
                  </table>
                  <h4>Institute Address Detail</h4>
                  <table class="table">
                    <tr>
                      <td>District</td>
                      <td>Tehsil</td>
                      <td>UC/Cantonment</td>
                    </tr>
                    <tr>
                      <td><select onchange="getTehsilsByDistrictId(this);" style="width:100%;" required="required" class="form-control select2" name="district_id" id="district_id">
                          <option value="">Select District</option>
                          <?php foreach ($districts as $district) : ?>
                            <option value="<?php echo $district->districtId; ?>"><?php echo $district->districtTitle; ?></option>
                          <?php endforeach; ?>
                        </select> </td>

                      <td><select required="required" class="form-control select2" name="tehsil_id" onchange="getUcsByTehsilsId(this);" style="width: 100%;" id="tehsil_id">
                          <option value="">Select</option>

                        </select></td>

                      <td>
                        <select class="form-control select2" name="uc_id" id="uc_id" style="width: 100%;">
                          <option value="">Select</option>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td colspan="2">UC Name</td>
                      <td><input type="text" id="uc_text" required name="uc_text" value="" /> </td>
                    </tr>
                    <tr>
                      <td colspan="2">Village/City Name</td>
                      <td><input type="text" id="address" required name="address" value="" /> </td>
                    </tr>

                    <tr>
                      <td colspan="2">
                        Postal Address <input type="text" id="postal_address" required name="postal_address" value="" /> </td>
                    </tr>

                    <tr>
                      <td colspan="2">Latitude:<br />
                        <input style="width:100%" type="number" required placeholder="(Precision upto 6 decimal)" name="late" id="lat" step="any" />
                      </td>
                      <td>longitude:<br />
                        <input style="width:100%" type="number" required placeholder="(Precision upto 6 decimal)" name="longitude" id="lat" step="any" />
                      </td>
                    </tr>
                  </table>
                  <h4>Institute Owner Detail</h4>
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
                        <input type="text" name="woner_address" value="" required />


                      </td>
                    </tr>
                  </table>
                </div>

              </div>
            </div>


            <div class="col-md-4">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 610px;  margin: 10px; padding: 10px; background-color: white;">
                <div class="box-body">
                  <h4>Institute Others Detail</h4>
                  <table class="table">
                    <tr>
                      <td colspan="2">
                        <strong>Institute Locality</strong>
                        <?php foreach ($locations as $location) { ?>
                          <input name="location" type="radio" value="<?= $location->locationTitle; ?>" <?php echo $selected ?> />
                          <?= $location->locationTitle; ?>
                        <?php } ?>
                      </td>
                    </tr>
                    <td colspan="2">
                      <strong>Institute Gender Education</strong>
                      <?php foreach ($gender_of_school as $gender) : ?>
                        <input type="radio" name="gender_type_id" value="<?= $gender->genderOfSchoolId; ?>" /> <?= $gender->genderOfSchoolTitle; ?>
                      <?php endforeach; ?>
                    </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <strong>Institute Level (Current)</strong><br />

                        <?php foreach ($level_of_institute as $item) : ?>
                          <input type="radio" name="level_of_school_id" value="<?= $item->levelofInstituteId; ?>" />
                          <?= $item->levelofInstituteTitle; ?>
                          <br />
                        <?php endforeach; ?>

                      </td>
                    </tr>
                    <tr>

                      <td colspan="2">
                        <strong> Institute Type:</strong><br />
                        <?php foreach ($school_types as $school_type) : ?>
                          <input <?php if ($school_type->typeId == 11) { ?> onclick="$('#school_type_other').show(); $('#ppcName').prop('required',false); $('#ppcCode').prop('required',false); $('#schoolTypeOther').prop('required',true); $('#ppc_school').hide();" <?php } ?> <?php if ($school_type->typeId == 2) { ?> onclick="$('#ppc_school').show(); $('#ppcName').prop('required',true); $('#ppcCode').prop('required',true); $('#schoolTypeOther').prop('required',false); $('#school_type_other').hide();" <?php } ?> <?php if ($school_type->typeId != 2 and $school_type->typeId != 11) { ?> onclick="$('#ppc_school').hide(); $('#ppcName').prop('required',false); $('#ppcCode').prop('required',false); $('#schoolTypeOther').prop('required',false); $('#school_type_other').hide()" <?php } ?> type="radio" name="school_type_id" value="<?= $school_type->typeId; ?>" />
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
                        <input type="radio" name="management_id" value="1" /> Individual
                        <input type="radio" name="management_id" value="2" /> Registered Body/Firm
                        <input type="radio" name="management_id" value="3" /> Association of Persons
                        <input type="radio" name="management_id" value="4" /> Trust


                      </td>
                    </tr>
                  </table>
                </div>

              </div>
            </div>


            <div class="col-md-4">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 610px;  margin: 10px; padding: 10px; background-color: white;">
                <div class="box-body">
                  <h4>BISE Registration Detail</h4>
                  <strong>BISE Registered</strong>
                  <input onclick="$('#bise_registration_date').show(); $('#biseregistrationNumber').prop('required', true);" type="radio" value="Yes" name="biseRegister" required /> Yes
                  <input onclick="$('#bise_registration_date').hide(); $('#biseregistrationNumber').prop('required', false);" type="radio" value="No" name="biseRegister" required /> No


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

                  <h4>BISE Affiliation Detail</h4>

                  <strong>Affiliated with BISE? </strong>
                  <input onclick="$('#bise_affiliation').show(); $('#bise_id').prop('required', true);" type="radio" value="Yes" name="biseAffiliated" required /> Yes
                  <input onclick="$('#bise_affiliation').hide(); $('#bise_id').prop('required', false);" type="radio" value="No" name="biseAffiliated" required /> No
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


                  </div>
                  <h4>Institute Bank Detail </h4>
                  <strong>Bank Account: </strong>
                  <input onclick="$('#bank_detail').show(); $('.bankDetail').prop('required', true);" type="radio" name="banka_acount_details" value="Yes" /> Yes
                  <input onclick="$('#bank_detail').hide(); $('.bankDetail').prop('required', false);" type="radio" name="banka_acount_details" value="Yes" /> No
                  <div id="bank_detail" style="display: none;">
                    <br />
                    <br />
                    <table class="table table-bordered">
                      <tr>
                        <td>Account Type:</td>
                        <td>
                          <input type="radio" class="bankDetail" name="accountTitle" value="Individual" class="flat-red" checked="checked"> Individual
                          <input type="radio" class="bankDetail" name="accountTitle" value="Designated" class="flat-red"> Designated
                          <input type="radio" name="bankDetail" value="Joint" class="flat-red"> Joint
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
              <div style=" font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                <input class="btn btn-primary" type="submit" name="" value="Save And Continue With Above Data ">

              </div>
            </div>

          </form>
        </div>
      </div>


    </section>




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
    <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/script.js"></script>
    <script>
      jQuery(document).ready(function() {
        App.setPage("login_bg"); //Set current page
        App.init(); //Initialise plugins and elements
      });
    </script>
    <script type="text/javascript">
      function swapScreen(id) {
        jQuery('.visible').removeClass('visible animated fadeInUp');
        jQuery('#' + id).addClass('visible animated fadeInUp');
      }
    </script>
    <script>
      $(document).ready(function() {
        $('#telePhoneNumber').inputmask('(9999)-9999999');
        $('#cnic').inputmask('99999-9999999-9');
        $('#contactNumber').inputmask('(9999)-9999999');

      });
    </script>

    <!-- /JAVASCRIPTS -->
</body>

</html>