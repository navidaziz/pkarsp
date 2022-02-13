  <!-- Modal -->
  <script>
    function verifiy_bise(id) {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("bise_verification/get_bise_verification_detail"); ?>",
        data: {
          id: id
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
                <h4>New BISE Verification Requests</h4>
                <table class="table table-bordered">
                  <tr>
                    <th>#</th>
                    <th>School ID</th>
                    <th>School Name</th>
                    <th>Date</th>
                    <th>BISE</th>
                    <th>REG. No</th>
                    <th>Action</th>
                  </tr>
                  <?php
                  $count = 1;
                  $previous_school_id = 0;
                  $query = "SELECT
                          `schools`.`schoolName`
                          , `schools`.`schoolId`
                          , `bise`.`biseName`
                          , `bise_verification_requests`.`registration_number`
                          , `bise_verification_requests`.`created_date`
                          , `bise_verification_requests`.`id`
                      FROM
                          `bise_verification_requests`
                  INNER JOIN `schools` 
                      ON (`bise_verification_requests`.`school_id` = `schools`.`schoolId`)
                  LEFT JOIN `bise` 
                      ON (`bise`.`biseId` = `bise_verification_requests`.`bise_id`)
                      WHERE `bise_verification_requests`.`status`=0";
                  $session_bise_verifications = $this->db->query($query)->result(); ?>
                  <?php foreach ($session_bise_verifications as $session_bise_verification) { ?>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td><?php echo $session_bise_verification->schoolId; ?></td>
                      <td><?php echo $session_bise_verification->schoolName; ?></td>
                      <td><?php echo date('d M, Y', strtotime($session_bise_verification->created_date)); ?></td>
                      <td><?php echo $session_bise_verification->biseName; ?></td>
                      <td><?php echo $session_bise_verification->registration_number; ?></td>
                      <td><button class="btn btn-success btn-sm" onclick="verifiy_bise('<?php echo $session_bise_verification->id; ?>')">Verifiy</button></td>
                    </tr>
                  <?php } ?>
                </table>
              </div>



            </div>
            <div class="col-md-6">

              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                <h4>Verified / Not Verified BISE REG. List</h4>

                <table class="table table-bordered">
                  <tr>
                    <th>#</th>
                    <th>School ID</th>
                    <th>School Name</th>
                    <th>Date</th>
                    <th>BISE</th>
                    <th>REG. No</th>
                    <th>Action</th>
                  </tr>
                  <?php
                  $count = 1;
                  $previous_school_id = 0;
                  $query = "SELECT
                          `schools`.`schoolName`
                          , `schools`.`schoolId`
                          , `bise`.`biseName`
                          , `bise_verification_requests`.`registration_number`
                          , `bise_verification_requests`.`created_date`
                          , `bise_verification_requests`.`id`
                          , `bise_verification_requests`.`status`
                      FROM
                          `bise_verification_requests`
                  INNER JOIN `schools` 
                      ON (`bise_verification_requests`.`school_id` = `schools`.`schoolId`)
                  LEFT JOIN `bise` 
                      ON (`bise`.`biseId` = `bise_verification_requests`.`bise_id`)
                      WHERE `bise_verification_requests`.`status` IN(1,2)";
                  $session_bise_verifications = $this->db->query($query)->result(); ?>
                  <?php foreach ($session_bise_verifications as $session_bise_verification) { ?>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td><?php echo $session_bise_verification->schoolId; ?></td>
                      <td><?php echo $session_bise_verification->schoolName; ?></td>
                      <td><?php echo date('d M, Y', strtotime($session_bise_verification->created_date)); ?></td>
                      <td><?php echo $session_bise_verification->biseName; ?></td>
                      <td><?php echo $session_bise_verification->registration_number; ?></td>
                      <td><?php if ($session_bise_verification->status == 1) { ?>
                          <span class="label label-success"> Verified </span>
                        <?php  } ?>
                        <?php if ($session_bise_verification->status == 2) { ?>
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