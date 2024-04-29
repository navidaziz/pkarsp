<div class="content-wrapper">
    <section class="content-header">
        <div class='row'>
            <div class='col-md-6'>
                <div class='clearfix'>
                    <h3 class='content-title pull-left'><?php echo $title; ?> </h3>
                </div>
                <small><?php echo @$description; ?></small>
            </div>

        </div>
    </section>

    <!-- Main content -->
    <section class="content">

        <table id="datatable" class="table  table_small table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Schools Id</th>
                    <th>School Id</th>
                    <th>Visit Reason</th>
                    <th>Primary</th>
                    <th>Middle</th>
                    <th>High</th>
                    <th>High Sec.</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <script type="text/javascript">
            $(document).ready(function() {
                document.title = "visits (Date:<?php echo date('d-m-Y h:m:s') ?>)";
                $("#datatable").DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "<?php echo base_url("visits/not_visited_list"); ?>",
                        "type": "POST"
                    },
                    "columns": [{
                            "data": null,
                            "render": function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1; // Start index from 1
                            }
                        },

                        {
                            "data": "schools_id"
                        },

                        {
                            "data": "school_id"
                        },

                        {
                            "data": "visit_reason"
                        },

                        {
                            "data": "primary_l"
                        },

                        {
                            "data": "middle_l"
                        },

                        {
                            "data": "high_l"
                        },

                        {
                            "data": "high_sec_l"
                        },

                        {
                            "data": "academy_l"
                        },
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                return 'action';
                            }
                        }

                    ],
                    "lengthMenu": [
                        [15, 25, 50, -1],
                        [15, 25, 50, "All"]
                    ],
                    "order": [
                        [0, "asc"]
                    ],
                    "searching": true,
                    "paging": true,
                    "info": true,
                    dom: "Bfrtip",

                    buttons: ["excel", "pageLength"]
                });
            });
        </script>

        <div class="table-responsive">
            <table class="table table-bordered" id="visits">
                <thead>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Schools Id</th>
                        <th>School Id</th>
                        <th>Visit Reason</th>
                        <th>Visit For Level</th>
                        <th>School Name</th>
                        <th>Visited</th>
                        <th>Visited By Officers</th>
                        <th>Visited By Officials</th>
                        <th>Visit Date</th>
                        <th>Recommendation</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $query = "SELECT * FROM visits";
                    $rows = $this->db->query($query)->result();
                    foreach ($rows as $row) { ?>
                        <tr>
                            <td><a href="<?php echo site_url(ADMIN_DIR . 'visits/delete_visits/' . $row->visit_id); ?>" onclick="return confirm('Are you sure? you want to delete the record.')">Delete</a> </td>
                            <td><?php echo $count++ ?></td>
                            <td><?php echo $row->schools_id; ?></td>
                            <td><?php echo $row->school_id; ?></td>
                            <td><?php echo $row->visit_reason; ?></td>
                            <td><?php echo $row->visit_for_level; ?></td>
                            <td><?php echo $row->school_name; ?></td>
                            <td><?php echo $row->visited; ?></td>
                            <td><?php echo $row->visited_by_officers; ?></td>
                            <td><?php echo $row->visited_by_officials; ?></td>
                            <td><?php echo $row->visit_date; ?></td>
                            <td><?php echo $row->recommendation; ?></td>
                            <td><?php echo $row->remarks; ?></td>
                            <td><button onclick="get_visit_form('<?php echo $row->visit_id; ?>')">Edit<botton>

                                        <a class="btn btn-small" href='<?php echo site_url("visits/print_visit_report/$row->visit_id/$row->schools_id/$row->school_id"); ?>'><i class="fa fa-print" aria-hidden="true"></i> Print</a>


                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div style="text-align: center;">
                <button onclick="get_visit_form('0')" class="btn btn-primary">Add Record</button>
            </div>
        </div>
        <script>
            function get_visit_form(visit_id) {
                $.ajax({
                        method: "POST",
                        url: "<?php echo site_url(ADMIN_DIR . 'visits/get_visit_form'); ?>",
                        data: {
                            visit_id: visit_id
                        },
                    })
                    .done(function(respose) {
                        $('#modal').modal('show');
                        $('#modal_title').html('Visits');
                        $('#modal_body').html(respose);
                    });
            }
        </script>


    </section>
</div>