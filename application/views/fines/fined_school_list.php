<script>
  function view_school_detail(schools_id) {
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('search/view_school_detail'); ?>",
        data: {
          schools_id: schools_id,
        },
      })
      .done(function(respose) {
        $('#view_school_detail_body').html(respose);
      });
    $('#view_school_detail').modal('toggle');
  }

  function marked_as_re_submit(school_id) {
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('previous_requests/marked_as_re_submit'); ?>",
        data: {
          school_id: school_id,
        },
      })
      .done(function(respose) {
        //alert(respose);
        if (respose) {
          $('#tr_' + school_id).hide();
        } else {
          alert("Error try again.");
        }

      });
  }

  function forward_for_challan_verification(school_id, challan_no, chalan_date) {
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('previous_requests/forward_for_challan_verification'); ?>",
        data: {
          school_id: school_id,
          challan_no: challan_no,
          chalan_date: chalan_date
        },
      })
      .done(function(respose) {
        //alert(respose);
        if (respose) {
          $('#tr_' + school_id).hide();
        } else {
          alert("Error try again.");
        }

      });

  }
</script>

<div class="modal fade" id="view_school_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 50% !important;">
    <div class="modal-content" id="view_school_detail_body">

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

          <div class="col-md-12">


            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">

              <table class="table table-bordered">
                <tr>
                  <th>#</th>
                  <th>District</th>
                  <th>School ID</th>
                  <th>School Name</th>
                  <th>REG No</th>
                  <th>Action</th>
                </tr>
                <?php
                $count = 1;
                $previous_school_id = 0;
                $query = "
                  SELECT 
                  
                  `schools`.`schoolName`,
                  `schools`.`schoolId`,
                  `schools`.`registrationNumber`,
                  `schools`.`schoolId`,
                  
                  `schools`.`isfined`,
                  `district`.`districtTitle`
                FROM
                  `schools` 
                  INNER JOIN `district` 
                    ON (
                      `district`.`districtId` = `schools`.`district_id`
                    ) 
                    WHERE  `schools`.`isfined`=1 
                  ORDER BY `schools`.`schoolId`
                          ";
                $previous_requests = $this->db->query($query)->result(); ?>
                <?php foreach ($previous_requests as $previous_request) { ?>
                  <tr id="tr_<?php echo $previous_request->school_id; ?>">
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $previous_request->districtTitle; ?></td>
                    <td><?php echo $previous_request->schoolId; ?></td>
                    <td><?php echo $previous_request->schoolName; ?></td>
                    <td><?php echo $previous_request->registrationNumber; ?></td>

                    <td>
                      <button class="btn btn-link btn-sm" onclick="view_school_detail('<?php echo $previous_request->schoolId; ?>')">View</button>
                    </td>
                  </tr>
                <?php
                  $previous_school_id = $previous_request->schools_id;
                } ?>
              </table>
            </div>



          </div>

        </div>
      </div>


    </div>

  </section>

</div>