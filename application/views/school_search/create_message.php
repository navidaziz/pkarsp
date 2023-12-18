<div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
    <table style="width: 100%;">
        <tr>
            <td>
                <div>
                    <h4>
                        <?php echo ucwords(strtolower($school->schoolName)); ?><br />

                    </h4>
                    <h5> School ID: <?php echo $school->schools_id ?>
                        <?php if ($school->registrationNumber > 0) { ?> <span style="margin-left: 20px;"></span> REG. ID:
                            <?php echo $school->registrationNumber ?>
                        <?php } ?>
                        <span style="margin-left: 20px;"></span>
                        File No: <?php
                                    $query = "SELECT * FROM `school_file_numbers` WHERE `school_id`='$school->schools_id'";
                                    $file_numbers = $this->db->query($query)->result();
                                    $count = 1;
                                    foreach ($file_numbers as $file_number) {
                                        if ($count > 1) {
                                            echo ", ";
                                        }
                                        echo $file_number->file_number;

                                        $count++;
                                    }
                                    ?>
                        <span style="margin-left: 20px;"></span>
                        <?php $query = "SELECT isfined FROM schools WHERE schoolId = '" . $school->schools_id . "'";
                        $isfined = $this->db->query($query)->row()->isfined;
                        if ($isfined == 1) {
                            echo '<span class="alert alert-danger" style="padding:2px; padding-left:5px; padding-right:5px;"><i>';
                            echo 'School has been fined';
                            echo '</i></span>';
                        }
                        ?>

                    </h5>
                    <small><strong>Address:</strong>
                        <?php if ($school->division) {
                            echo "Region: <strong>" . $school->division . "</strong>";
                        } ?>
                        <?php if ($school->districtTitle) {
                            echo " / District: <strong>" . $school->districtTitle . "</strong>";
                        } ?>
                        <?php if ($school->tehsilTitle) {
                            echo " / Tehsil: <strong>" . $school->tehsilTitle . "</strong>";
                        } ?>

                        <?php if ($school->ucTitle) {
                            echo " / Unionconsil: <strong>" . $school->ucTitle . "</strong>";
                        } ?>
                        <?php if ($school->address) {
                            echo " Address:  <strong>" . $school->address . "</strong>";
                        } ?>
                    </small>
                </div>
            </td>
            <td style="width: 250px; vertical-align: top;">
                <strong>School Contact Details</strong>
                <ol style="margin-left: 5px;">
                    <li>Phone No: <strong><?php echo $school->phone_no; ?></strong></li>
                    <li>Mobile No: <strong><?php echo $school->mobile_no; ?></strong></li>
                    <li>Email: <strong><?php echo $school->principal_email; ?></strong></li>
                    <oul>
            </td>
            <td style="width: 250px; vertical-align: top;">
                <strong>Owner Info</strong>
                <ol style="margin-left: 5px;">
                    <!-- <li>Owner Name: <strong><?php //echo $school->userTitle; 
                                                    ?></strong></li>
                    <li>Owner CNIC: <strong><?php //echo $school->cnic; 
                                            ?></strong></li> -->
                    <li>Owner No: <strong><?php echo $school->owner_no; ?></strong></li>
                    <oul>
            </td>

        </tr>
    </table>
</div>

