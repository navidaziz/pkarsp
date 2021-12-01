<div class="modal-header">
    <h5 class="modal-title pull-left" id="">Change Student Class</h5>
    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <br />
</div>
<div class="modal-body">
    <form action="<?php echo site_url(ADMIN_DIR . "admission/change_student_class/") ?>" method="post" style="text-align: center;">
        <input type="hidden" name="student_id" value="<?php echo $students[0]->student_id; ?>" />

        <table class="table">
            <!-- <tr>
                            <th>Class No: </th>
                            <td><input type="hidden" name="student_class_no" value="<?php echo $students[0]->student_class_no; ?>" /></td>
                        </tr> -->
            <tr>
                <th>Admission No: </th>
                <td><?php echo $students[0]->student_admission_no; ?></td>
            </tr>
            <tr>
                <th>Student Name: </th>
                <td><?php echo $students[0]->student_name; ?></td>
            </tr>
            <tr>
                <th>Father Name: </th>
                <td><?php echo $students[0]->student_father_name; ?></td>
            </tr>


            <tr>
                <th>Admission Date:</th>
                <td><?php echo $students[0]->admission_date; ?></td>
            </tr>
            <tr>
                <th>Date Of Birth: </th>
                <td>
                    <?php echo $students[0]->student_data_of_birth; ?></td>
            </tr>



        </table>

        <div style="border:1px solid #9FC8E8;  border-radius: 10px;   padding: 10px; background-color: white;">
            <?php $query = "SELECT class_title FROM classes WHERE class_id = '" . $students[0]->class_id . "'";
            $class_name = $this->db->query($query)->result()[0]->class_title;
            ?>
            <h4>Student Currently In Class - <strong><?php echo $class_name; ?></strong></h4>
            <?php $query = "SELECT class_id, class_title FROM classes";
            $classes = $this->db->query($query)->result();
            ?>

            <h4>
                Change Student Class: <br />
                <select name="class_id">
                    <?php foreach ($classes as $class) { ?>
                        <option <?php if ($class->class_id == $students[0]->class_id) { ?> selected <?php } ?> value="<?php echo $class->class_id; ?>"><?php echo $class->class_title; ?></option>
                    <?php } ?>
                </select>
                <input class="btn btn-success btn-sm" type="submit" name="Change Class" value="Change Class" />
            </h4>
        </div>




    </form>
</div>