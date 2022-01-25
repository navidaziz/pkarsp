  <!-- Modal -->
  <script>
    function update_class_ages_from(schools_id, gender_id, class_id) {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("apply/update_class_ages_from"); ?>",
        data: {
          schools_id: schools_id,
          gender_id: gender_id,
          class_id: class_id
        }
      }).done(function(data) {

        $('#update_class_ages_body').html(data);
      });

      $('#update_class_ages').modal('toggle');
    }
  </script>
  <div class="modal fade" id="update_class_ages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title pull-left" id="exampleModalLongTitle">Update Class Age Data</h5>
          <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="update_class_ages_body">
          ...
        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> -->
      </div>
    </div>
  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2 style="display:inline;">
        <?php echo @ucfirst($title); ?>
      </h2>
      <small><?php echo @$description; ?></small>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active"><?php echo @ucfirst($title); ?>s</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
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
                  padding: 1px !important;
                }
              </style>

              <p>
              <h4>Section-C: Class & Age Wise Enrolment</h4>
              <h4>A. Boys Enrolment by Class:(Note: For example age 3+ means “equal to or greater than 3 but less than 4 years”, similarly for 4+ , 5+ and so on.)</h4>
              </p>
              <table class="table table-bordered">
                <tr>
                  <!-- <td>S/No</td> -->
                  <th>Classes</th>
                  <?php
                  $count = 1;
                  foreach ($ages  as $age) { ?>
                    <th style="text-align: center;"><?php echo $age->ageTitle; ?></th>
                  <?php } ?>
                  <th>Total</th>
                </tr>
                <!-- <form action="<?php echo site_url("apply/add_classes_ages") ?>" method="post">
                  <input type="hidden" name="gender_id" value="1" />
                  <tr>
                    <!-- <th><?php echo  $count++; ?></th>
                <td>

                  <select name="classId" required="required">
                    <option value="">Select Class</option>
                    <?php foreach ($classes  as $class) { ?>
                      <option value="<?php echo $class->classId ?>"><?php echo $class->classTitle; ?></option>
                    <?php } ?>
                  </select>
                </td>
                <?php

                foreach ($ages  as $age) { ?>
                  <td><input id="<?php echo $class->ageId ?>" style="width: 50px;" type="number" min="0" name="class_age[<?php echo $age->ageId ?>]" /></td>
                <?php } ?>
                <td><input class="btn btn-success btn-sm" type="submit" value="Add" />

                </td>
                </tr>
                </form> -->
                <?php

                foreach ($classes  as $class) { ?>
                  <tr>
                    <!-- <th><?php echo  $count++; ?></th> -->
                    <th><?php echo $class->classTitle ?></th>
                    <?php
                    $total_enrollment = 0;
                    foreach ($ages  as $age) { ?>
                      <td style="text-align: center;"><?php $query = "SELECT `enrolled` FROM `age_and_class` 
                                            WHERE age_id ='" . $age->ageId . "' 
                                            AND class_id ='" . $class->classId . "'
                                            AND school_id = '" . $schools_id . "'";
                                                      $query_result = $this->db->query($query)->result();
                                                      if ($query_result) {
                                                        $total_enrollment += $query_result[0]->enrolled;
                                                        echo $query_result[0]->enrolled;
                                                      }
                                                      ?></td>
                    <?php } ?>
                    <td style="text-align: center;"><?php echo $total_enrollment; ?></td>
                    <td style="text-align: center;">
                      <?php if ($total_enrollment) { ?>
                        <button type="button" class="btn btn-success btn-sm" style="padding: 1px !important;" onclick="update_class_ages_from(<?php echo $schools_id ?>, 1, <?php echo $class->classId ?>)">
                          Edit
                        </button>

                      <?php  } else { ?>
                        <button type="button" class="btn btn-danger btn-sm" style="padding: 1px !important;" onclick="update_class_ages_from(<?php echo $schools_id ?>, 1, <?php echo $class->classId ?>)">
                          Add
                        </button>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
              </table>



            </div>
          </div>
        </div>

      </div>
    </section>

  </div>