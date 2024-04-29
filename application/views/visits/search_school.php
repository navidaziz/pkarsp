<form id="search_school" class="form-horizontal" enctype="multipart/form-data" method="post">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="visit_reason" class="col-form-label">Visit Reason</label>
                    <input class="form-control" type="text" name="schools_id" value="" />
                </div>
            </div>
            <div class="col-md-6">
                <br /> <button class="btn btn-success">Search By Instititute ID</button>
            </div>
        </div>
    </div>
    <div id="result_response"></div>

</form>
<script>
    $('#search_school').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("visits/search_school"); ?>', // URL to submit form data
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