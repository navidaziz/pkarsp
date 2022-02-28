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
              <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px"><strong>SECTION H</strong> ( Fee Concession )<br />
                <small style="color: red;">
                  Note: Every option is mandatory. you can fill with min value of 0.
                </small>
              </h4>

              </small>
              </p>


              <div class="col-md-12">
                <div style=" font-size: 16px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 10px; padding: 10px; background-color: white;">
                  <form method="post" action="<?php echo site_url("form/update_form_h_data"); ?>">
                    <input type="hidden" name="school_id" value="<?php echo $school_id ?>" />
                    <input type="hidden" name="session_id" value="<?php echo $session_id ?>" />
                    <table class="table table-bordered">
                      <thead class="small_font">
                        <tr>
                          <th>#</th>
                          <th>Concession Type</th>
                          <th>Total Students On Fee Concession</th>
                          <th>Fee Concession (In Precentage)</th>

                        </tr>
                      </thead>
                      <tbody class="small_font">
                        <?php $counter = 1; ?>
                        <?php
                        $query = "SELECT * FROM `concession_type`";
                        $fee_cencession_types = $this->db->query($query)->result();

                        ?>
                        <?php foreach ($fee_cencession_types as $fee_cencession_type) :
                          $query = "SELECT * FROM `fee_concession`
                            WHERE school_id = '" . $school_id . "'
                            AND concession_id = '" . $fee_cencession_type->concessionTypeId . "'";
                          $concession = $this->db->query($query)->result()[0];
                        ?>
                          <tr>
                            <th><?php echo $counter; ?></th>
                            <th><?php echo $fee_cencession_type->concessionTypeTitle; ?>

                            </th>
                            <td><input min="0" required type="number" name="concession_types[<?php echo $fee_cencession_type->concessionTypeId; ?>][numberOfStudent]" value="<?php echo $concession->numberOfStudent; ?>" /></td>
                            <td><input min="0" max="100" required type="number" name="concession_types[<?php echo $fee_cencession_type->concessionTypeId; ?>][percentage]" value="<?php echo $concession->percentage; ?>" /> <strong> % </strong></td>

                          </tr>
                          <?php $counter++; ?>
                        <?php endforeach; ?>


                        </td>

                      </tbody>
                    </table>

                </div>
              </div>

              <div class="col-md-12">
                <div style=" font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                  <a class="btn btn-success pull-left" href="<?php echo site_url("form/section_g/$school_id"); ?>">
                    <i class="fa fa-arrow-left" aria-hidden="true" style="margin-right: 10px;"></i> Previous Section ( Hazards with Associated Risk ) </a>
                  <?php if ($form_status->form_h_status == 1) { ?>
                    <span style="margin-left: 20px;"></span> <input class="btn btn-primary" type="submit" name="" value="Update Section H Data" />
                  <?php } else { ?>
                    <input class="btn btn-danger" type="submit" name="" value="Add Section H Data" />
                  <?php } ?>

                  <?php if ($form_status->form_h_status == 1) { ?>
                    <a class="btn btn-success pull-right" href="<?php echo site_url("form/submit_bank_challan/$school_id"); ?>"> Next Section (Bank Challan) <i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i></a>
                  <?php } ?>
                </div>
              </div>
              </form>
            </div>

          </div>
        </div>


      </div>

    </section>

  </div>