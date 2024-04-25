<form id="visits" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
    <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-4">
                <div class="form-group">
                    <label for="visited_by_officers" class="col-form-label">Visited By Officers</label>
                </div>
            </div>
            <div class="col-xs-8">
                <input type="text" required id="visited_by_officers" name="visited_by_officers" value="<?php echo $input->visited_by_officers; ?>" class="form-control">
            </div>
        </div>
        <div class="col-xs-12">
            <div class="col-xs-4">
                <div class="form-group">
                    <label for="visited_by_officials" class="col-form-label">Visited By Officials</label>
                </div>
            </div>
            <div class="col-xs-8">
                <input type="text" required id="visited_by_officials" name="visited_by_officials" value="<?php echo $input->visited_by_officials; ?>" class="form-control">
            </div>
        </div>
        <div class="col-xs-12">
            <div class="col-xs-4">
                <div class="form-group">
                    <label for="visit_date" class="col-form-label">Visit Date</label>
                </div>
            </div>
            <div class="col-xs-8">
                <input type="date" required id="visit_date" name="visit_date" value="<?php echo $input->visit_date; ?>" class="form-control">
            </div>
        </div>
        <div class="col-xs-12">
            <div class="col-xs-12">
                <div class="form-group">
                    <label for="recommendation" class="col-form-label">Recommendation</label>
                </div>
            </div>
            <div class="col-xs-12">
                <?php
                $options = array("Recommended", "Not Recommended");
                foreach ($options as $option) {
                    $checked = "";
                    if ($option == $input->timing) {
                        $checked = "checked";
                    }

                ?>
                    <span style="margin-left:5px"></span>
                    <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="recommendation" value="<?php echo $option; ?>" class="">
                    <span style="margin-left:3px"></span> <?php echo $option;  ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="remarks" class="col-form-label">Remarks</label>
        <textarea required id="remarks" name="remarks" class="form-control"><?php echo $input->remarks; ?></textarea>

    </div>
    <div class="form-group row">
        <label for="remarks" class="col-form-label">Do you have any other suggestions for changes?</label>
        <textarea required id="any_changes" name="any_changes" class="form-control"><?php echo $input->any_changes; ?></textarea>

    </div>
    </div>
    </div>














    <div class="form-group row" style="text-align:center">
        <div id="result_response"></div>
        <?php if ($input->visit_id == 0) { ?>
            <button type="submit" class="btn btn-primary">Add Visit Report</button>
        <?php } else { ?>
            <button type="submit" class="btn btn-primary">Update Visit Report</button>
        <?php } ?>
    </div>
</form>


<script>
    $('#visits').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("visits/add_visit"); ?>', // URL to submit form data
            data: formData,
            success: function(response) {
                // Display response
                if (response == 'success') {
                    location.reload();
                } else {
                    $('#result_response').html(response);

                }

            }
        });
    });
</script>