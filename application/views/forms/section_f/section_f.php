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

        <!-- /.box-header -->
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
              <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px"><strong>SECTION F</strong> (Security Measures)<br />
                <small style="color: red;">
                  Note:
                </small>
              </h4>

              </small>
              </p>

              <form class="form-horizontal" method="post" id="Form1" action="<?php echo base_url('form/update_from_f_data'); ?>">
                <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
                <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
                <input type="hidden" name="securityMeasureId" value="<?php echo $school_security_measures->securityMeasureId; ?>" />

                <div class="col-md-4">
                  <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 10px; padding: 10px; background-color: white;">
                    <h4>Institutional Security Measures:</h4>

                    <strong>Security Status:</strong>
                    <br />
                    <?php foreach ($security_status as $s_status) : ?>
                      <?php if ($s_status->securityStatusId == $school_security_measures->securityStatus) {
                        $check = "checked";
                      } else {
                        $check = '';
                      } ?>

                      <input type="radio" name="securityStatus" value="<?php echo $s_status->securityStatusId; ?>" required <?php echo $check; ?>> <?php echo $s_status->securityStatusTitle; ?>
                      <span style="margin-left: 20px;"></span>
                    <?php endforeach; ?>
                    <br />
                    <br />



                    <strong>Type of Security Provided:</strong>
                    <br />
                    <?php foreach ($security_provided as $provided) : ?>
                      <?php if ($provided->securityProvidedId == $school_security_measures->securityProvided) {
                        $check = "checked";
                      } else {
                        $check = '';
                      } ?>

                      <input type="radio" name="securityProvided" value="<?php echo $provided->securityProvidedId; ?>" required <?php echo $check; ?>> <?php echo $provided->securityProvidedTitle; ?>
                      <br />
                    <?php endforeach; ?>

                    <br />

                    <strong>Status of Security Personnel:</strong>
                    <br />
                    <?php foreach ($security_personnel as $s_personnel) : ?>
                      <?php if ($school_security_measures->security_personnel_status_id == $s_personnel->SecurityPersonnelId) {
                        $check = "checked";
                      } else {
                        $check = '';
                      } ?>

                      <input type="radio" name="security_personnel_status_id" value="<?php echo $s_personnel->SecurityPersonnelId ?>" required <?php echo $check; ?>> <?php echo $s_personnel->SecurityPersonnelTitle; ?>
                      <span style="margin-left: 20px;"></span>
                    <?php endforeach; ?>

                    <br />
                    <br />
                    <strong>Security Personnel (in Nos): </strong>
                    <span style="margin-left: 20px;"></span>
                    <input style="display: inline; width: 100px;" type="number" name="securityPersonnel" placeholder="Enter Security Personnel (in Nos)" id="securityPersonnel" value="<?php echo $school_security_measures->securityPersonnel; ?>" required />
                    <br />
                    <br />
                    <i>Whether security is inline with instruction of Police Department ?</i>
                    <span style="margin-left: 20px;"></span>
                    <?php $options = array("Yes", "No"); ?>
                    <?php foreach ($options as $key => $value) : ?>
                      <?php if ($school_security_measures->cameraInstallation == $value) {
                        $check = "checked";
                      } else {
                        $check = '';
                      } ?>

                      <input type="radio" <?php echo $check; ?> name="security_according_to_police_dept" value="<?php echo $value; ?>" required> <?php echo $value; ?>
                      <span style="margin-left: 20px;"></span>
                    <?php endforeach; ?>

                    <!-- //end here..... -->

                  </div>
                </div>
                <div class="col-md-4">
                  <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 10px; padding: 10px; background-color: white;">
                    <h4>CCTVs Camera's</h4>
                    <strong>CCTVs Camera System Installed:</strong>
                    <span style="margin-left: 10px;"></span>
                    <?php foreach ($options as $key => $value) : ?>
                      <?php if ($school_security_measures->cameraInstallation == $value) {
                        $check = "checked";
                      } else {
                        $check = '';
                      } ?>

                      <input type="radio" name="cameraInstallation" <?php echo $check; ?> value="<?php echo $value; ?>" required> <?php echo $value; ?>
                      <span style="margin-left: 20px;"></span>
                    <?php endforeach; ?>
                    <br />
                    <i> If is <strong>Yes</strong>, then number of CCTVs Cameras</i>

                    <input style="display: inline; width:50px" type="number" name="camraNumber" placeholder="Enter number of CCTVs Cameras" id="numberOfCam" value="<?php echo $school_security_measures->camraNumber; ?>" />
                    <br />
                    <br />

                    <strong>DVR Maintained</strong>
                    <span style="margin-left: 10px;"></span>
                    <?php foreach ($options as $key => $value) : ?>
                      <?php if ($school_security_measures->emergencyDoorsNumber == $value) {
                        $check = "checked";
                      } else {
                        $check = '';
                      } ?>
                      <input type="radio" name="dvrMaintained" <?php echo $check; ?> required value="<?php echo $value; ?>"> <?php echo $value; ?>
                      <span style="margin-left: 10px;"></span>
                    <?php endforeach; ?>

                    <br />
                    <br />

                    <strong>CCTVs Online Accessibility:</strong>
                    <span style="margin-left: 10px;"></span>
                    <?php foreach ($options as $key => $value) : ?>
                      <?php if ($school_security_measures->emergencyDoorsNumber == $value) {
                        $check = "checked";
                      } else {
                        $check = '';
                      } ?>
                      <input type="radio" name="cameraOnline" <?php echo $check; ?> value="<?php echo $value; ?>" required> <?php echo $value; ?>
                      <span style="margin-left: 10px;"></span>
                    <?php endforeach; ?>




                  </div>

                  <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 10px; padding: 10px; background-color: white;">
                    <strong>Emergency Exit Door Availability:</strong>
                    <br />

                    <?php foreach ($options as $key => $value) : ?>
                      <?php if ($school_security_measures->emergencyDoorsNumber == $value) {
                        $check = "checked";
                      } else {
                        $check = '';
                      } ?>
                      <input type="radio" name="emergencyDoorsNumber" <?php echo $check; ?> value="<?php echo $value; ?>" required> <?php echo $value; ?>
                      <span style="margin-left: 20px;"></span>
                    <?php endforeach; ?>
                    <br />

                    <i>Number of Exit Doors:</i>
                    <input style="display: inline; width:100px;" type="number" required name="exitDoorsNumber" placeholder="Enter Number of Exit Doors" id="exitDoorsNumber" value="<?php echo $school_security_measures->exitDoorsNumber; ?>" />
                    <br />
                    <br />


                    <strong>Boundary Wall Height (In Feet):</strong>
                    <input style="display: inline; width:100px;" type="number" required name="boundryWallHeight" placeholder="Enter Boundary Wall Height in Feet" class="form-control" id="boundryWallHeight" value="<?php echo $school_security_measures->boundryWallHeight; ?>" />
                    <br />
                    <br />

                    <strong>Barbed Wires Provided:</strong>
                    <span style="margin-left: 20px;"></span>
                    <?php foreach ($options as $key => $value) : ?>
                      <?php if ($school_security_measures->wiresProvided == $value) {
                        $check = "checked";
                      } else {
                        $check = '';
                      } ?>
                      <input type="radio" name="wiresProvided" <?php echo $check; ?> value="<?php echo $value; ?>" required> <?php echo $value; ?>
                      <span style="margin-left: 20px;"></span>
                    <?php endforeach; ?>
                    <br />
                    <strong>Watch Tower:</strong>
                    <span style="margin-left: 20px;"></span>
                    <?php foreach ($options as $key => $value) : ?>
                      <?php if ($school_security_measures->watchTower == $value) {
                        $check = "checked";
                      } else {
                        $check = '';
                      } ?>

                      <input type="radio" name="watchTower" <?php echo $check; ?> value="<?php echo $value; ?>" required> <?php echo $value; ?>
                      <span style="margin-left: 20px;"></span>
                    <?php endforeach; ?>




                  </div>



                </div>

                <div class="col-md-4">
                  <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 10px; padding: 10px; background-color: white;">
                    <strong>Number of Licensed Weapon(s):</strong>
                    <input style="display:inline; width:100px;" type="number" required name="licensedWeapon" placeholder="Enter Number of Licensed Weapon" class="form-control" id="licensedWeapon" value="<?php echo $school_security_measures->licensedWeapon; ?>" />
                    <br />
                    <br />
                    <strong>License issued by whom:</strong>
                    <br />
                    <?php foreach ($security_license_issued as $security_license_issue) : ?>
                      <?php if ($school_security_measures->license_issued_by_id == $security_license_issue->licenseIssuedId) {
                        $check = "checked";
                      } else {
                        $check = '';
                      } ?>
                      <input type="radio" name="license_issued_by_id" value="<?php echo $security_license_issue->licenseIssuedId; ?>" <?php echo $check; ?> />
                      <?php echo $security_license_issue->licenseIssuedTitle; ?>
                      <span style="margin-left: 10px;"></span>
                      <br />
                    <?php endforeach; ?>

                    <br />


                    <strong>License No(s):</strong>
                    <span style="margin-left: 10px;"></span>
                    <input min="0" style="display: inline; width: 150px;" type="text" required name="licenseNumber" placeholder="Enter License Number" class="form-control" id="licenseNumber" value="<?php echo $school_security_measures->licenseNumber; ?>" />
                    <br />
                    <br />
                    <strong>Ammunition Status (In Nos.):</strong>
                    <input min="0" style="display: inline; width: 100px;" type="number" required name="ammunitionStatus" placeholder="0" class="form-control" id="ammunitionStatus" value="<?php echo $school_security_measures->ammunitionStatus; ?>" />
                    <br />
                    <br />
                    <strong>Metal Detector:</strong>
                    <span style="margin-left: 10px;"></span>
                    <?php foreach ($options as $key => $value) : ?>
                      <?php if ($school_security_measures->metalDetector == $value) {
                        $check = "checked";
                      } else {
                        $check = '';
                      } ?>
                      <input type="radio" name="metalDetector" value="<?php echo $value; ?>" required <?php echo $check; ?>> <?php echo $value; ?>
                      <span style="margin-left: 10px;"></span>
                    <?php endforeach; ?>
                    <br />
                    <br />
                    <strong>Walkthrough gate:</strong>
                    <span style="margin-left: 10px;"></span>
                    <?php foreach ($options as $key => $value) : ?>
                      <?php if ($school_security_measures->walkThroughGate == $value) {
                        $check = "checked";
                      } else {
                        $check = '';
                      } ?>
                      <input type="radio" name="walkThroughGate" value="<?php echo $value; ?>" required <?php echo $check; ?> /> <?php echo $value; ?>
                      <span style="margin-left: 10px;"></span>
                    <?php endforeach; ?>
                    <br />
                    <br />
                    <strong>Main Gate Barrier:</strong>
                    <span style="margin-left: 10px;"></span>
                    <?php $check = ""; ?>
                    <?php foreach ($options as $key => $value) : ?>
                      <?php if ($school_security_measures->gateBarrier == $value) {
                        $check = "checked";
                      } else {
                        $check = '';
                      } ?>
                      <input type="radio" name="gateBarrier" value="<?php echo $value; ?>" required <?php echo $check; ?> /> <?php echo $value; ?>
                      <span style="margin-left: 10px;"></span>
                    <?php endforeach; ?>
                  </div>


                </div>
            </div>


            <div class="col-md-12">
              <div style=" font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                <a class="btn btn-success pull-left" href="<?php echo site_url("form/section_e/$school_id"); ?>">
                  <i class="fa fa-arrow-left" aria-hidden="true" style="margin-right: 10px;"></i> Previous Section ( School Fee Detail ) </a>
                <?php if ($form_status->form_f_status == 1) { ?>
                  <input class="btn btn-primary" type="submit" name="" value="Update Section F Data" />
                <?php } else { ?>
                  <input class="btn btn-danger" type="submit" name="" value="Add Section F Data" />
                <?php } ?>

                <?php if ($form_status->form_f_status == 1) { ?>
                  <a class="btn btn-success pull-right" href="<?php echo site_url("form/section_g/$school_id"); ?>"> Next Section ( Hazards With Associated Risk's ) <i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i></a>
                <?php } ?>
              </div>
            </div>




            </form>

          </div>

        </div>
      </div>


  </div>

  </div>
  </section>

  </div>