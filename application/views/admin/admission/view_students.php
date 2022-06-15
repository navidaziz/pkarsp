<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" />
<style>
  .table>thead>tr>th,
  .table>tbody>tr>th,
  .table>tfoot>tr>th,
  .table>thead>tr>td,
  .table>tbody>tr>td,
  .table>tfoot>tr>td {
    padding: 5px;
  }

  .required:after {
    content: " *";
    color: red;

  }

  .dt-button {
    float: right;
  }

  .dataTables_wrapper .dataTables_filter {
    /* float: right; */
    text-align: right;
    float: left;
    margin-bottom: 2px;
  }
</style>


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h2 style="display:inline;">
      <?php echo ucwords(strtolower($school->schoolName)); ?>
    </h2><br />
    <small> <?php echo $class_title . ""; ?> Students list</a></small>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
      <li><a href="<?php echo site_url("admin/admission"); ?>">Admission</a></li>
      <li><a href=""><?php echo $class_title . ""; ?> Students list</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content ">

    <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">
      <h4>
        Add New Student in Class <?php echo $class_title . ""; ?>
        <i class="fa fa-plus pull-right" onclick="get_student_add_form()" style="margin-right: 10px;" aria-hidden="true"></i>
      </h4>



    </div>


    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive text-nowrap" id="student_list"></div>

      </div>







    </div>


</div>
</section>
</div>

<div id="general_model" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="general_model_body">


    </div>
  </div>
</div>


<script>
  function get_student_add_form() {
    $.ajax({
      type: "POST",
      url: "<?php echo site_url(ADMIN_DIR . "admission/get_student_add_form"); ?>",
      data: {
        class_title: '<?php echo $class_title ?>',
        class_id: '<?php echo $class_id ?>'
      }
    }).done(function(data) {

      $('#general_model_body').html(data);
    });

    $('#general_model').modal('show');
  }

  function update_profile(student_id) {
    $.ajax({
      type: "POST",
      url: "<?php echo site_url(ADMIN_DIR . "admission/get_student_add_form"); ?>",
      data: {
        student_id: student_id,
        class_title: '<?php echo $class_title ?>',
        class_id: '<?php echo $class_id ?>'
      }
    }).done(function(data) {

      $('#general_model_body').html(data);
    });

    $('#general_model').modal('show');
  }


  function get_class_wise_students_list() {
    $.ajax({
        method: "POST",
        url: "<?php echo site_url(ADMIN_DIR . 'admission/get_class_wise_students_list/' . $class_id); ?>",
        data: {
          class_title: '<?php echo $class_title; ?>'

        }
      })
      .done(function(respose) {
        $('#student_list').html(respose);
      });
  }
  $(document).ready(function() {
    get_class_wise_students_list();
  });
</script>






<link href="<?php echo site_url(); ?>/assets/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" />