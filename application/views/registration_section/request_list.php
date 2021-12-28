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
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active"><?php echo @ucfirst($title); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="padding-top: 0px !important;">

      <div class="box box-primary box-solid">


        <div class="box-body">
          <div class="row">

            <div class="col-md-4">


              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                <h4>New Registration Requests</h4>
                <table class="table table-bordered">
                  <tr>
                    <th>#</th>
                    <th>School ID</th>
                    <th>School Name</th>
                    <th>Action</th>
                  </tr>
                  <?php
                  $count = 1;
                  foreach ($new_registrations as $requests) { ?>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $requests->schoolId ?></td>
                    <td><?php echo $requests->schoolName ?></td>
                  <?php } ?>

                </table>
              </div>



            </div>

            <div class="col-md-4">


              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                <h4>New Registration Requests</h4>
                <table class="table table-bordered">
                  <tr>
                    <th>#</th>
                    <th>School ID</th>
                    <th>Reg. No.</th>
                    <th>School Name</th>
                    <th>Action</th>
                  </tr>
                  <?php
                  $count = 1;
                  foreach ($new_registrations as $requests) { ?>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $requests->schoolId ?></td>
                    <td><?php echo $requests->registrationNumber ?></td>
                    <td><?php echo $requests->schoolName ?></td>
                  <?php } ?>

                </table>
              </div>



            </div>
          </div>
        </div>


      </div>

    </section>

  </div>