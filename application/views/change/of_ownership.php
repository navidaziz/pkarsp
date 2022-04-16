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
                <a class="btn btn-primary" href="<?php echo site_url("print_file/print_change_of_ownership_bank_challan") ?>" target="new">Print change of building bank challan </a>
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
                <h4>Submit Application and Bank Challan Detail for Ownership Change</h4>
                <form action="<?php echo site_url("change/add_change_bank_challan"); ?>" method="post">
                  <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
                  <input type="hidden" name="challan_for" value="Change Of Ownership" />
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
                    <td>
                      Current Owner Detail<br />
                      Owner Name: <strong><?php echo ucwords(strtolower($school->userTitle)); ?></strong><br />
                      Owner CNIC: <strong><?php echo ucwords(strtolower($school->cnic)); ?></strong>
                      <input required type="hidden" name="institute_old_detail" value="<?php "Owner Name: " . ucwords(strtolower($school->userTitle)) . ", Owner CNIC: " . $school->cnic  ?>" />
                    </td>
                    <td>
                      New Owner Detail
                      <table class="table">
                        <tr>
                          <td>Owner Name:</td>
                          <td><input style="width: 100%;" type="text" name="owner_name" value="" required /></td>
                        </tr>
                        <tr>
                          <td>Owner CNIC:</td>
                          <td><input style="width: 100%;" type="text" name="owner_cnic" value="" required /></td>
                        </tr>
                      </table>


                    </td>
                    <tr>
                      <td>Bank Transaction No (STAN)</td>
                      <td>Bank Transaction Date</td>
                    </tr>
                    <tr>
                      <td><input required maxlength="6" name="challan_no" type="number" autocomplete="off" /><br />
                        <small>"STAN can be found on the upper right <br /> corner of bank generated receipt"</small>
                      </td>
                      <td><input required name="challan_date" type="date" />
                      </td>

                    </tr>
                    <tr>
                      <td colspan="2" style="text-align: center;">
                        <input type="submit" class="btn btn-success" name="submit" value="Submit Change of Ownership Request" />
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