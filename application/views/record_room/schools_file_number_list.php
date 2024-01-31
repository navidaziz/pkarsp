<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>


<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
        padding: 0px;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        line-height: 1;
        vertical-align: top;
        border-top: 1px solid #ddd;
        background-color: transparent !important;
    }
</style>
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

<div class="content-wrapper">

    <section class="content" style="background-image:url(img/fairview-hospital-hero.jpg); background-repeat:no-repeat; min-height:500px;">
        <div class="row">
            <div class="col-md-12">
                <h4>Schools File Number List</h4>
                <table class="table table-bordered table_small" id="missing_file_number">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>School ID</th>
                            <th>File No.</th>
                            <th>Registration</th>
                            <th>School Name</th>
                            <th>District Name</th>
                            <th>Registered</th>
                            <th>Last Renewal</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $userId = $this->session->userdata('userId');
                        $query = "SELECT region_ids FROM users WHERE userId = '" . $userId . "'";
                        $region_ids = $this->db->query($query)->row()->region_ids;
                        $count = 1;
                        $query = "SELECT s.schoolId, s.schoolName, s.registrationNumber,
                        s.rr_note,
                         `district`.`districtTitle`, 
                         f.file_number,
                        (SELECT sy.sessionYearTitle as sessionYearTitle
                        FROM school
                        INNER JOIN session_year AS sy ON (sy.sessionYearId = school.session_year_id)
                        WHERE school.schools_id = s.schoolId AND school.status = 1
                        AND school.renewal_code <=0 
                        ORDER BY school.schoolId DESC LIMIT 1) as registration,
                        (SELECT sy.sessionYearTitle as sessionYearTitle
                        FROM school
                        INNER JOIN session_year AS sy ON (sy.sessionYearId = school.session_year_id)
                        WHERE school.schools_id = s.schoolId AND school.status = 1
                        AND school.renewal_code >0 
                        ORDER BY school.schoolId DESC LIMIT 1) as last_renewal
                        FROM school_file_numbers as f 
                        INNER JOIN schools as s ON(s.schoolId = f.school_id)
                        INNER JOIN district ON(s.district_id = district.districtId)
                        WHERE  district.new_region IN(" . $region_ids . ") ";
                        $files = $this->db->query($query)->result();
                        foreach ($files as $file) { ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $file->schoolId; ?></td>
                                <td><?php echo $file->file_number; ?></td>
                                <td><?php echo $file->registrationNumber; ?></td>
                                <td><?php echo $file->schoolName; ?></td>
                                <td><?php echo $file->districtTitle; ?></td>
                                <td><?php echo $file->registration; ?></td>
                                <td><?php echo $file->last_renewal; ?></td>
                                <td><?php echo $file->rr_note; ?></td>
                                <td>
                                    <button onclick="get_document_update_form('<?php echo $file->schoolId ?>')" class="btn btn-link btn-sm "> Update </button>

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>


    </section>
</div>

<script>
    function get_document_update_form(schools_id) {
        $.ajax({
                method: "POST",
                url: "<?php echo site_url('record_room/school_detail'); ?>",
                data: {
                    schools_id: schools_id
                },
            })
            .done(function(respose) {
                $('#modal').modal('show');
                $('#modal_title').html("Update Documents Status");
                $('#modal_body').html(respose);
            });
    }
</script>

<script>
    $(document).ready(function() {
        let table = $('#missing_file_number').DataTable({
            "columnDefs": [{
                "targets": 0,
                "orderable": false
            }],
            dom: 'Bfrtip',
            paging: false,
            title: 'Schools File Number List',
            "order": [],
            searching: true,
            buttons: [{
                    extend: 'print',
                    title: 'Schools File Number List',
                },
                {
                    extend: 'excelHtml5',
                    title: 'Schools File Number List',
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Schools File Number List',
                    pageSize: 'A4',
                }
            ]
        });

        table.on('order.dt search.dt', function() {
            let i = 1;

            table
                .cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                })
                .every(function(cell) {
                    this.data(i++);
                });
        }).draw();
    });
</script>