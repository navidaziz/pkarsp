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
      url: "<?php echo site_url("mis_dashboard/get_request_detail"); ?>",
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
      url: "<?php echo site_url("mis_dashboard/school_session_list"); ?>",
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
      <div class="box-body">


        <div class="row">
          <div class="col-md-12">
            <div id="search_result"></div>

          </div>
          <div>

          </div>

        </div>

      </div>


    </div>


</div>

</section>

</div>


<script>
  function list() {

    $.ajax({
        method: "POST",
        url: "<?php echo site_url('operation/section_e_open_list'); ?>",
        data: {},
      })
      .done(function(respose) {
        $('#search_result').html(respose);
      });
  }


  $(document).ready(function() {
    list();
  });
</script>