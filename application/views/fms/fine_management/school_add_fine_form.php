<div class="modal-body">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add Fine</h4>
    </div>
    <div id="message" style="display: none;"></div>
    <form class="form-horizontal" action="#" id="add_fine" method="post">
        <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px; padding:20px; background-color: white;">

            <div class="row">
                <h4>School Detail</h4>
                <div class="col-md-4">
                    <label class="control-label" for="School_id">School Id</label>
                    <input type="number" value="" name="school_id" placeholder="School Id" class="form-control" id="school_id" />

                </div>
                <div class="col-md-4">
                    <label class="control-label" for="School_id">School Registration No</label>
                    <input type="number" value="" name="school_registration_no" placeholder="School Registration No" class="form-control" id="school_registration_no" />

                </div>
                <div class="col-md-4">
                    <label class="control-label" for="School_id">School Name</label>
                    <input required type="text" value="" name="school_name" placeholder="School Name" class="form-control" id="school_name" />

                </div>
                <div class="col-md-4">
                    <label class="control-label" for="School_id">District Name</label>
                    <input required type="text" value="" name="district_name" placeholder="District Name" class="form-control" id="district_name" />

                </div>
                <div class="col-md-4">
                    <label class="control-label" for="School_id">Tehsil Name</label>
                    <input required type="text" value="" name="tehsil_name" placeholder="Teshil Name" class="form-control" id="tehsil_name" />

                </div>

                <div class="col-md-4">
                    <label class="control-label" for="School_id">Address</label>
                    <input required type="text" value="" name="address" placeholder="Address" class="form-control" id="address" />

                </div>

                <h4>Fine Detail</h4>
                <div class="col-md-3">
                    <label class="control-label" for="School_id">Letter / File Number</label>
                    <input required type="text" value="" name="file_number" placeholder="Address" class="form-control" id="file_number" />

                </div>



                <div class="col-md-3">
                    <label class="control-label" for="gender">Fine Category:</label>
                    <select class="form-control select2" id="fine_category" name="fine_category" style="width: 100%;">
                        <option value="">Select Fine Type</option>
                        <?php
                        $query = "SELECT * FROM `fine_types`";
                        $fine_types = $this->db->query($query)->result();
                        foreach ($fine_types as $fine_type) { ?>
                            <option value="<?php echo $fine_type->fine_type_id; ?>"><?php echo $fine_type->fine_title; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="control-label" for="numberOfClassroom">Amount:</label>
                    <input onkeyup="inWords()" type="number" value="" name="amount" placeholder="Example 2000 etc." class="form-control" id="amount" />
                    <div style="text-transform: capitalize;  text-align:left">
                        <small style="color: red;"> In Words: </small> <small style="color: green;" id="number_to_words"></small>
                    </div>
                </div>




                <div class="col-md-3">
                    <label class="control-label" for="File Date">Date</label>
                    <input type="date" value="" name="file_date" placeholder="" class="form-control" id="file_date" />

                </div>

            </div>
            <div class="row">



                <div class="col-md-12">
                    <label class="control-label" for="numberOfClassroom">Fine Detail</label>
                    <textarea class="form-control" placeholder="Fine Detail" cols="" rows="5" name="remarks" id="remarks"></textarea>
                </div>

                <div class="col-sm-12" style="text-align: center;">
                    <input class="btn btn-success btn-sm" style="margin-top: 10px;" type="submit" value="Add Fine" name="Add Fine">
                </div>
            </div>
        </div>
    </form>
</div>




<script>
    $(document).ready(function() {
        alert("ready");
        $("#add_fine").on("submit", function(event) {
            event.preventDefault();

            var formValues = $(this).serialize();
            $.post("<?php echo site_url(ADMIN_DIR . "fine_management/add_fine") ?>", formValues, function(data) {
                // Display the returned data in browser
                //alert(data);
                $('#message').show();
                $("#message").html(data);
                if (data == 'Fine add successfully') {
                    get_class_wise_students_list();
                    $("#addStudentForm")[0].reset();
                }

            });
        });
    });




    var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '];
    var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];



    function inWords() {

        num = $('#amount').val();
        if ((num = num.toString()).length > 9) return 'overflow';
        n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return;
        var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
        $('#number_to_words').text(str)
    }
</script>