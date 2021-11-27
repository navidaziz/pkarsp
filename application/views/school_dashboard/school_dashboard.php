<style type="text/css">
  .error {
    color: red;
    font-weight: bold;
    font-size: 12px;
  }

  .form-popup {
    display: none;
    position: fixed;
    bottom: 0;
    right: 15px;
    border: 3px solid #f1f1f1;
    z-index: 9;
  }

  .form-container {
    max-width: 550px;
    padding: 10px;
    background-color: #ffe6e6;
  }

  .form-container input[type=number] {
    width: 30%;
    padding: 15px;
    margin: 5px 0 22px 0;
    border: 1px;
    background: white;
  }
  }

  .form-container label {
    width: 10%;
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h2 style="display:inline;">
      <?php echo ucwords(strtolower($school->schoolName)); ?>
    </h2><br />
    <small>
      <?php if ($school->district_id) {
        echo "District: <strong>" . $school->districtTitle . "</strong>";
      } ?>
      <?php if ($school->tehsil_id) {
        echo " / Tehsil: <strong>" . $school->tehsilTitle . "</strong>";
      } ?>
      <?php if ($school->pkNo) {
        echo " / Pk: <strong>" . $school->pkNo . "</strong>";
      } ?>
      <?php if ($school->uc_id) {
        echo " / Unionconsil: <strong>" . $school->ucTitle . "</strong>";
      } ?></small>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">School Dashboard</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content ">

    <div class="box box-primary box-solid">
      <div class="box-body">

        <div class="row">
          <div class="col-md-4">
            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 10px; padding: 10px; background-color: white;">
              <h2>School ID: <?php echo $school->schoolId ?></h2>
              <h3>Reg. ID: <?php echo $school->registrationNumber ?></h3>
              <br />
              <?php if (!empty($school->yearOfEstiblishment)) : ?>
                <?php echo "Established In: " . $school->yearOfEstiblishment; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($school->telePhoneNumber)) : ?>
                <?php echo "Tele-Phone #: " . $school->telePhoneNumber; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($school->genderOfSchoolTitle)) : ?>
                <?php echo "School For: " . $school->genderOfSchoolTitle; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($school->levelofInstituteTitle)) : ?>
                <?php echo "School Level: " . $school->levelofInstituteTitle; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($school->typeTitle)) : ?>
                <?php echo "School System: " . $school->typeTitle; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($school->schoolTypeOther)) : ?>
                <?php echo "School Level: " . $school->schoolTypeOther; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($school->mediumOfInstruction)) : ?>
                <?php echo "Medium Of Instruction: " . $school->mediumOfInstruction; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($school->managementTitle)) : ?>
                <?php echo "Management: " . $school->managementTitle; ?>
                <br>
              <?php endif; ?>
              <b>Bise Information</b><br>
              <?php if (!empty($school->biseregistrationNumber)) : ?>
                <?php echo "Bise Register: " . $school->biseregistrationNumber; ?>
                <br>
              <?php endif; ?>
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
              <?php if (!empty($school->biseAffiliated)) : ?>
                <?php echo "Bise Affiliation: " . $school->biseAffiliated; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($school->biseName) && $school->bise_id != 10) : ?>
                <?php echo "Bise Affiliated With: " . $school->biseName; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($school->otherBiseName)) : ?>
                <?php echo "Bise Affiliated With: " . $school->otherBiseName; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($bank_transaction)) : ?>
                <?php $count = 1;
                foreach ($bank_transaction as $bt) {
                  echo "<strong>Transaction</strong> # $count: " . $bt['bt_no'] . ' ' . "<strong> Date</strong>: " . $bt['bt_date'] . "<br>";
                  $count++;
                }  ?>
                <br>
              <?php endif; ?>

              <address>
                <strong>Adress</strong><br>

                <?php if (!empty($school->address)) : ?>
                  <?php echo $school->address; ?>
                  <br />
                <?php endif; ?>

                <?php if (!empty($school->late)) : ?>
                  <b>Latitude:</b>
                  <?php echo @$school->late; ?>
                  <br />
                <?php endif; ?>
                <?php if (!empty($school->longitude)) : ?>
                  <b>Longitude:</b>
                  <?php echo @$school->longitude; ?>
                <?php endif; ?>
              </address>

            </div>
          </div>

          <div class="col-md-5">
            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 10px; padding: 10px; background-color: white;">

              <?php if ($school->registrationNumber) { ?>
                <h3>Registration and renewal detail</h3>
                <table class="table table-bordered">
                  <tr>
                    <th>S/No.</th>
                    <th>Session</th>
                    <th>Applied</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Status Type</th>
                  </tr>
                  <?php
                  $count = 1;
                  $stop_appy = TRUE;
                  $query = "SELECT * FROM session_year WHERE sessionYearTitle >= '" . $school->yearOfEstiblishment . "-" . ($school->yearOfEstiblishment + 1) . "' ORDER BY sessionYearId ASC";
                  $sessions = $this->db->query($query)->result();
                  foreach ($sessions as $session) {
                    $query = "SELECT
                      `reg_type`.`regTypeTitle`
                      , `school_type`.`typeTitle`
                      , `levelofinstitute`.`levelofInstituteTitle`
                      , `gender`.`genderTitle`
                      , `school`.`status`
                      , `school`.`status_type`
                  FROM `reg_type`,
                  `school`,
                  `school_type`,
                  `levelofinstitute`,
                  `gender`  
                  WHERE `reg_type`.`regTypeId` = `school`.`reg_type_id`
                  AND `school_type`.`typeId` = `school`.`school_type_id`
                  AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
                  AND `gender`.`genderId` = `school`.`gender_type_id`
                  AND school.`schools_id`= '" . $school_id . "'
                  AND `school`.`session_year_id` = '" . $session->sessionYearId . "'";
                    $registaion_and_renewals = $this->db->query($query)->result();

                    if ($registaion_and_renewals) {
                      $registaion_and_renewal = $registaion_and_renewals[0]; ?>
                      <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $session->sessionYearTitle; ?></td>
                        <td><?php echo $registaion_and_renewal->regTypeTitle; ?></td>
                        <td><?php echo $registaion_and_renewal->levelofInstituteTitle; ?></td>
                        <td><?php echo $registaion_and_renewal->status; ?></td>
                        <td><?php echo $registaion_and_renewal->status_type; ?></td>

                      </tr>
                    <?php   } else { ?>
                      <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $session->sessionYearTitle; ?></td>
                        <td colspan="4">
                          <?php if ($stop_appy) { ?>
                            <a class="btn btn-success" href="<?php echo site_url("renewal/apply/$session->sessionYearId"); ?>">Apply for Renewal</a>
                            <a class="btn btn-warning" href="">Apply for Upgradation</a>
                          <?php } else { ?>

                          <?php } ?>
                        </td>

                      </tr>
                  <?php
                      $stop_appy = FALSE;
                    }
                  } ?>
                </table>
              <?php } else { ?>
                <h3>Apply for registration</h3>

              <?php  } ?>
            </div>
          </div>


        </div>
      </div>
    </div>
  </section>
</div>