<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>


<style>
    .table2>tbody>tr>td,
    .table2>tbody>tr>th,
    .table2>tfoot>tr>td,
    .table2>tfoot>tr>th,
    .table2>thead>tr>td,
    .table2>thead>tr>th {
        padding: 2px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }
</style>

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


            <div class="col-lg-12 col-xs-12 ">
                <div class="table-responsive" id="table_body_list">

                </div>
            </div>
            <script>
                function open_visit_modal() {
                    $('#modal').modal('show');
                    $('#modal_title').html("Add School In Visit List");
                    $.ajax({
                        url: '<?php echo base_url(); ?>record_room/get_visit_list_form',
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
    get_bank_challan_list();

    function get_bank_challan_list() {
        $.ajax({
                method: "POST",
                url: "<?php echo site_url('note_sheet/cases'); ?>",
                data: {},
            })
            .done(function(respose) {

                $('#table_body_list').html(respose);
            });
    }

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
                url: "<?php echo site_url('bank_challan_entry/school_detail'); ?>",
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
                // $('#modal').modal('show');
                // $('#modal_title').html("School Case Details");
                $('#search_result').html(respose);
                $('[data-index="' + (0).toString() + '"]').focus();
            });
    }
</script>