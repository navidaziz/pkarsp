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
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Altitude</th>
                        <th>Precision</th>
                        <th>Non Teaching Male Staffs</th>
                        <th>Non Teaching Female Staffs</th>
                        <th>Teaching Male Staffs</th>
                        <th>Teaching Female Staffs</th>
                        <th>Total Class Rooms</th>
                        <th>Male Staff Rooms</th>
                        <th>Female Staff Rooms</th>
                        <th>Principal Office</th>
                        <th>Account Office</th>
                        <th>Reception Waiting Area</th>
                        <th>Male Washrooms</th>
                        <th>Female Washrooms</th>
                        <th>High Level Lab</th>
                        <th>High Level Lab Equipment</th>
                        <th>Physics Lab</th>
                        <th>Physics Lab Equipment</th>
                        <th>Biology Lab</th>
                        <th>Biology Lab Equipment</th>
                        <th>Chemistry Lab</th>
                        <th>Chemistry Lab Equipment</th>
                        <th>Computer Lab</th>
                        <th>Total Working Computers</th>
                        <th>Total Non Working Computers</th>
                        <th>Library</th>
                        <th>Library Books</th>
                        <th>Avg Class Rooms Size</th>
                        <th>Total Male Students</th>
                        <th>Total Female Students</th>
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
                            <td><?php echo $row->latitude; ?></td>
                            <td><?php echo $row->longitude; ?></td>
                            <td><?php echo $row->altitude; ?></td>
                            <td><?php echo $row->precision; ?></td>
                            <td><?php echo $row->non_teaching_male_staffs; ?></td>
                            <td><?php echo $row->non_teaching_female_staffs; ?></td>
                            <td><?php echo $row->teaching_male_staffs; ?></td>
                            <td><?php echo $row->teaching_female_staffs; ?></td>
                            <td><?php echo $row->total_class_rooms; ?></td>
                            <td><?php echo $row->male_staff_rooms; ?></td>
                            <td><?php echo $row->female_staff_rooms; ?></td>
                            <td><?php echo $row->principal_office; ?></td>
                            <td><?php echo $row->account_office; ?></td>
                            <td><?php echo $row->reception_waiting_area; ?></td>
                            <td><?php echo $row->male_washrooms; ?></td>
                            <td><?php echo $row->female_washrooms; ?></td>
                            <td><?php echo $row->high_level_lab; ?></td>
                            <td><?php echo $row->high_level_lab_equipment; ?></td>
                            <td><?php echo $row->physics_lab; ?></td>
                            <td><?php echo $row->physics_lab_equipment; ?></td>
                            <td><?php echo $row->biology_lab; ?></td>
                            <td><?php echo $row->biology_lab_equipment; ?></td>
                            <td><?php echo $row->chemistry_lab; ?></td>
                            <td><?php echo $row->chemistry_lab_equipment; ?></td>
                            <td><?php echo $row->computer_lab; ?></td>
                            <td><?php echo $row->total_working_computers; ?></td>
                            <td><?php echo $row->total_non_working_computers; ?></td>
                            <td><?php echo $row->library; ?></td>
                            <td><?php echo $row->library_books; ?></td>
                            <td><?php echo $row->avg_class_rooms_size; ?></td>
                            <td><?php echo $row->total_male_students; ?></td>
                            <td><?php echo $row->total_female_students; ?></td>
                            <td><button onclick="get_visit_form('<?php echo $row->visit_id; ?>')">Edit<botton>
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