<div class="col-md-6">
    <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">
        <?php
        $query = "SELECT COUNT(*) as total FROM message_for_all 
              WHERE message_id IN(SELECT message_id FROM message_school WHERE school_id = '" . $school->schools_id . "')
             ORDER BY `message_id` DESC";

        $query_result = $this->db->query($query);
        $total_messages = $query_result->result()[0]->total; ?>

        <h4><i class="fa fa-envelope-o"></i> Inbox Messages
            <span class="label label-primary pull-right"><?php echo $total_messages; ?></span>
        </h4>


        <?php
        $query = "SELECT * FROM message_for_all 
                 WHERE message_id IN(SELECT message_id FROM message_school WHERE school_id = '" . $school->schools_id . "')
                ORDER BY `message_id` DESC";
        $query_result = $this->db->query($query);
        $school_messages = $query_result->result(); ?>
        <ul class="list-group">
            <?php
            foreach ($school_messages as $message) : ?>
                <li class="list-group-item">
                    <a target="_new" href="<?php echo base_url('messages/message_details/'); ?><?php echo $message->message_id; ?>">
                        <strong style="font-size: 14px;"> <?php echo $message->subject; ?></strong>
                    </a>
                    <small style="display: block; color:gray" class="pull-right">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        <?php echo date("d M, Y", strtotime($message->created_date)); ?>
                    </small>
                    <details>
                        <summary style="cursor: pointer; color: #3c8dbc;"><strong>Message Detail</strong></summary>
                        <p><?php echo $message->discription; ?></p>
                    </details>
                </li>

            <?php endforeach; ?>
        </ul>

    </div>
</div>
<div class="col-md-6">
    <div id="meesage_repose"></div>
    <script>
        $("form#send_message").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '<?php echo site_url("school_search/sent_message") ?>',
                type: 'POST',
                data: formData,
                success: function(data) {

                    console.log(data);
                    const response = JSON.parse(data);
                    $('#meesage_repose').html(data);
                    if (response.success == true) {
                        create_message(<?php echo $school->schools_id ?>);
                    } else {
                        alert('Something went wrong');
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>
    <div style="border:1px solid #CCCCCC; border-radius: 10px; min-height: 100px;">
        <form id="send_message" method="post" enctype="multipart/form-data">
            <input type="hidden" name="school_id_for_message" id="school_id_for_message" value="<?php echo $school->schools_id ?>">



            <div style="margin-left:10px; " class="well well-sm" id="selection">
                <p style="text-align:center;">
                    Message Send To : <strong><?php echo ucwords(strtolower($school->schoolName)); ?></strong>
                </p>
                <br />
                <br />
                <script>
                    function get_school_active_session() {
                        id = $('#school_id_for_message').val();

                        $.ajax({
                            type: 'POST',
                            url: "<?php echo base_url('get_info/get_school_active_session') ?>",
                            data: {
                                id: id
                            },
                            success: function(data) {
                                $('#deficiency_type').html(data)
                            }
                        });
                    }
                </script>
                <strong> Is this message is deficiency message ? </strong>
                <input onclick="get_school_active_session()" required="required" type="radio" class="is_deficiency_message" name="is_deficiency_message" value="1"> Yes
                <input onclick="$('#deficiency_type').html('')" required="required" type="radio" class="is_deficiency_message" name="is_deficiency_message" value="0"> No
                <br />

                <div id="deficiency_type" style="display:block">
                    <div> </div>
                </div>

                <div class="box-body">
                    <div class="  form-group col-sm-12">
                        <div class="">
                            <label for="subject" class="control-label">Subject</label>
                            <input type="text" required="required" placeholder="Subject" name="subject" id="subject" class="form-control">
                        </div>

                    </div>
                    <div class="  form-group col-sm-12">
                        <div class="">
                            <label for="name" class=" control-label">Type Your Message Here</label>
                            <textarea required placeholder="Type Your Message Here" name="discription" class="form-control" rows="5"></textarea>

                        </div>
                    </div>
                    <div class="  form-group col-sm-12">
                        <div class="">
                            <label for="name" class=" control-label">Attachments</label>
                            <input accept="image/*,.pdf,.doc,.docx" onclick="return check_images_number()" type="file" id="otherimages" name="otherimages[]" multiple="multiple">

                        </div>

                        <div class="form-group col-sm-12">
                            <div style="text-align: right;">
                                <button type="submit" class="btn btn-primary btn-flat">Send Message</button>
                            </div>
                        </div>
                    </div>
                </div>

        </form>
    </div>
</div>