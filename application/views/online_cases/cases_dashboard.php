<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<style>
  .table_small>tbody>tr>td,
  .table_small>tbody>tr>th,
  .table_small>tfoot>tr>td,
  .table_small>tfoot>tr>th,
  .table_small>thead>tr>td,
  .table_small>thead>tr>th {
    padding: 2px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
  }

  .btn-group-sm>.btn,
  .btn-sm {
    padding: 1px 1px !important;
    font-size: 12px;
    line-height: 1.5;
    border-radius: 3px;
  }

  .block_div {
    border: 1px solid #9FC8E8;
    border-radius: 10px;
    min-height: 3px;
    margin: 3px;
    padding: 10px;
    background-color: white;

  }

  @keyframes placeHolderShimmer {
    0% {
      background-position: -468px 0
    }

    100% {
      background-position: 468px 0
    }
  }

  .linear-background {
    animation-duration: 1s;
    animation-fill-mode: forwards;
    animation-iteration-count: infinite;
    animation-name: placeHolderShimmer;
    animation-timing-function: linear;
    background: #f6f7f8;
    background: linear-gradient(to right, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
    background-size: 1000px 104px;
    height: 30px;
    position: relative;
    overflow: hidden;
  }
</style>

<!-- Modal -->
<script>
  function view_request_detail(school_id, session_id) {
    $('#request_detail_body').html('Please Wait .....');
    $.ajax({
      type: "POST",
      url: "<?php echo site_url("online_cases/get_request_detail"); ?>",
      data: {
        school_id: school_id,
        session_id: session_id
      }
    }).done(function(data) {

      $('#request_detail_body').html(data);
    });

    $('#request_detail').modal('toggle');
  }

  function add_bank_challan(schools_id) {

    $('#request_detail_body').html('Please Wait .....');
    $.ajax({
      type: "POST",
      url: "<?php echo site_url("online_cases/school_session_list"); ?>",
      data: {
        schools_id: schools_id
      }
    }).done(function(data) {

      $('#request_detail_body').html(data);
    });

    $('#request_detail').modal('show');
  }
</script>
<div class="modal fade" id="request_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 90% !important;">
    <div class="modal-content" id="request_detail_body">

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



      <div class="col-lg-12 col-xs-12">

      </div>


      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="block_div">


              <table class="table table-bordered">
                <td>
                  <strong>Search By</strong>
                  <span style="margin-left: 15px;"></span>
                  <input type="radio" name="search_type" class="search_type" value="school_id" checked /> School ID
                </td>
                <td>

                  <input type="text" id="search" name="search" placeholder="School ID" value="" class="form-control" />
                </td>
                <td><button onclick="search_school()">Search</button></td>
                </tr>
              </table>





            </div>
          </div>
        </div>
        <?php
        $user_id = $this->session->userdata('userId');
        $query = "SELECT `users`.`region_ids` FROM `users`
        WHERE `users`.`userId` = '" . $user_id . "'";
        $region_ids = $this->db->query($query)->row()->region_ids;
        ?>
        <div class="row">
          <div class="col-md-6">
            <div class="block_div">
              <h4>Online Cases Summary</h4>
              <div class="table-responsive">


                <table class="table table-bordered" style="text-align:center; font-size:10px" id="test _table">
                  <thead>
                    <tr>
                      <th style="text-align: center;">Session</th>
                      <th style="text-align: center;">Applied</th>
                      <th style="text-align: center;">Pending (Queue)</th>
                      <th style="text-align: center;">Total Pending</th>
                      <td>Reg.</td>
                      <td>Ren.+Upgr</td>
                      <td>Upgr</td>
                      <td>Renewal</td>
                      <td>Fin.Deficients</td>
                      <td>(10%)</td>
                      <td>Issue Pending</td>
                    </tr>
                  </thead>

                  <tbody>

                    <?php
                    $query = "SELECT if((`district`.`new_region` = 1),'Central',if((`district`.`new_region` = 2),'South',if((`district`.`new_region` = 3),'Malakand',if((`district`.`new_region` = 4),'Hazara',if((`district`.`new_region` = 5),'Peshawar','Others'))))) AS `region`,
                    sum(if(`school`.`file_status` >=1 and school.status>0 ,1,0)) AS `total_applied`,
                    sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
                     sum(if(`school`.`status` = 1,1,0)) AS `total_issued`
                    from (((`school` 
                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                    WHERE `district`.`new_region` IN (" . $region_ids . ")
                    group by `district`.`new_region`";
                    $pending_files = $this->db->query($query)->result();
                    foreach ($pending_files as $pending) { ?>
                      <tr>
                        <th style="text-align: center;"><?php echo $pending->region; ?></th>
                        <td><?php echo $pending->total_applied; ?></td>
                        <td><?php echo $pending->previous_pending; ?></td>
                        <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
                        <td><?php echo $pending->registrations; ?></td>
                        <td><?php echo $pending->renewal_pgradations; ?></td>
                        <td><?php echo $pending->upgradations; ?></td>
                        <td><?php echo $pending->renewals; ?></td>
                        <td><?php echo $pending->financially_deficient; ?></td>
                        <td><?php echo $pending->marked_to_operation_wing; ?></td>
                        <td><?php echo $pending->completed_pending; ?></td>

                      </tr>
                    <?php } ?>

                  </tbody>
                  <tfoot>
                    <?php
                    $query = "SELECT if((`district`.`new_region` = 1),'Central',if((`district`.`new_region` = 2),'South',if((`district`.`new_region` = 3),'Malakand',if((`district`.`new_region` = 4),'Hazara',if((`district`.`new_region` = 5),'Peshawar','Others'))))) AS `region`,
                    sum(if(`school`.`file_status` >=1 and school.status>0 ,1,0)) AS `total_applied`,
                    sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
                     sum(if(`school`.`status` = 1,1,0)) AS `total_issued`
                    from (((`school` 
                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                    WHERE `district`.`new_region` IN (" . $region_ids . ")";
                    $pending = $this->db->query($query)->row(); ?>
                    <tr>
                      <th style="text-align: right;">Total: </th>
                      <td><?php echo $pending->total_applied; ?></td>
                      <td><?php echo $pending->previous_pending; ?></td>
                      <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
                      <td><?php echo $pending->registrations; ?></td>
                      <td><?php echo $pending->renewal_pgradations; ?></td>
                      <td><?php echo $pending->upgradations; ?></td>
                      <td><?php echo $pending->renewals; ?></td>
                      <td><?php echo $pending->financially_deficient; ?></td>
                      <td><?php echo $pending->marked_to_operation_wing; ?></td>
                      <td><?php echo $pending->completed_pending; ?></td>
                    </tr>
                  </tfoot>

                </table>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="block_div">
              <h4>Online Cases Summary</h4>
              <div class="table-responsive">

                <table class="table table-bordered" style="text-align:center; font-size:10px" id="test _table">
                  <thead>
                    <tr>
                      <th style="text-align: center;">Session</th>
                      <th style="text-align: center;">Applied</th>
                      <th style="text-align: center;">Pending (Queue)</th>
                      <th style="text-align: center;">Total Pending</th>
                      <td>Reg.</td>
                      <td>Ren.+Upgr</td>
                      <td>Upgr</td>
                      <td>Renewal</td>
                      <td>Fin.Deficients</td>
                      <td>(10%)</td>
                      <td>Issue Pending</td>
                      <td>Issued</td>
                    </tr>
                  </thead>

                  <tbody>

                    <?php
                    $query = "select `session_year`.`sessionYearTitle` AS `sessionYearTitle`,
                    sum(if(`school`.`file_status` >=1 and school.status>0 ,1,0)) AS `total_applied`,
                    sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
                     sum(if(`school`.`status` = 1,1,0)) AS `total_issued`
                    from (((`school` 
                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                    WHERE `district`.`new_region` IN (" . $region_ids . ")
                    group by `session_year`.`sessionYearTitle`";
                    $pending_files = $this->db->query($query)->result();
                    foreach ($pending_files as $pending) { ?>
                      <tr>
                        <th style="text-align: center;"><?php echo $pending->sessionYearTitle; ?></th>
                        <td><?php echo $pending->total_applied; ?></td>
                        <td><?php echo $pending->previous_pending; ?></td>
                        <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
                        <td><?php echo $pending->registrations; ?></td>
                        <td><?php echo $pending->renewal_pgradations; ?></td>
                        <td><?php echo $pending->upgradations; ?></td>
                        <td><?php echo $pending->renewals; ?></td>
                        <td><?php echo $pending->financially_deficient; ?></td>
                        <td><?php echo $pending->marked_to_operation_wing; ?></td>
                        <td><?php echo $pending->completed_pending; ?></td>
                        <td><?php echo $pending->total_issued; ?></td>

                      </tr>
                    <?php } ?>

                  </tbody>

                </table>

              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="block_div">
              <h4>Online Applied / Issued</h4>
              <div class="table-responsive">
                <table class="table table-bordered" style="font-size: 10px; text-align:center !important">
                  <tr>
                    <th></th>
                    <?php
                    $working_days = 0;
                    $current_date = time(); // get the current date and time as a Unix timestamp
                    $one_month_ago = strtotime('-1 month', $current_date); // get the Unix timestamp for one month ago

                    // loop through each day from one month ago until today and output the date in a desired format
                    for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                      $date = date('d M, y', $i);

                    ?>
                      <th> <?php echo $date;
                            echo '<br />';
                            if (date('N', $i) < 6) {
                              $working_days++;
                            }
                            ?></th>
                    <?php
                    }
                    ?>
                    <th style="text-align: center;">Last 30 Days Progress</th>
                    <th>Total Progress</th>
                    <th>AVG (<?php echo $working_days; ?> working days)</th>
                  </tr>
                  <tr>
                    <th>Applied</th>
                    <?php for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                      $date = date('Y-m-d', $i);
                      $query = "SELECT COUNT(*) as total FROM school WHERE DATE(apply_date) = '" . $date . "'"; ?>
                      <td>
                        <?php echo $this->db->query($query)->row()->total;  ?>
                      </td>
                    <?php } ?>
                    <th style="text-align: center;">
                      <?php $query = "SELECT COUNT(*) as total FROM school WHERE (DATE(apply_date) BETWEEN '" . date('Y-m-d', $one_month_ago) . "' and '" . date('Y-m-d', $current_date) . "')";
                      echo $total = $this->db->query($query)->row()->total; ?>
                    </th>
                    <th></th>
                    <th></th>
                  </tr>
                  <tr>
                    <th>Cer.issued</th>
                    <?php for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                      $date = date('Y-m-d', $i);
                      $query = "SELECT COUNT(*) as total FROM school WHERE DATE(cer_issue_date) = '" . $date . "'"; ?>
                      <td>
                        <?php echo $this->db->query($query)->row()->total;  ?>
                      </td>
                    <?php } ?>
                    <th style="text-align: center;">
                      <?php $query = "SELECT COUNT(*) as total FROM school WHERE (DATE(cer_issue_date) BETWEEN '" . date('Y-m-d', $one_month_ago) . "' and '" . date('Y-m-d', $current_date) . "')";
                      echo $total = $this->db->query($query)->row()->total; ?>
                    </th>
                    <th></th>
                    <th></th>
                  </tr>
                  <?php
                  $userId = $this->session->userdata('userId');
                  // if ($userId == 28727) {
                  $query = "SELECT users.userTitle, users.userId FROM `school`
                          INNER JOIN users ON(users.userId = school.note_sheet_completed)
                          AND school.file_status IN (10,4)
                          GROUP BY users.userId;";
                  $users = $this->db->query($query)->result();
                  foreach ($users as $user) {
                  ?>
                    <tr>
                      <th><?php echo $user->userTitle;  ?></th>
                      <?php for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                        $date = date('Y-m-d', $i);
                        $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND users.userId = '" . $user->userId . "'
                        AND DATE(note_sheet_completed_date) = '" . $date . "'";
                        $total = $this->db->query($query)->row()->total;
                      ?>
                        <td style="background-color: rgba(255, 0, 0, <?php echo $total; ?>%);">
                          <?php echo $total;  ?>
                        </td>
                      <?php } ?>
                      <th style="text-align: center;">
                        <?php $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND users.userId = '" . $user->userId . "'
                        AND (DATE(note_sheet_completed_date) BETWEEN '" . date('Y-m-d', $one_month_ago) . "' and '" . date('Y-m-d', $current_date) . "')";
                        echo $total = $this->db->query($query)->row()->total; ?>
                      </th>
                      <th style="text-align: center;">
                        <?php $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND users.userId = '" . $user->userId . "'";
                        echo $total = $this->db->query($query)->row()->total; ?>
                      </th>
                      <th>
                        <?php if ($total) {
                          echo round($total / $working_days, 2);
                        }

                        ?>
                      </th>
                      <!-- <th style="text-align: center;">
                        <?php
                        // $query = "
                        // SELECT AVG(total) AS avg_daily_entries
                        // FROM (SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        // INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        // AND school.file_status IN (10,4)
                        // AND users.userId = '" . $user->userId . "'
                        //       GROUP BY DATE(note_sheet_completed_date)
                        //       )
                        // AS daily_counts;
                        // ";
                        //echo $total = round($this->db->query($query)->row()->avg_daily_entries, 2);
                        ?>
                      </th> -->
                    </tr>
                  <?php } ?>
                  <?php //} 
                  ?>
                </table>

              </div>
            </div>

          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="block_div" id="new_request">
                <h5 style="text-align: center;" class="linear-background"></h5>
              </div>
            </div>
            <div class="col-md-6">
              <div class="block_div" id="deficientcasesList">
                <h5 style="text-align: center;" class="linear-background"></h5>
              </div>
            </div>

          </div>
        </div>


      </div>

  </section>

</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title" style="display: inline;"></h4>
        <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">
        ...
      </div>
      <div class="modal-footer" style="text-align: center;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Get the input field
  var input = document.getElementById("search");

  // Execute a function when the user presses a key on the keyboard
  input.addEventListener("keypress", function(event) {
    // If the user presses the "Enter" key on the keyboard
    if (event.key === "Enter") {
      school_id = $('#search').val();
      search(school_id);
    }
  });


  function search(search) {
    // var search = $('#search').val();
    var district_id = $('#district_id').val();
    var district_name = $('#district_id :selected').text();
    var search_by = $('input[name="search_type"]:checked').val();

    $.ajax({
        method: "POST",
        url: "<?php echo site_url('online_cases/school_summary'); ?>",
        data: {
          search: search,
          district_id: district_id,
          district_name: district_name,
          search_by: search_by,
          type: '<?php echo $type; ?>',
          region: '',
        },
      })
      .done(function(respose) {
        //$('#search_result').html(respose);
        $('#modal').modal('show');
        $('#modal_title').html("School Case Details");
        $('#modal_body').html(respose);
      });
  }

  function search_school() {
    var school_id = $('#search').val();

    search(school_id);
  }






  function get_new_requests() {
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('online_cases/get_new_requests'); ?>"
      })
      .done(function(respose) {
        $('#new_request').html(respose);
      });
  }

  function deficient_cases() {
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('online_cases/deficient_cases'); ?>"
      })
      .done(function(respose) {
        $('#deficientcasesList').html(respose);
      });
  }

  function notesheet() {
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('online_cases/notesheet'); ?>"
      })
      .done(function(respose) {
        $('#notesheet').html(respose);
      });
  }



  $(document).ready(function() {
    get_new_requests();
    deficient_cases();
    //notesheet();
  });
</script>
<script>
  $(document).ready(function() {
    $('#test_table').DataTable();
  });
</script>