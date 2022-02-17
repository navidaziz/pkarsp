  <!-- Modal -->
  <script>
    function verifiy_bank_challan(bank_challan_id) {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("bank_challans/get_bank_challan_detail"); ?>",
        data: {
          bank_challan_id: bank_challan_id
        }
      }).done(function(data) {

        $('#verifiy_bank_challan_body').html(data);
      });

      $('#verifiy_bank_challan').modal('toggle');
    }
  </script>
  <div class="modal fade" id="verifiy_bank_challan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="verifiy_bank_challan_body">

        ...

      </div>
    </div>
  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2 style="display:inline;">
        <?php echo ucwords(strtolower($title)); ?>
      </h2>
      <br />
      <small><?php echo ucwords(strtolower($description)); ?></small>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active"><?php echo @ucfirst($title); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="padding-top: 0px !important;">

      <div class="box box-primary box-solid">


        <div class="box-body">
          <div class="row">

            <div class="col-md-6">


              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                <h4>New Deposit Bank Challan Requests</h4>
                <table class="table table-bordered">
                  <tr>
                    <th>#</th>
                    <th>School ID</th>
                    <th>Challan Type</th>
                    <th title="System Trace Audit Number">STAN</th>
                    <th>Deposit Date</th>
                    <th>Action</th>
                  </tr>
                  <?php
                  $count = 1;
                  $previous_school_id = 0;
                  $query = "SELECT
                  `bank_challans`.*,
                  `session_year`.`sessionYearTitle`,
                  `school`.`schools_id`
                      FROM
                        `school`,
                        `bank_challans`,
                        `session_year`
                      WHERE `school`.`schoolId` = `bank_challans`.`school_id`
                        AND `session_year`.`sessionYearId` = `bank_challans`.`session_id`
                        AND  `bank_challans`.`verified` = '0' ORDER BY `bank_challans`.`schools_id`";
                  $session_bank_challans = $this->db->query($query)->result(); ?>
                  <?php foreach ($session_bank_challans as $session_bank_challan) { ?>
                    <tr>
                      <?php if ($previous_school_id != $session_bank_challan->schools_id) { ?>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $session_bank_challan->schools_id; ?></td>

                      <?php } else { ?>
                        <td colspan="2"></td>
                      <?php } ?>
                      <td><?php echo $session_bank_challan->challan_for; ?> - <?php echo $session_bank_challan->sessionYearTitle; ?></td>
                      <td><?php echo $session_bank_challan->challan_no; ?></td>
                      <td><?php echo date('d M, Y', strtotime($session_bank_challan->challan_date)); ?></td>
                      <td><button class="btn btn-success btn-sm" onclick="verifiy_bank_challan('<?php echo $session_bank_challan->bank_challan_id; ?>')">Verifiy Challan</button></td>
                    </tr>
                  <?php
                    $previous_school_id = $session_bank_challan->schools_id;
                  } ?>
                </table>
              </div>



            </div>
            <div class="col-md-6">

              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                <h4>Confirmed / Rejected Bank Challan Requests</h4>
                <table class="table table-bordered">
                  <tr>
                    <th>#</th>
                    <th>School ID</th>
                    <th>Challan Type</th>
                    <th title="System Trace Audit Number">STAN</th>
                    <th>Deposit Date</th>
                    <th>Status</th>
                  </tr>
                  <?php
                  $count = 1;
                  $query = "SELECT
                  `bank_challans`.*,
                  `session_year`.`sessionYearTitle`,
                  `school`.`schools_id`,
                  `school`.`status`
                      FROM
                        `school`,
                        `bank_challans`,
                        `session_year`
                      WHERE `school`.`schoolId` = `bank_challans`.`school_id`
                        AND `session_year`.`sessionYearId` = `bank_challans`.`session_id`
                        AND  `bank_challans`.`verified` != '0'";
                  $session_bank_challans = $this->db->query($query)->result(); ?>
                  <?php foreach ($session_bank_challans as $session_bank_challan) { ?>
                    <tr <?php if ($session_bank_challan->verified == 2) { ?> style="text-decoration:line-through;" <?php } ?>>
                      <td><?php echo $count++; ?></td>
                      <td><?php echo $session_bank_challan->schools_id; ?></td>
                      <td><?php echo $session_bank_challan->challan_for; ?></td>
                      <td><?php echo $session_bank_challan->challan_no; ?></td>
                      <td><?php echo date('d M, Y', strtotime($session_bank_challan->challan_date)); ?></td>
                      <td>
                        <?php if ($session_bank_challan->verified == 1) { ?>
                          <span class="label label-success"> Verified </span>
                        <?php  } ?>
                        <?php if ($session_bank_challan->verified == 2) { ?>
                          <span class="label label-danger">Not Verified</span>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php } ?>


                </table>
              </div>




            </div>
          </div>
        </div>


      </div>

    </section>

  </div>