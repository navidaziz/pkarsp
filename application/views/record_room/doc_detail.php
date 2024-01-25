<script>
    function save_file_number(school_id) {
        file_no = $('#file_no').val();
        // alert(school_id);
        $.ajax({
            url: "<?php echo base_url(); ?>record_room/save_file_number",
            type: "POST",
            data: {
                school_id: school_id,
                file_no: file_no,
            },
            success: function(data) {
                if (data == 'success') {
                    search();
                } else {
                    console.log(data);
                    alert('Something went wrong');
                }
            }
        });
    }
</script>



<div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
    <h4> <i class="fa fa-info-circle" aria-hidden="true"></i>
        Institute Detail
    </h4>

    <h4>Institute ID: <?php echo $school->schools_id ?></h4>
    <h4>Institute Name: <?php echo $school->schoolName ?></h4>
    <small> District: <?php echo $school->districtTitle ?> Address: <?php echo $school->address ?></small>




    <form method="post" action="<?php echo base_url(); ?>record_room/save_file_number">
        <input type="hidden" value="<?php echo $school->schools_id; ?>" name="school_id" />
        <table class="table table-bordered">
            <tr>
                <th>Update File No:</th>
                <td>
                    <?php
                    $query = "SELECT * FROM `school_file_numbers` WHERE `school_id`='$school->schools_id'";
                    $file_numbers = $this->db->query($query)->result();
                    $fileNumber = "";
                    foreach ($file_numbers as $file_number) {

                        $fileNumber .= $file_number->file_number . ",";
                    }
                    ?>
                    <input class="form-control" required type="text" name="file_no" id="file_no" value="<?php echo rtrim($fileNumber, ',') ?>" />
                </td>
            </tr>
            <tr>
                <th>Are the documents complete?</th>
                <td>
                    <ol>
                        <li>
                            <small>Copy of the Owner or Owners' CNIC</small>
                        </li>
                        <li><small>Ownership Documents or Affidavit</small></li>
                        <li>
                            <small>Teachers Appoinments Letters</small>
                        </li>
                        <li>
                            <small>Institute Building Map</small>
                        </li>

                        <li> <small> Rent Agreement (if it applies) </small></li>
                    </ol>

                    <input <?php if ($school->docs == 0) { ?> checked <?php } ?> required type="radio" value="0" name="docs" /> <strong> No</strong>
                    <span style="margin: 10px;"></span>
                    <input <?php if ($school->docs == 1) { ?> checked <?php } ?> required type="radio" value="1" name="docs" /> <strong> Yes</strong>

                </td>

            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" class="btn btn-success" value="Update" name="update" />
                </td>
            </tr>

        </table>
    </form>


</div>