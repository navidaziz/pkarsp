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
        url: "<?php echo site_url("registration_section/get_request_detail"); ?>",
        data: {
          school_id: school_id,
          session_id: session_id
        }
      }).done(function(data) {

        $('#request_detail_body').html(data);
      });

      $('#request_detail').modal('toggle');
    }
  </script>
  <div class="modal fade" id="request_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 99% !important;">
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
            <div class="col-md-4" style="padding-right:1px">
              <div class="block_div" id="new_request">
                <h5 style="text-align: center;" class="linear-background"></h5>
              </div>
            </div>
            <div class="col-md-4" style="padding-left:1px; padding-right:1px">
              <div class="block_div" id="inspection_requests">
                <h5 style="text-align: center;" class="linear-background"></h5>
              </div>
            </div>
            <div class="col-md-4" style="padding-left:1px">

              <div class="block_div">
                <script>
                  function search() {
                    var search = $('#search').val();
                    var district_id = $('#district_id').val();
                    var district_name = $('#district_id :selected').text();
                    var search_by = $('input[name="search_type"]:checked').val();

                    $.ajax({
                        method: "POST",
                        url: "<?php echo site_url('search/search_detail'); ?>",
                        data: {
                          search: search,
                          district_id: district_id,
                          district_name: district_name,
                          search_by: search_by
                        },
                      })
                      .done(function(respose) {
                        $('#search_result').html(respose);
                      });
                  }
                </script>

                <table class="table">
                  <strong>Search By</strong>
                  <span style="margin-left: 15px;"></span>
                  <input type="radio" name="search_type" class="search_type" value="school_id" checked /> School ID
                  <span style="margin-left: 15px;"></span>
                  <input type="radio" name="search_type" class="search_type" value="reg_no" /> Reg. No
                  <span style="margin-left: 15px;"></span>
                  <input type="radio" name="search_type" class="search_type" value="school_name" /> School Name
                  <tr>
                    <td>
                      <select name="district_id" id="district_id">
                        <option value="0">All Districts</option>
                        <?php $query = "SELECT * FROM district ORDER BY districtTitle ASC";
                        $districts = $this->db->query($query)->result();
                        foreach ($districts as $district) {
                        ?>
                          <option value="<?php echo $district->districtId; ?>"><?php echo $district->districtTitle; ?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <td><input type="text" id="search" name="search" value="" class="form-control" /></td>
                    <td><button onclick="search()">Search</button></td>
                  </tr>
                </table>
                <div id="search_result" style="overflow-x:auto;"></div>
              </div>

              <div class="block_div" id="completed_request">
                <h5 style="text-align: center;" class="linear-background"></h5>
              </div>
            </div>
          </div>
        </div>


      </div>

    </section>

  </div>

  <script>
    function get_new_requests() {
      $.ajax({
          method: "POST",
          url: "<?php echo site_url('registration_section/get_new_requests'); ?>"
        })
        .done(function(respose) {
          $('#new_request').html(respose);
        });
    }

    function completed_requests() {
      $.ajax({
          method: "POST",
          url: "<?php echo site_url('registration_section/completed_requests'); ?>"
        })
        .done(function(respose) {
          $('#completed_request').html(respose);
        });
    }

    function inspection_requests() {
      $.ajax({
          method: "POST",
          url: "<?php echo site_url('registration_section/completed_inspection_requests'); ?>"
        })
        .done(function(respose) {
          $('#inspection_requests').html(respose);
        });
    }
    $(document).ready(function() {
      get_new_requests();
      completed_requests();
      inspection_requests();
    });
  </script>