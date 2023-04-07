<form id="myFrmID" method="post">
    <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
    <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
    <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">

        <div class="row">

            <div class="col-md-4">
                New Registration:
            </div>
            <div class="col-md-4" style="display: none;">
                <h4>
                    New Registration Approved by ?
                </h4>
                <ul class="list-group">
                    <?php $query = "SELECT * FROM `signatories` WHERE status=1";
                    $signatories = $this->db->query($query)->result();
                    foreach ($signatories as $signatory) { ?>
                        <li class="list-group-item">
                            <input type="radio" name="signatory" value="<?php echo  $signatory->id; ?>" />
                            <strong><?php echo  $signatory->designation; ?></strong> - <?php echo $signatory->name; ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="col-md-4">
                <div style="text-align: center;">
                    <h4>Registration recomended for ?</h4>

                    <?php

                    $query = "SELECT * FROM `levelofinstitute` 
                        WHERE  school_type_id = '" . $school->school_type_id . "'
                        ORDER BY `levelofInstituteId` ASC";

                    $levels = $this->db->query($query)->result();
                    ?>

                    <table class="table">
                        <tr>
                            <th>For Session</th>
                            <th>Year of Establishment</th>
                        </tr>
                        <tr>
                            <td><select name="session_id" class="form-control">
                                    <?php
                                    $query = "SELECT * FROM session_year";
                                    $sessions = $this->db->query($query)->result();
                                    foreach ($sessions as $session) { ?>
                                        <option <?php if ($school->session_year_id == $session->sessionYearId) { ?> selected <?php } ?> value="<?php echo $session->sessionYearId ?>"><?php echo $session->sessionYearTitle ?></option>
                                    <?php }  ?>
                                </select></td>
                            <td>
                                <input text="text" name="year_of_establishment" value="<?php echo $school->yearOfEstiblishment; ?>" class="form-control" />
                            </td>
                        </tr>
                    </table>

                    <table class="table" style="text-align: center;">
                        <tr>
                            <td rowspan="2" style="vertical-align: middle;">Other Levels:</td>
                            <?php foreach ($levels as $level) { ?>
                                <th style="text-align: center;"> <?php echo $level->levelofInstituteTitle; ?></th>
                            <?php }   ?>
                        </tr>
                        <tr>
                            <?php
                            $upgradation = "";
                            foreach ($levels as $level) { ?>
                                <td>
                                    <span>

                                        <input <?php if ($level->levelofInstituteId == $school->level_of_school_id) { ?> checked <?php } ?> type="checkbox" name="levels[<?php echo $level->levelofInstituteId; ?>]" />
                                    </span>

                                </td>
                            <?php }   ?>
                        </tr>
                    </table>
                    <style>
                        .upgradation {
                            display: none;
                        }
                    </style>


                    <button id="submitButton" class="btn btn-success"> Issue <strong>Registration</strong></button>
                    <div id="Response" style="color:red;"></div>

                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#myFrmID').submit(function(e) {

            if (confirm("Are you sure?") == false) {
                return false;
            }
            var url = '<?php echo site_url('mis_dashboard/isssue_registration'); ?>';
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(data) {

                    console.log(data);
                    const response = JSON.parse(data)

                    if (response.success == true) {
                        search(response.schools_id);
                        //$('#Response').html(response.msg);
                    } else {
                        $error = '<div class="alert alert-warning" style="margin-top:5px"> <i class="fa fa-warning"></i> ' + response.msg + '</div>';
                        $('#Response').html($error);

                    }
                    // Ajax call completed successfully

                },
                error: function(data) {
                    console.log(data);
                    // Some error in ajax call
                    alert('System Error');
                }
            });
        });
    });
</script>