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
    <div class="row">
      <div class="col-md-6">
        <h2 style="display:inline;">
          <?php echo ucwords(strtolower($title)); ?>
        </h2>
        <br />
        <small><?php echo ucwords(strtolower($description)); ?></small>
      </div>
      <div class="col-md-6">
        <ol class="breadcrumb">
          <script>
            function load_school_dashboard(institute_type_id) {
              $('#institute_type_id').val(institute_type_id);
              get_new_requests();
              deficient_cases();
              summary_report();
            }
          </script>

          <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
          <input type="hidden" name="institute_type_id" id="institute_type_id" value="1" />

          <!-- <li><a href="#">Examples</a></li> -->
          <li class="active"><?php echo @ucfirst($title); ?></li>
        </ol>

        <table class="table table-bordered">
          <td><button onclick="load_school_dashboard(1)" id="school">Schools</button>
            <button onclick="load_school_dashboard(7)" id="academies">Academies</button>
          </td>
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








            </div>
          </div>
        </div>
        <div class="block_div" id="summary_report">
          <h5 style="text-align: center;" class="linear-background"></h5>
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
    $('#new_request').html('<h5 style="text-align: center;" class="linear-background"></h5>');
    var institute_type_id = $('#institute_type_id').val();
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('online_cases/get_new_requests'); ?>",
        data: {
          institute_type_id: institute_type_id
        }
      })
      .done(function(respose) {
        $('#new_request').html(respose);
      });
  }

  function deficient_cases() {
    $('#deficientcasesList').html('<h5 style="text-align: center;" class="linear-background"></h5>');
    var institute_type_id = $('#institute_type_id').val();
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('online_cases/deficient_cases'); ?>",
        data: {
          institute_type_id: institute_type_id
        }
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


  function summary_report() {
    $('#summary_report').html('<h5 style="text-align: center;" class="linear-background"></h5>');
    var institute_type_id = $('#institute_type_id').val();
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('online_cases/summary_report'); ?>",
        data: {
          institute_type_id: institute_type_id
        }
      })
      .done(function(respose) {
        $('#summary_report').html(respose);
      });
  }


  $(document).ready(function() {
    get_new_requests();
    deficient_cases();
    summary_report();
    //notesheet();
  });
</script>
<script>
  $(document).ready(function() {
    $('#test_table').DataTable();
  });
</script>