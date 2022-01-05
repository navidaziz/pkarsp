<div class="modal-header">
  <h4 style="border-left: 20px solid #9FC8E8;  padding-left:5px;" class="pull-left">
    Request Detail
  </h4>
  <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">

  <div class="row">
    <div class="col-md-4" style="padding-right: 1px; padding-left: 1px;">
      <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 5px; padding: 5px; background-color: white;">

        <h2 style="display:inline;">
          <?php echo ucwords(strtolower($school->schoolName)); ?><br />
          <h5 style="display:inline;"> School ID: <?php echo $school->schools_id ?><br />
            <?php if ($school->registrationNumber > 0) { ?> Reg. ID:
              <?php echo $school->registrationNumber ?>
            <?php } ?>
          </h5>
        </h2>
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

        <address>
          <?php if ($school->telePhoneNumber) { ?>Telephone: <?php echo $school->telePhoneNumber ?> <?php } ?><br />
        <?php if ($school->schoolMobileNumber) { ?>Mobile: <?php echo $school->schoolMobileNumber ?> <?php } ?><br />
      <?php if ($school->principal_email) { ?>Email: <?php echo $school->principal_email ?> <?php } ?><br />

        </address>
        <br />
        <?php if (!empty($school->yearOfEstiblishment)) : ?>
          <?php echo "Established In: " . $school->yearOfEstiblishment; ?>
          <br>
        <?php endif; ?>
        <?php if (!empty($school->levelofInstituteTitle)) : ?>
          <?php echo "Institute Level: " . $school->levelofInstituteTitle; ?>
          <br>
        <?php endif; ?>

        <?php if (!empty($school->genderOfSchoolTitle)) : ?>
          <?php echo "Gender Education: " . $school->genderOfSchoolTitle; ?>
          <br>
        <?php endif; ?>

        <?php if (!empty($school->telePhoneNumber)) : ?>
          <?php echo "Tele-Phone #: " . $school->telePhoneNumber; ?>
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

        <br /><strong>Owner Detail </strong><br />
        <?php if ($school->userTitle) { ?>Owner Name: <?php echo $school->userTitle ?> <?php } ?><br />
      <?php if ($school->cnic) { ?>Owner CNIC: <?php echo $school->cnic ?> <?php } ?><br />
    <?php if ($school->contactNumber) { ?>Contact No: <?php echo $school->contactNumber ?> <?php } ?><br />
      </div>

    </div>

    <div class="col-md-8" style="padding-right: 1px; padding-left: 1px;">
      <div class="col-md-12" style="padding-right: 1px; padding-left: 1px;">
        <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 5px;  margin: 5px; padding: 5px; background-color: white;">

          <table class="table">
            <tr>
              <th>Request Type</th>
              <th>Session</th>
              <th>Institute Type</th>
              <th>Institute Level</th>
              <th>Date</th>
            </tr>
            <tr>
              <td><?php echo $session_request_detail->regTypeTitle ?></td>
              <td><?php echo $session_request_detail->sessionYearTitle ?></td>
              <td><?php echo $session_request_detail->typeTitle ?></td>
              <td><?php echo $session_request_detail->levelofInstituteTitle ?></td>
              <td><?php echo $session_request_detail->created_date; ?></td>
            </tr>
          </table>

        </div>
      </div>
      <div class="col-md-4" style="padding-right: 1px; padding-left: 1px;">

        <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
          <h4> <i class="fa fa-info-circle" aria-hidden="true"></i> School Summarized Data</h4>
          <ol>
            <li>Institute established: <strong>
                <?php echo date('M Y', strtotime($school->yearOfEstiblishment)); ?></strong></li>
            <li>
              <?php if (!empty($school->biseregistrationNumber)) { ?>
                <?php echo "BISE Registration No: " . $school->biseregistrationNumber; ?>
                <?php if ($school->bise_verified == "Yes") { ?>
                  <strong style="color:green"> Verified </strong>
                <?php } else { ?>
                  <strong style="color:red"> Not Verified </strong>
                <?php } ?>
              <?php } else { ?>
                BISE Rregistration: <strong>No</strong>
              <?php } ?>
            </li>
            <li>First Appointment: <strong><?php echo date('d M, Y', strtotime($first_appointment_staff->appoinment_date)); ?></strong>
              ( <?php echo $first_appointment_staff->name ?> )

            </li>
            <li>Institute Max Fee:
              <strong><?php echo $max_tuition_fee; ?> Rs. </strong> per month.
            </li>




          </ol>

          <button onclick="renewal_fee_sturucture()" class="btn btn-link">
            <i class="fa fa-info-circle" aria-hidden="true"></i> PSRA Registration Fee Struture Detail</button>
        </div>
      </div>
      <div class="col-md-8" style="padding-right: 1px; padding-left: 1px;">

        <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">

          <table class="table">
            <thead>
              <tr>
                <th>Fee Category</th>
                <th>Amount (Rs.)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Application Processing Fee</td>
                <td><?php echo number_format($fee_sturucture->renewal_app_processsing_fee); ?> Rs.</td>
              </tr>
              <tr>
                <td>Inspection Fee</td>
                <td><?php echo number_format($fee_sturucture->renewal_app_inspection_fee); ?> Rs.</td>
              </tr>

              <tr>
                <td><strong>Total Session <?php echo $session_detail->sessionYearTitle; ?> Registration Fee </strong></td>
                <td>
                  <strong>
                    <?php $total = $fee_sturucture->renewal_app_processsing_fee + $fee_sturucture->renewal_app_inspection_fee;

                    echo number_format($total);
                    ?> Rs.
                  </strong>
                </td>
              </tr>

              <tr>
                <td>Late Fee Fine <small><?php
                                          if ($late_fee->fine_percentage) {
                                            echo  $late_fee->fine_percentage;
                                          } else {
                                            echo 100;
                                          }
                                          ?>% </small>
                </td>
                <td><?php
                    if ($late_fee->fine_percentage) {
                      $fine = ($late_fee->fine_percentage * $total) / 100;
                    } else {
                      $fine =  (100 * $total) / 100;
                    }
                    echo number_format($fine);
                    ?>
                  Rs.</td>
              </tr>
              <tr>
                <?php
                $query = "SELECT * FROM `levelofinstitute` WHERE `levelofinstitute`.`levelofInstituteId` = $school->level_of_school_id";
                $level_securities = $this->db->query($query)->result()[0];

                ?>
                <td>Security Fee (<?php echo $level_securities->levelofInstituteTitle; ?>)</td>
                <td>
                  <?php echo number_format($level_securities->security_fee); ?> Rs.

                </td>
              </tr>
              <?php if ($session_id == 1) { ?>
                <tr>
                  <td>2018-19 Special Fine (<?php echo $level_securities->levelofInstituteTitle; ?>)</td>
                  <td>
                    <?php echo number_format($special_fine); ?> Rs.

                  </td>
                </tr>
              <?php } ?>
              <tr>

                <td colspan="2" style="text-align: right;">
                  <h4>Total <?php echo number_format($total + $fine + $level_securities->security_fee + $special_fine); ?> Rs.</h4>
                </td>

              </tr>

            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

</div>