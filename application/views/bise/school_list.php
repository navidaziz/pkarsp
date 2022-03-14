<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

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
      <li class="active">School List</li>
    </ol>
  </section>



  <!-- Main content -->
  <section class="content" style="padding-top: 0px !important;">

    <div class="box box-primary box-solid">


      <div class="box-body">
        <div class="row">

          <div class="col-md-12">


            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">

              <table class="table table-bordered" id="school_table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>District</th>
                    <th>School ID</th>
                    <th>School Name</th>
                    <th>Reg. No.</th>
                    <th>Level</th>
                    <th>BISE</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $count = 1;
                  ?>
                  <?php foreach ($school_list as $school) { ?>
                    <tr id="tr_<?php echo $school->school_id; ?>">
                      <td><?php echo $count++; ?></td>
                      <td><?php echo $school->districtTitle; ?></td>
                      <td><?php echo $school->schoolId; ?></td>
                      <td><?php echo $school->schoolName; ?></td>
                      <td><?php echo $school->registrationNumber; ?></td>
                      <td><?php echo $school->levelofInstituteTitle; ?></td>
                      <td><?php echo $school->bise; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>



          </div>

        </div>
      </div>


    </div>

  </section>

</div>
<script>
  $(document).ready(function() {
    var table = $('#school_table').DataTable({
      "paging": false,
      dom: 'Bfrtip',
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0
      }],
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });
  });

  table.on('order.dt search.dt', function() {
    table.column(0, {
      search: 'applied',
      order: 'applied'
    }).nodes().each(function(cell, i) {
      cell.innerHTML = i + 1;
      table.cell(cell).invalidate('dom');
    });
  }).draw();
</script>