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

            <div class="col-md-12" style="padding-left:1px">

              <div class="block_div">
                <script>
                  function search_list() {
                    var search = $('#search_list').val();
                    var district_id = $('#district_id').val();
                    $.ajax({
                        method: "POST",
                        url: "<?php echo site_url('search/search_detail'); ?>",
                        data: {
                          search: search,
                          district_id: district_id,
                          district_name: district_name
                        },
                      })
                      .done(function(respose) {
                        $('#search_result').html(respose);
                      });
                  }
                </script>

                <table class="table">
                  <tr>
                    <td><strong>Search School By School Name or Registration Number. </strong></td>
                    <td>
                      <select class="form-control" name="district_id" id="district_id">
                        <option value="0">All Districts</option>
                        <?php $query = "SELECT * FROM district ORDER BY districtTitle ASC";
                        $districts = $this->db->query($query)->result();
                        foreach ($districts as $district) {
                        ?>
                          <option value="<?php echo $district->districtId; ?>"><?php echo $district->districtTitle; ?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <td><input type="text" id="search_list" name="search_list" value="" class="form-control" /></td>
                    <td><button onclick="search_list()">Search</button></td>
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
          url: "<?php echo site_url('mis_dashboard/school_summary'); ?>",
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
  </script>