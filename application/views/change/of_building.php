  <!-- Modal -->
  <script>
    function renewal_fee_sturucture() {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("apply/renewal_fee_sturucture"); ?>",
        data: {}
      }).done(function(data) {

        $('#renewal_sturucture_body').html(data);
      });

      $('#renewal_sturucture_model').modal('toggle');
    }
  </script>
  <div class="modal fade" id="renewal_sturucture_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="renewal_sturucture_body">

        ...

      </div>
    </div>
  </div>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2 style="display:inline;"><?php echo ucwords(strtolower($school->schoolName)); ?>

      </h2>
      <br />
      <small>
        <h4>S-ID: <?php echo $school->school_id; ?> <?php if ($school->registrationNumber) { ?> - REG No: <?php echo $school->registrationNumber ?> <?php } ?></h4>
      </small>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active"><?php echo @ucfirst($title); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="padding-top: 0px !important;">
      <div class="box box-primary box-solid">

        <div class="box-body" style="padding: 3px;">


          <div class="row">
            <div class="col-md-6">
              <div style="text-align: center;">
                <a class="btn btn-primary" href="<?php echo site_url("print_file/print_change_of_building_bank_challan") ?>" target="new">Print change of building bank challan </a>
              </div>
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px;">
                <h3> <i class="fa fa-info-circle" aria-hidden="true"></i> How to apply for Registration online ?</h3>
                <p>
                <ol>
                  <li>Print bank filled challan.</li>
                  <li>Deposit challan within due date.</li>
                  <li>Submit <strong>Bank STAN</strong> number and Transaction date</li>
                  <li>Click apply for online Registration button</li>
                  <li>View Registration application status on school dashboard</li>
                  </ul>
                </ol>
                </p>


              </div>
            </div>
            <div class="col-md-6">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px;">
                <h4>Submit Application and Bank Challan Detail for Location / Building Change</h4>
                <form action="<?php echo site_url("change/add_change_bank_challan"); ?>" method="post">
                  <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
                  <input type="hidden" name="challan_for" value="Change Of Building" />
                  <table class="table table-bordered">
                    <tr>
                      <td colspan="2">Application Subject:
                        <br /><input style="width: 100%;" type="text" name="application_subject" required />
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">Application Detail:<br />
                        <textarea style="width: 100%;" name="application_detail" required></textarea>
                      </td>
                    </tr>
                    <td>Location / Bulding Current Detail<br />
                      <?php if ($school->district_id) {
                        echo "District: <strong>" . $school->districtTitle . "</strong> <br />";
                      } ?>
                      <?php if ($school->tehsil_id) {
                        echo "Tehsil: <strong>" . $school->tehsilTitle . "</strong> <br />";
                      } ?>

                      <?php if ($school->uc_id) {
                        echo "Unioncouncil: <strong>" . $school->ucTitle . "</strong> <br />";
                      } else {
                        echo "Unioncouncil: <strong>" . $school->uc_text . "</strong> <br />";
                      } ?>
                      Address: <strong><?php echo $school->address; ?> </strong> <br />
                      Locality: <strong><?php echo $school->location; ?> </strong> <br />
                      Latitude: <strong><?php echo $school->late; ?> </strong> <br />
                      Longitude: <strong><?php echo $school->longitude; ?> </strong> <br />
                      <?php
                      $institude_old_detail = "";
                      $institude_old_detail .= "District: $school->districtTitle,";
                      $institude_old_detail .= "Tehsil: $school->tehsilTitle,";
                      $institude_old_detail .= "Unioncouncil: $school->ucTitle,";
                      $institude_old_detail .= "Other Union Consil: $school->uc_text,";
                      $institude_old_detail .= "Address: $school->address,";
                      $institude_old_detail .= "Locality: $school->location,";
                      $institude_old_detail .= "Latitude: $school->late,";
                      $institude_old_detail .= "Longitude: $school->longitude";
                      ?>
                      <textarea style="display: none;" name="institute_old_detail"><?php echo $institude_old_detail; ?></textarea>
                    </td>
                    <td>Location / Bulding New Detail<br />
                      <table class="table">
                        <tr>
                          <td>
                            District:
                          </td>
                          <td>
                            <input style="width: 100%" type="text" name="district" value="" required />
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Tehsil:
                          </td>
                          <td>
                            <input style="width: 100%" type="text" name="tehsil" value="" required />
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Union Council:
                          </td>
                          <td>
                            <input style="width: 100%" type="text" name="uc" value="" required />
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Address:
                          </td>
                          <td>
                            <input style="width: 100%" type="text" name="address" value="" required />
                          </td>
                        </tr>
                        <tr>
                          <td>Locality </td>
                          <td>
                            <input name="locality" type="radio" value="Urban" required /> Urban
                            <input name="locality" type="radio" value="Rural" required /> Rural

                          </td>
                        <tr>
                          <td>
                            Latitude:
                          </td>
                          <td>
                            <input style="width: 100%" type="text" name="latitude" value="" required />
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Longitude:
                          </td>
                          <td>
                            <input style="width: 100%" type="text" name="longitude" value="" required />
                          </td>
                        </tr>
                      </table>
                    </td>
                    <tr>
                      <td>Bank Transaction No (STAN)</td>
                      <td>Bank Transaction Date</td>
                    </tr>
                    <tr>
                      <td><input required maxlength="6" name="challan_no" type="number" autocomplete="off" />
                        <br />
                        <small>"STAN can be found on the upper right <br /> corner of bank generated receipt"</small>
                      </td>
                      <td><input required name="challan_date" type="date" />
                      </td>

                    </tr>
                    <tr>
                      <td colspan="2" style="text-align: center;">
                        <input type="submit" class="btn btn-success" name="submit" value="Submit Change of Building Request" />
                      </td>
                    </tr>
                  </table>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

  </div>