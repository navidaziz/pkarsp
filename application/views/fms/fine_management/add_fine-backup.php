<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Add Fine</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="row">
            <div class="col-md-12" id="add_new_fine_form" style="display: n one;">
                <form class="for m-inline" onsubmit="return false;" id="add_new_fine" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="school_id" value="<?php echo $school_id ?>" />
                    <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px; background-color: white; padding:10px">
                        <h4>Fine Detail</h4>
                        <div class="row">
                            <div class="col-md-5">

                                <table class="table">

                                    <tr>
                                        <td>File Number</td>
                                        <td><input required type="text" value="<?php echo set_value("file_number"); ?>" name="file_number" placeholder="File Number" id="file_number" />
                                            <?php echo form_error("file_number", "<p class=\"text-danger\">", "</p>"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Letter Number</td>
                                        <td><input required type="text" value="<?php echo set_value("letter_no"); ?>" name="letter_no" placeholder="Letter Number" id="letter_name" />
                                            <?php echo form_error("file_number", "<p class=\"text-danger\">", "</p>"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            letter Date
                                        </td>
                                        <td>
                                            <input required type="date" value="<?php echo set_value("file_date"); ?>" name="file_date" placeholder="" id="file_date" />
                                            <?php echo form_error("file_date", "<p class=\"text-danger\">", "</p>"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>File Nature</td>
                                        <td>
                                            <input type="radio" name="fine_nature" value="general" /> General Fine
                                            <input type="radio" name="fine_nature" value="cc" /> CC Fine

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Fine Types
                                        </td>
                                        <td>
                                            <select required class="select2" id="fine_type_id" name="fine_type_id" style="width: 100%;">
                                                <option value="">Select Fine Type</option>
                                                <?php
                                                $query = "SELECT * FROM `fine_types`";
                                                $fine_types = $this->db->query($query)->result();
                                                foreach ($fine_types as $fine_type) { ?>
                                                    <option <?php if ($fine_type->fine_type_id == set_value("fine_type_id")) { ?> selected <?php } ?> value="<?php echo $fine_type->fine_type_id; ?>"><?php echo $fine_type->fine_title; ?></option>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error("fine_type_id", "<p class=\"text-danger\">", "</p>"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Channel</td>
                                        <td><?php
                                            $query = "SELECT * FROM `fine_channels`";
                                            $fine_channels = $this->db->query($query)->result();
                                            foreach ($fine_channels as $fine_channel) { ?>
                                                <input <?php if ($fine_channel->fine_channel_id == set_value("fine_channel_id")) { ?> checked <?php } ?> required type="radio" name="fine_channel_id" id="fine_channel_id" value="<?php echo $fine_channel->fine_channel_id; ?>" />
                                                <?php echo $fine_channel->fine_channel_title; ?> <br />
                                            <?php } ?>

                                            <?php echo form_error("fine_channel_id", "<p class=\"text-danger\">", "</p>"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Session
                                        </td>
                                        <td>
                                            <select required name="session_id">
                                                <option value="">Session</option>
                                                <?php $query = "SELECT * FROM `session_year` ORDER BY sessionYearId DESC";
                                                $sessions = $this->db->query($query)->result();
                                                foreach ($sessions as $session) { ?>
                                                    <option value="<?php echo $session->sessionYearId ?>"><?php echo $session->sessionYearTitle ?></option>
                                                <?php } ?>

                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Amount </td>
                                        <td>
                                            <input required onkeyup="inWords()" type="number" value="<?php echo set_value("fine_amount"); ?>" name="fine_amount" placeholder="Example 2000 etc." id="amount" />
                                            <?php echo form_error("fine_amount", "<p class=\"text-danger\">", "</p>"); ?>

                                        </td>
                                    </tr>


                                </table>
                                <div style="text-transform: capitalize;  text-align:left">

                                    <small style="color: red;"> In Words: </small> <small style="color: green;" id="number_to_words"></small>
                                </div>
                            </div>
                            <div class="col-md-7">

                                <label class="control-label" for="numberOfClassroom">Fine Detail</label>
                                <br />
                                <textarea required placeholder="Fine Detail" cols="" rows="11" name="remarks" style="width: 100%;" id="remarks"><?php echo set_value("remarks"); ?></textarea>
                                <?php echo form_error("remarks", "<p class=\"text-danger\">", "</p>"); ?>
                                <table class="table">
                                    <tr>
                                        <td>
                                            Fine File: <input type="file" name="fine_file" id="fine_file" style="display: inline;" />
                                            <?php echo form_error("fine_file", "<p class=\"text-danger\">", "</p>"); ?>

                                        </td>
                                        <td>
                                            <button onclick="add_new_fine()">Add Fine</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div id="fine_error"></div>
                                        </td>
                                    </tr>
                                </table>


                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>


<script>
    function add_new_fine() {
        var form = $('#add_new_fine')[0];
        var data = new FormData(form);
        $.ajax({
                method: "POST",
                url: "<?php echo site_url("fms/fine_management/add_fine"); ?>",
                enctype: 'multipart/form-data',
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                data: data
            })
            .done(function(response) {
                console.log(response);
                //convert json response to object
                var obj = JSON.parse(response);
                if (obj.error == true) {
                    $('#fine_error').html(obj.msg);
                } else {
                    $('#add_new_fine')[0].reset();
                    location.reload();

                }
            });
    }
</script>