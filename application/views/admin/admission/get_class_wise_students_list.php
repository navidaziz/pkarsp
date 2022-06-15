<table id="main_table" class="table table-bordered" style="font-size: 1 2px;">

    <thead>
        <tr>
            <th colspan="19" style="text-align: center;  ">
                <h4>Class <?php echo $class_title;  ?> Students List</h4>
            </th>
        </tr>
        <th>#</th>
        <th>Student ID</th>
        <th>Admission No</th>
        <th>Student Name</th>
        <th>Father Name</th>
        <th>Father NIC</th>
        <th>Form B</th>
        <th>Mobile No</th>
        <th>Date of Birth</th>
        <th>Admission Date</th>
        <th>Gender</th>
        <th>Disable</th>
        <th>Orphan</th>
        <th>Religion</th>
        <th>Nationality</th>
        <th>Province</th>
        <th>Domicile</th>
        <th>Address</th>
        <th>Action</th>
        </tr>
    </thead>
    <tbody id="student_list">
        <?php
        $students = array();
        $all_sections = $sections;
        foreach ($sections as $section_name => $students) {
            $count = 1;
            foreach ($students as $student) :
        ?>
                <tr>

                    <td id="count_number"><?php echo $count++; ?></td>
                    <td><span><?php echo $student->psra_student_id; ?></span></td>
                    <td><span><?php echo $student->student_admission_no; ?></span></td>
                    <td><span><?php echo $student->student_name;  ?></span></td>
                    <td><?php echo $student->student_father_name;  ?></td>
                    <td><?php echo $student->father_nic; ?></td>
                    <td><?php echo $student->form_b; ?> </td>
                    <td><?php echo $student->father_mobile_number; ?></td>
                    <td><?php echo $student->student_data_of_birth; ?> </td>
                    <td><?php echo $student->admission_date; ?></td>
                    <td><?php echo $student->gender;  ?></td>
                    <td><?php echo $student->is_disable; ?></td>
                    <td><?php echo $student->orphan; ?></td>
                    <td><?php echo $student->religion; ?></td>
                    <td><?php echo $student->nationality; ?></td>
                    <td><?php echo $student->province; ?></td>

                    <td><?php echo $student->domicile; ?></td>
                    <td><?php echo $student->student_address; ?></td>
                    <td>
                        <button onclick="update_profile('<?php echo $student->student_id; ?>')" class="btn btn-link btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> Edit</button>

                        <a href="<?php echo site_url(ADMIN_DIR . "admission/view_student_profile/" . $student->student_id) ?>">View</a>
                    </td>

                </tr>
            <?php endforeach;  ?>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        document.title = "<?php echo $students[0]->Class_title . ""; ?> Students List";

        var table = $('#main_table').DataTable({
            "bPaginate": false,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'

            ],

            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [
                [1, 'asc']
            ]
        });


        table.on('order.dt search.dt', function() {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
                table.cell(cell).invalidate('dom');
            });
        }).draw();
    });
</script>