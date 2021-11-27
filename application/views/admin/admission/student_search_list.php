<h5>Search Results: <?php echo count($students_list) ?>
  <?php
  if (count($students_list) <= 1) {
    echo "Record";
  } else {
    echo "Records";
  }
  ?>
  found.</h5>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Student ID</th>
      <th>Admission No.</th>
      <th>Student Name</th>
      <th>Father Name</th>
      <th>Date Of Birth</th>
      <th>Admission Date</th>
      <th>Class</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($students_list as $student) : ?>
      <tr>
        <td><?php echo $student->student_id; ?></td>
        <td><?php echo $student->student_admission_no; ?></td>
        <td><?php echo $student->student_name; ?></td>
        <td><?php echo $student->student_father_name; ?></td>
        <td><?php echo $student->student_data_of_birth; ?></td>
        <td><?php echo $student->admission_date; ?></td>
        <td><?php echo $student->class_title; ?></td>
        <td><?php //echo $student->status;
            if ($student->status == 1) {
              echo "Admit";
            }
            if ($student->status == 2) {
              echo "Struck Off";
            }

            if ($student->status == 3) {
              echo "SLC";
            }

            ?></td>
        <td><a href="<?php echo site_url(ADMIN_DIR . "admission/view_student_profile/" . $student->student_id) ?>">View</a></td>

        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>