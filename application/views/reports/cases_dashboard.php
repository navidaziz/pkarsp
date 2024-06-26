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
              <h4>Online Cases Summary</h4>
              <div class="table-responsive">

                <table class="table table-bordered" style="text-align:center;" id="test _table">
                  <thead>
                    <tr>
                      <th style="text-align: center;">Regions</th>
                      <td style="text-align: center;">TPen</td>
                      <td>Reg</td>
                      <td>Ren.</td>
                      <td>Re.+Up</td>
                      <td>Upg</td>
                      <td>Def.</td>
                      <td>OPs</td>
                      <td>IssPen</td>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    $user_id = $this->session->userdata('userId');
                    $query = "SELECT `users`.`region_ids` FROM `users`
                            WHERE `users`.`userId` = '" . $user_id . "'";
                    $region_ids = $this->db->query($query)->row()->region_ids;
                    $query = "SELECT * FROM pending_file_status";
                    $pending_files = $this->db->query($query)->result();
                    foreach ($pending_files as $pending) { ?>
                      <tr>
                        <th style="text-align: center;"><?php echo $pending->region; ?></th>
                        <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
                        <td><?php echo $pending->registrations; ?></td>
                        <td><?php echo $pending->renewals; ?></td>
                        <td><?php echo $pending->renewal_pgradations; ?></td>
                        <td><?php echo $pending->upgradations; ?></td>
                        <td><?php echo $pending->financially_deficient; ?></td>
                        <td><?php echo $pending->marked_to_operation_wing; ?></td>
                        <td><?php echo $pending->completed_pending; ?></td>
                      </tr>
                    <?php } ?>

                  </tbody>
                  <tfoot>
                    <?php
                    $query = "SELECT sum(total_pending) as total_pending
                    , sum(registrations) as registrations
                    ,  sum(renewals) as renewals
                    , sum(renewal_pgradations) as renewal_pgradations
                    , sum(upgradations) as upgradations
                    , sum(financially_deficient) as financially_deficient
                    , sum(marked_to_operation_wing) as marked_to_operation_wing
                    , sum(completed_pending) as completed_pending
                    FROM `pending_file_status`";
                    $pending = $this->db->query($query)->row(); ?>
                    <tr>
                      <th style="text-align: right;">Total: </th>
                      <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
                      <th style="text-align: center;"><?php echo $pending->registrations; ?></th>
                      <th style="text-align: center;"><?php echo $pending->renewals; ?></th>
                      <th style="text-align: center;"><?php echo $pending->renewal_pgradations; ?></th>
                      <th style="text-align: center;"><?php echo $pending->upgradations; ?></th>
                      <th style="text-align: center;"><?php echo $pending->financially_deficient; ?></th>
                      <th style="text-align: center;"><?php echo $pending->marked_to_operation_wing; ?></th>
                      <th style="text-align: center;"><?php echo $pending->completed_pending; ?></th>
                    </tr>
                  </tfoot>
                </table>
                <table class="table table-bordered" style="text-align:center;" id="test _table">

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
                      <td>Registered</td>
                      <td>Cumulative Registered</td>
                      <td>Completed %</td>
                      <td>Renewal Remaining</td>
                    </tr>
                  </thead>

                  <tbody>

                    <?php
                    $cumulative_registered = 0;
                    $previous_registration = 0;
                    $query = "select `session_year`.`sessionYearTitle` AS `sessionYearTitle`,
                    IF(`session_year`.`sessionYearId`>5,
                    sum(if(`school`.`file_status`>=1 and school.status>0 ,1,0)), '') AS `total_applied`,
                    sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
                    sum(if(`school`.`status` = 1,1,0)) AS `total_issued`,
                    SUM(IF((`school`.`status` = 1 and `school`.`renewal_code`<=0),1,0)) as total_registered
                    from (((`school` 
                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                    group by `session_year`.`sessionYearTitle`";
                    $pending_files = $this->db->query($query)->result();
                    foreach ($pending_files as $pending) {
                      $cumulative_registered += $pending->total_registered;

                    ?>
                      <tr>
                        <th style="text-align: center;"><?php echo $pending->sessionYearTitle; ?></th>
                        <td><?php echo $pending->total_applied; ?></td>
                        <td><?php echo $pending->previous_pending; ?></td>
                        <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
                        <td><?php echo $pending->registrations; ?></td>
                        <td><?php echo $pending->renewals; ?></td>
                        <td><?php echo $pending->renewal_pgradations; ?></td>
                        <td><?php echo $pending->upgradations; ?></td>
                        <td><?php echo $pending->financially_deficient; ?></td>
                        <td><?php echo $pending->marked_to_operation_wing; ?></td>
                        <td><?php echo $pending->completed_pending; ?></td>
                        <td><?php echo $pending->total_issued; ?></td>
                        <td><?php echo $pending->total_registered; ?></td>
                        <td><?php echo $cumulative_registered; ?></td>
                        <td>
                          <?php
                          if ($previous_registration) {
                            echo round(($pending->total_issued / $previous_registration) * 100, 2) . " %";
                          } ?>
                        </td>
                        <td>
                          <?php
                          if ($previous_registration) {
                            echo ($previous_registration - $pending->total_issued);
                          } ?></td>
                      </tr>
                    <?php
                      $previous_registration += $pending->total_registered;
                    } ?>

                  </tbody>

                </table>


                <table class="table table-bordered" style="text-align:center;" id="test _table">

                  <thead>
                    <tr>
                      <th style="text-align: center;">Region</th>
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
                      <td>Registered</td>
                      <td>Cumulative Registered</td>
                      <td>Completed %</td>
                      <td>Renewal Remaining</td>
                    </tr>
                  </thead>

                  <tbody>

                    <?php
                    $cumulative_registered = 0;
                    $previous_registration = 0;
                    $query = "select   IF(district.new_region = 1, 'Central', IF(district.new_region = 2, 'South', IF(district.new_region = 3, 'Malakand', IF(district.new_region = 4, 'Hazara', IF(district.new_region = 5, 'Peshawar', 'Other') )))) AS region,
                    IF(`session_year`.`sessionYearId`>5,sum(if(`school`.`file_status`>=1 and school.status>0 ,1,0)), '') AS `total_applied`,
                    sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
                    sum(if(`school`.`status` = 1,1,0)) AS `total_issued`,
                    SUM(IF((`school`.`status` = 1 and `school`.`renewal_code`<=0),1,0)) as total_registered
                    from (((`school` 
                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                    group by `district`.`new_region`";
                    $pending_files = $this->db->query($query)->result();
                    foreach ($pending_files as $pending) {
                      $cumulative_registered += $pending->total_registered;

                    ?>
                      <tr>
                        <th style="text-align: center;"><?php echo $pending->region; ?></th>
                        <td><?php echo $pending->total_applied; ?></td>
                        <td><?php echo $pending->previous_pending; ?></td>
                        <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
                        <td><?php echo $pending->registrations; ?></td>
                        <td><?php echo $pending->renewals; ?></td>
                        <td><?php echo $pending->renewal_pgradations; ?></td>
                        <td><?php echo $pending->upgradations; ?></td>
                        <td><?php echo $pending->financially_deficient; ?></td>
                        <td><?php echo $pending->marked_to_operation_wing; ?></td>
                        <td><?php echo $pending->completed_pending; ?></td>
                        <td><?php echo $pending->total_issued; ?></td>
                        <td><?php echo $pending->total_registered; ?></td>
                        <td><?php echo $cumulative_registered; ?></td>
                        <td>
                          <?php
                          if ($previous_registration) {
                            echo round(($pending->total_issued / $previous_registration) * 100, 2) . " %";
                          } ?>
                        </td>
                        <td>
                          <?php
                          if ($previous_registration) {
                            echo ($previous_registration - $pending->total_issued);
                          } ?></td>
                      </tr>
                    <?php
                      $previous_registration += $pending->total_registered;
                    } ?>

                  </tbody>

                </table>


                <h4>Today</h4>
                <div class="row">
                  <div class="col-md-6">
                    <div class="block_div">
                      <table class="table table-bordered" style="text-align:center;" id="test _table">
                        <thead>
                          <tr>
                            <th style="text-align: center;">Session</th>
                            <th style="text-align: center;">Appl</th>
                            <td style="text-align: center;">TPen</td>
                            <td>Reg</td>
                            <td>Ren.</td>
                            <td>Re.+Up</td>
                            <td>Upg</td>
                            <td>Def.</td>
                            <td>OPs</td>
                            <td>IssPen</td>
                            <td>Issued</td>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          $apply_date = ' and DATE(apply_date) = DATE(NOW()) ';
                          $pending_date = ' and DATE(pending_date) = DATE(NOW()) ';
                          $note_sheet_completed_date = ' and DATE(note_sheet_completed_date) = DATE(NOW()) ';
                          $cer_issue_date = ' and DATE(cer_issue_date) = DATE(NOW()) ';

                          $query = "select `session_year`.`sessionYearTitle` AS `sessionYearTitle`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                                    group by `session_year`.`sessionYearTitle`";
                          $pending_files = $this->db->query($query)->result();
                          get_session_table($pending_files);
                          ?>

                        </tbody>
                        <tfoot>

                          <?php

                          $query = "select `session_year`.`sessionYearTitle` AS `sessionYearTitle`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`))";
                          $pending_files = $this->db->query($query)->result();
                          get_session_table($pending_files, 'Total');
                          ?>

                        </tfoot>

                      </table>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="block_div">
                      <table class="table table-bordered" style="text-align:center;" id="test _table">
                        <thead>
                          <tr>
                            <th style="text-align: center;">Session</th>
                            <th style="text-align: center;">Appl</th>
                            <td style="text-align: center;">TPen</td>
                            <td>Reg</td>
                            <td>Ren.</td>
                            <td>Re.+Up</td>
                            <td>Upg</td>
                            <td>Def.</td>
                            <td>OPs</td>
                            <td>IssPen</td>
                            <td>Issued</td>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          $query = "select  `district`.`new_region` AS `new_region`,if(`district`.`new_region` = 1,'Central',if(`district`.`new_region` = 2,'South',if(`district`.`new_region` = 3,'Malakand',if(`district`.`new_region` = 4,'Hazara',if(`district`.`new_region` = 5,'Peshawar','Others'))))) AS `region`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                                    group by `district`.`new_region`
                                    ";
                          $pending_files = $this->db->query($query)->result();
                          get_region_table($pending_files); ?>


                        </tbody>
                        <tfoot>

                          <?php
                          $query = "select  `district`.`new_region` AS `new_region`,if(`district`.`new_region` = 1,'Central',if(`district`.`new_region` = 2,'South',if(`district`.`new_region` = 3,'Malakand',if(`district`.`new_region` = 4,'Hazara',if(`district`.`new_region` = 5,'Peshawar','Others'))))) AS `region`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                                    ";
                          $pending_files = $this->db->query($query)->result();
                          get_region_table($pending_files, 'Total'); ?>


                        </tfoot>

                      </table>
                    </div>
                  </div>
                </div>


                <h4>Previous Day</h4>
                <div class="row">
                  <div class="col-md-6">
                    <div class="block_div">
                      <table class="table table-bordered" style="text-align:center;" id="test _table">
                        <thead>
                          <tr>
                            <th style="text-align: center;">Session</th>
                            <th style="text-align: center;">Appl</th>
                            <td style="text-align: center;">TPen</td>
                            <td>Reg</td>
                            <td>Ren.</td>
                            <td>Re.+Up</td>
                            <td>Upg</td>
                            <td>Def.</td>
                            <td>OPs</td>
                            <td>IssPen</td>
                            <td>Issued</td>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          $apply_date = ' and DATE(apply_date) = DATE(CURRENT_DATE - INTERVAL 1 DAY) ';
                          $pending_date = ' and DATE(pending_date) = DATE(CURRENT_DATE - INTERVAL 1 DAY) ';
                          $note_sheet_completed_date = ' and DATE(note_sheet_completed_date) = DATE(CURRENT_DATE - INTERVAL 1 DAY) ';
                          $cer_issue_date = ' and DATE(cer_issue_date) = DATE(CURRENT_DATE - INTERVAL 1 DAY) ';





                          $query = "select `session_year`.`sessionYearTitle` AS `sessionYearTitle`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                                    group by `session_year`.`sessionYearTitle`";
                          $pending_files = $this->db->query($query)->result();
                          get_session_table($pending_files);
                          ?>

                        </tbody>
                        <tfoot>

                          <?php

                          $query = "select `session_year`.`sessionYearTitle` AS `sessionYearTitle`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`))";
                          $pending_files = $this->db->query($query)->result();
                          get_session_table($pending_files, 'Total');
                          ?>

                        </tfoot>

                      </table>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="block_div">
                      <table class="table table-bordered" style="text-align:center;" id="test _table">
                        <thead>
                          <tr>
                            <th style="text-align: center;">Session</th>
                            <th style="text-align: center;">Appl</th>
                            <td style="text-align: center;">TPen</td>
                            <td>Reg</td>
                            <td>Ren.</td>
                            <td>Re.+Up</td>
                            <td>Upg</td>
                            <td>Def.</td>
                            <td>OPs</td>
                            <td>IssPen</td>
                            <td>Issued</td>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          $query = "select  `district`.`new_region` AS `new_region`,if(`district`.`new_region` = 1,'Central',if(`district`.`new_region` = 2,'South',if(`district`.`new_region` = 3,'Malakand',if(`district`.`new_region` = 4,'Hazara',if(`district`.`new_region` = 5,'Peshawar','Others'))))) AS `region`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                                    group by `district`.`new_region`
                                    ";
                          $pending_files = $this->db->query($query)->result();
                          get_region_table($pending_files); ?>


                        </tbody>
                        <tfoot>

                          <?php
                          $query = "select  `district`.`new_region` AS `new_region`,if(`district`.`new_region` = 1,'Central',if(`district`.`new_region` = 2,'South',if(`district`.`new_region` = 3,'Malakand',if(`district`.`new_region` = 4,'Hazara',if(`district`.`new_region` = 5,'Peshawar','Others'))))) AS `region`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                                    ";
                          $pending_files = $this->db->query($query)->result();
                          get_region_table($pending_files, 'Total'); ?>


                        </tfoot>

                      </table>
                    </div>
                  </div>
                </div>



                <h4>Current Month</h4>
                <div class="row">
                  <div class="col-md-6">
                    <div class="block_div">
                      <table class="table table-bordered" style="text-align:center;" id="test _table">
                        <thead>
                          <tr>
                            <th style="text-align: center;">Session</th>
                            <th style="text-align: center;">Appl</th>
                            <td style="text-align: center;">TPen</td>
                            <td>Reg</td>
                            <td>Ren.</td>
                            <td>Re.+Up</td>
                            <td>Upg</td>
                            <td>Def.</td>
                            <td>OPs</td>
                            <td>IssPen</td>
                            <td>Issued</td>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          $apply_date = ' AND Year(apply_date) = YEAR(CURRENT_DATE ) 
                         AND MONTH(apply_date) = MONTH(CURRENT_DATE) ';
                          $pending_date = ' AND Year(pending_date) = YEAR(CURRENT_DATE) 
                         AND MONTH(pending_date) = MONTH(CURRENT_DATE) ';
                          $note_sheet_completed_date = ' AND Year(note_sheet_completed_date) = YEAR(CURRENT_DATE) 
                         AND MONTH(note_sheet_completed_date) = MONTH(CURRENT_DATE) ';
                          $cer_issue_date = ' AND Year(cer_issue_date) = YEAR(CURRENT_DATE) 
                         AND MONTH(cer_issue_date) = MONTH(CURRENT_DATE) ';

                          $query = "select `session_year`.`sessionYearTitle` AS `sessionYearTitle`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                                    group by `session_year`.`sessionYearTitle`";
                          $pending_files = $this->db->query($query)->result();
                          get_session_table($pending_files);
                          ?>

                        </tbody>
                        <tfoot>

                          <?php

                          $query = "select `session_year`.`sessionYearTitle` AS `sessionYearTitle`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`))";
                          $pending_files = $this->db->query($query)->result();
                          get_session_table($pending_files, 'Total');
                          ?>

                        </tfoot>

                      </table>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="block_div">
                      <table class="table table-bordered" style="text-align:center;" id="test _table">
                        <thead>
                          <tr>
                            <th style="text-align: center;">Region</th>
                            <th style="text-align: center;">Appl</th>
                            <td style="text-align: center;">TPen</td>
                            <td>Reg</td>
                            <td>Ren.</td>
                            <td>Re.+Up</td>
                            <td>Upg</td>
                            <td>Def.</td>
                            <td>OPs</td>
                            <td>IssPen</td>
                            <td>Issued</td>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          $query = "select  `district`.`new_region` AS `new_region`,if(`district`.`new_region` = 1,'Central',if(`district`.`new_region` = 2,'South',if(`district`.`new_region` = 3,'Malakand',if(`district`.`new_region` = 4,'Hazara',if(`district`.`new_region` = 5,'Peshawar','Others'))))) AS `region`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                                    group by `district`.`new_region`
                                    ";
                          $pending_files = $this->db->query($query)->result();
                          get_region_table($pending_files); ?>


                        </tbody>
                        <tfoot>

                          <?php
                          $query = "select  `district`.`new_region` AS `new_region`,if(`district`.`new_region` = 1,'Central',if(`district`.`new_region` = 2,'South',if(`district`.`new_region` = 3,'Malakand',if(`district`.`new_region` = 4,'Hazara',if(`district`.`new_region` = 5,'Peshawar','Others'))))) AS `region`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                                    ";
                          $pending_files = $this->db->query($query)->result();
                          get_region_table($pending_files, 'Total'); ?>


                        </tfoot>

                      </table>
                    </div>
                  </div>
                </div>

                <h4>Previous Month</h4>
                <div class="row">
                  <div class="col-md-6">
                    <div class="block_div">
                      <table class="table table-bordered" style="text-align:center;" id="test _table">
                        <thead>
                          <tr>
                            <th style="text-align: center;">Session</th>
                            <th style="text-align: center;">Appl</th>
                            <td style="text-align: center;">TPen</td>
                            <td>Reg</td>
                            <td>Ren.</td>
                            <td>Re.+Up</td>
                            <td>Upg</td>
                            <td>Def.</td>
                            <td>OPs</td>
                            <td>IssPen</td>
                            <td>Issued</td>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          $apply_date = ' AND Year(apply_date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) 
                          AND MONTH(apply_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) ';
                          $pending_date = ' AND Year(pending_date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) 
                          AND MONTH(pending_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) ';
                          $note_sheet_completed_date = ' AND Year(note_sheet_completed_date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) 
                          AND MONTH(note_sheet_completed_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) ';
                          $cer_issue_date = ' AND Year(cer_issue_date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) 
                          AND MONTH(cer_issue_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) ';


                          $query = "select `session_year`.`sessionYearTitle` AS `sessionYearTitle`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                                    group by `session_year`.`sessionYearTitle`";
                          $pending_files = $this->db->query($query)->result();
                          get_session_table($pending_files);
                          ?>

                        </tbody>
                        <tfoot>

                          <?php

                          $query = "select `session_year`.`sessionYearTitle` AS `sessionYearTitle`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`))";
                          $pending_files = $this->db->query($query)->result();
                          get_session_table($pending_files, 'Total');
                          ?>

                        </tfoot>

                      </table>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="block_div">
                      <table class="table table-bordered" style="text-align:center;" id="test _table">
                        <thead>
                          <tr>
                            <th style="text-align: center;">Region</th>
                            <th style="text-align: center;">Appl</th>
                            <td style="text-align: center;">TPen</td>
                            <td>Reg</td>
                            <td>Ren.</td>
                            <td>Re.+Up</td>
                            <td>Upg</td>
                            <td>Def.</td>
                            <td>OPs</td>
                            <td>IssPen</td>
                            <td>Issued</td>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          $query = "select  `district`.`new_region` AS `new_region`,if(`district`.`new_region` = 1,'Central',if(`district`.`new_region` = 2,'South',if(`district`.`new_region` = 3,'Malakand',if(`district`.`new_region` = 4,'Hazara',if(`district`.`new_region` = 5,'Peshawar','Others'))))) AS `region`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                                    group by `district`.`new_region`
                                    ";
                          $pending_files = $this->db->query($query)->result();
                          get_region_table($pending_files); ?>


                        </tbody>
                        <tfoot>

                          <?php
                          $query = "select  `district`.`new_region` AS `new_region`,if(`district`.`new_region` = 1,'Central',if(`district`.`new_region` = 2,'South',if(`district`.`new_region` = 3,'Malakand',if(`district`.`new_region` = 4,'Hazara',if(`district`.`new_region` = 5,'Peshawar','Others'))))) AS `region`,
                                    sum(if(`school`.`file_status`>=1 and school.status>0 " . $apply_date . " ,1,0)) AS `total_applied`,
                                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `total_pending`,
                                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `registrations`,
                                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewals`,
                                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `renewal_pgradations`,
                                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2 " . $apply_date . ",1,0)) AS `upgradations`,
                                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2  " . $pending_date . ",1,0)) AS `financially_deficient`,
                                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2 " . $note_sheet_completed_date . ",1,0)) AS `marked_to_operation_wing`,
                                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2 " . $note_sheet_completed_date . ", 1,0)) AS `completed_pending`,
                                    sum(if(`school`.`status` = 1 " . $cer_issue_date . ",1,0)) AS `total_issued`
                                    from (((`school` 
                                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                                    ";
                          $pending_files = $this->db->query($query)->result();
                          get_region_table($pending_files, 'Total'); ?>


                        </tfoot>

                      </table>
                    </div>
                  </div>
                </div>






                <table class="table table-bordered" style="font-size: 10px;">
                  <tr>
                    <th></th>
                    <?php
                    $current_date = time(); // get the current date and time as a Unix timestamp
                    $one_month_ago = strtotime('-1 month', $current_date); // get the Unix timestamp for one month ago

                    // loop through each day from one month ago until today and output the date in a desired format
                    for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                      $date = date('d M, y', $i);
                    ?>
                      <th> <?php echo $date ?></th>
                    <?php
                    }
                    ?>
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
                  </tr>

                </table>
              </div>
            </div>
          </div>

        </div>


      </div>


    </div>

  </section>

</div>

<?php function get_session_table($pending_files, $total = NULL)
{ ?>
  <?php foreach ($pending_files as $pending) { ?>
    <tr>
      <?php if ($total) { ?>
        <th style="text-align: center;">Total</th>
      <?php } else { ?>
        <th style="text-align: center;"><?php echo $pending->sessionYearTitle; ?></th>
      <?php } ?>
      <td><?php echo $pending->total_applied; ?></td>
      <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
      <td><?php echo $pending->registrations; ?></td>
      <td><?php echo $pending->renewals; ?></td>
      <td><?php echo $pending->renewal_pgradations; ?></td>
      <td><?php echo $pending->upgradations; ?></td>
      <td><?php echo $pending->financially_deficient; ?></td>
      <td><?php echo $pending->marked_to_operation_wing; ?></td>
      <td><?php echo $pending->completed_pending; ?></td>
      <td><?php echo $pending->total_issued; ?></td>

    </tr>
  <?php } ?>
<?php } ?>

<?php function get_region_table($pending_files, $total = NULL)
{ ?>
  <?php foreach ($pending_files as $pending) { ?>
    <tr>
      <?php if ($total) { ?>
        <th style="text-align: center;">Total</th>
      <?php } else { ?>
        <th style="text-align: center;"><?php echo $pending->region; ?></th>
      <?php } ?>
      <td><?php echo $pending->total_applied; ?></td>
      <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
      <td><?php echo $pending->registrations; ?></td>
      <td><?php echo $pending->renewals; ?></td>
      <td><?php echo $pending->renewal_pgradations; ?></td>
      <td><?php echo $pending->upgradations; ?></td>
      <td><?php echo $pending->financially_deficient; ?></td>
      <td><?php echo $pending->marked_to_operation_wing; ?></td>
      <td><?php echo $pending->completed_pending; ?></td>
      <td><?php echo $pending->total_issued; ?></td>
    </tr>
  <?php } ?>
<?php } ?>