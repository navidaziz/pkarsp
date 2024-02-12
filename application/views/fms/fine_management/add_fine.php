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
                            <div class="col-md-3">

                                <table class="table">


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
                                            <input type="radio" name="fine_nature" value="general" /> General Fine <br />
                                            <input type="radio" name="fine_nature" value="cc" /> CC Fine

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



                                </table>

                            </div>
                            <div class="col-md-5">
                                <script>
                                    fine_type_ids = [];
                                    var total_sum = 0;

                                    function calculate_fine_total() {
                                        total_sum = 0;
                                        $('.fineAmount').prop('required', false);
                                        var checkedVals = $('.fine_type_checkbox:checkbox:checked').map(function() {
                                            return this.value;
                                        }).get();
                                        ids = checkedVals.join(",");
                                        $('#fine_type_ids').val(ids);

                                        ids = ids.split(",");
                                        // alert(ids.forEach(sumfineamount));
                                        ids.forEach(sumfineamount);
                                        //console.log(total_sum);
                                        $('#fine_amount').val(total_sum);
                                        inWords4(total_sum, 'numbertowords');


                                    }

                                    function sumfineamount(value) {
                                        // txt += value + "<br>";
                                        //console.log('#fineAmount_' + value);
                                        $('#fineAmount_' + value).prop('required', true);
                                        if (value) {
                                            if ($('#fineAmount_' + value).val() == '') {
                                                //$('#fineAmount_' + value).val(0);
                                                //total_sum += parseInt($('#fineAmount_' + value).val());
                                            } else {
                                                total_sum += parseInt($('#fineAmount_' + value).val());
                                            }
                                        } else {
                                            total_sum = 0;
                                        }
                                    }
                                </script>
                                <input type="hidden" name="fine_type_ids" id="fine_type_ids" />

                                <table class="table">
                                    <?php
                                    $query = "SELECT * FROM `fine_types`";
                                    $fine_types = $this->db->query($query)->result();
                                    foreach ($fine_types as $fine_type) { ?>
                                        <tr>
                                            <td> <input class="fine_type_checkbox" onchange="calculate_fine_total()" type="checkbox" value="<?php echo $fine_type->fine_type_id ?>" /></td>
                                            <td><?php echo $fine_type->fine_title; ?></td>
                                            <td><input class="fineAmount" onkeyup="calculate_fine_total()" type="number" name="fine_types[<?php echo $fine_type->fine_type_id ?>]" id="fineAmount_<?php echo $fine_type->fine_type_id ?>" value="<?php echo $fine_type->amount; ?>" min="<?php echo $fine_type->min_amount; ?>" max="<?php echo $fine_type->max_amount; ?>" /></td>
                                        </tr>

                                    <?php } ?>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <div style="text-transform: capitalize;  text-align:left">
                                                In Words:
                                                <strong style="color: green;" id="numbertowords"></strong>
                                            </div>

                                        </td>
                                        <td>
                                            Total: <input required onkeyup="inWords()" type="number" value="<?php echo set_value("fine_amount"); ?>" name="fine_amount" placeholder="Example 2000 etc." id="fine_amount" />
                                            <?php echo form_error("fine_amount", "<p class=\"text-danger\">", "</p>"); ?>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">

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