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

<!-- Content Wrapper. Contains page content -->
<script>
    $(document).ready(function() {
        //skin-blue sidebar-mini
        $(".skin-blue").addClass("sidebar-collapse");
    });
</script>
<style>
    .table {
        background-color: transparent !important;
        margin: 2px;
        width: 99%;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
        background-color: transparent !important;
    }
</style>

<div class="content-wrapper">

    <section class="content" style="background-image:url(img/fairview-hospital-hero.jpg); background-repeat:no-repeat; min-height:500px;">

        <!-- Small boxes (Stat box) -->
        <div class="row">

            <style>
                .block_div {
                    border: 1px solid #9FC8E8;
                    border-radius: 10px;
                    min-height: 3px;
                    margin: 3px;
                    padding: 10px;
                    background-color: white;
                }
            </style>
            <div class="col-lg-12 col-xs-12">
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
                        <td><button onclick="search()">Search</button></td>
                        </tr>
                    </table>

                </div>
            </div>

            <script>
                function open_visit_modal() {
                    $('#modal').modal('show');
                    $('#modal_title').html("Add School In Visit List");
                    $.ajax({
                        url: '<?php echo base_url(); ?>section_access/get_visit_list_form',
                        type: 'POST',
                        data: {
                            'region': '1'
                        },
                        success: function(data) {
                            $('#modal_body').html(data);
                        }
                    });
                }

                function open_upgradation_modal() {
                    $('#modal').modal('show');
                    $('#modal_title').html("Add School In Upgradation Visit List");
                }
            </script>






            <div class="clearfix"></div>


            <!-- Main row -->
            <!-- /.row (main row) -->

        </div>


    </section>
</div>

<script>
    // Get the input field
    var input = document.getElementById("search");

    // Execute a function when the user presses a key on the keyboard
    input.addEventListener("keypress", function(event) {
        // If the user presses the "Enter" key on the keyboard
        if (event.key === "Enter") {

            search();
        }
    });

    function search() {
        var search = $('#search').val();
        var district_id = $('#district_id').val();
        var district_name = $('#district_id :selected').text();
        var search_by = $('input[name="search_type"]:checked').val();

        $.ajax({
                method: "POST",
                url: "<?php echo site_url('section_access/school_detail'); ?>",
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
</script>