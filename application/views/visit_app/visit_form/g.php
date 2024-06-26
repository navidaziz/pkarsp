<style>
    .figure-caption {
        font-size: 12px;
        font-weight: bold;
    }
</style>
<div class="row">

    <div class="col-xs-12">
        <figure class="figure" style="height: 200px; margin-bottom:10px">
            <img style="height: 200px;  width:100%; border:1px solid white; border-radius:5px" src="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $input->picture_1; ?>" />
            <figcaption class="figure-caption text-right" style="margin-top: -20px; margin-right:5px"><small><i>Officals With Instititute Signboard</i></small></figcaption>
        </figure>

    </div>

    <?php if ($input->high_l == 1 and $input->high_sec_l == 0 and $input->high_lab_image != NULL and $input->high_level_lab == 'Yes') { ?>

        <div class="col-xs-12">
            <figure class="figure" style="height: 200px; margin-bottom:10px">
                <img style="height: 200px;  width:100%; border:1px solid white; border-radius:5px" src="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $input->high_lab_image; ?>" />
                <figcaption class="figure-caption text-right" style="margin-top: -20px; margin-right:5px"><small><i>High School lab Image</i></small></figcaption>
            </figure>

        </div>

    <?php } ?>

    <?php if ($input->high_sec_l == 1 and $input->physics_lab_image != NULL and $input->physics_lab == 'Yes') { ?>
        <div class="col-xs-12">
            <figure class="figure" style="height: 200px; margin-bottom:10px">
                <img style="height: 200px;  width:100%; border:1px solid white; border-radius:5px" src="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $input->physics_lab_image; ?>" />
                <figcaption class="figure-caption text-right" style="margin-top: -20px; margin-right:5px"><small><i>Higher Secodary Physics Lab Image</i></small></figcaption>
            </figure>
        </div>
    <?php }  ?>

    <?php if ($input->high_sec_l == 1  and $input->biology_lab_image != NULL and $input->biology_lab == 'Yes') { ?>

        <div class="col-xs-12">
            <figure class="figure" style="height: 200px; margin-bottom:10px">
                <img style="height: 200px;  width:100%; border:1px solid white; border-radius:5px" src="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $input->biology_lab_image; ?>" />
                <figcaption class="figure-caption text-right" style="margin-top: -20px; margin-right:5px"><small><i>Higher Secodary Biology Lab Image</i></small></figcaption>
            </figure>
        </div>

    <?php } ?>

    <?php if ($input->high_sec_l == 1 and $input->chemistry_lab_image != NULL and $input->chemistry_lab == 'Yes') { ?>
        <div class="col-xs-12">
            <figure class="figure" style="height: 200px; margin-bottom:10px">
                <img style="height: 200px;  width:100%; border:1px solid white; border-radius:5px" src="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $input->chemistry_lab_image; ?>" />
                <figcaption class="figure-caption text-right" style="margin-top: -20px; margin-right:5px"><small><i>Higher Secodary Chemistry Lab Image</i></small></figcaption>
            </figure>
        </div>
    <?php } ?>

</div>
<form id="visits" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
    <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
    <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
    <?php
    $next_button = 1;
    if ($input->high_l == 1 and $input->high_sec_l == 0 and $input->high_lab_image == NULL and $input->high_level_lab == 'Yes') { ?>
        <input type="hidden" name="form" value="picture_file" />
        <div class="alert alert-danger" style="margin-top: 5px;">
            <h5><i class="fa fa-camera" aria-hidden="true" style="color: #AA4644;"></i>High School Lab Image</h5>
            Please take a picture of the High School Lab with both the assigned official and officer present. This picture will serve as evidence of the lab's existence and equipment during the visit, and it will be included in the visit report.
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="visited_by_officers" class="col-form-label"><i class="fa fa-camera" aria-hidden="true"></i> Take Lab Picture and Upload <span class="required">*</span></label>
                    </div>
                    <div class="col-xs-6">
                        <input name="high_lab_image" id="high_lab_image" type="file" accept="image/*" capture="camera" class="form-control" placeholder="Take Picture" />
                    </div>
                </div>
            </div>
            <div class="block_div" style="margin-bottom: 35px;">
                <div class="row">
                    <div id="result_response"></div>
                    <div class="col-xs-12" style="text-align: center;">
                        <button class="btn btn-small" type="submit" name="submitButton" value="same">Upload Image <i class="fa fa-upload" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>

    <?php
        $next_button = 0;
    } ?>

    <?php if ($input->high_sec_l == 1 and $input->physics_lab_image == NULL and $input->physics_lab == 'Yes') { ?>
        <input type="hidden" name="form" value="picture_file" />
        <div class="alert alert-danger" style="margin-top: 5px;">
            <h5><i class="fa fa-camera" aria-hidden="true" style="color: #AA4644;"></i> Higher Secondary School Physics Lab Image</h5>
            Please take a picture of the Higher Secondary School Physics Lab with both the assigned official and officer present. This picture will serve as evidence of the Physics lab's existence and equipment during the visit, and it will be included in the visit report.
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="physics_lab_image" class="col-form-label"><i class="fa fa-camera" aria-hidden="true"></i> Take Physics Lab Picture Upload <span class="required">*</span></label>
                    </div>
                    <div class="col-xs-6">
                        <input name="physics_lab_image" id="physics_lab_image" type="file" accept="image/*" capture="camera" class="form-control" placeholder="Take Picture" />
                    </div>
                </div>
            </div>

            <div class="block_div" style="margin-bottom: 35px;">
                <div class="row">
                    <div id="result_response"></div>
                    <div class="col-xs-12" style="text-align: center;">
                        <button class="btn btn-small" type="submit" name="submitButton" value="same">Upload Image <i class="fa fa-upload" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    <?php
        $next_button = 0;
    } ?>

    <?php if ($input->high_sec_l == 1 and $input->physics_lab_image != NULL and $input->biology_lab_image == NULL and $input->biology_lab == 'Yes') { ?>
        <input type="hidden" name="form" value="picture_file" />
        <div class="alert alert-danger" style="margin-top: 5px;">
            <h5><i class="fa fa-camera" aria-hidden="true" style="color: #AA4644;"></i> Higher Secondary School Biology Lab Image</h5>
            Please take a picture of the Higher Secondary School Biology Lab with both the assigned official and officer present. This picture will serve as evidence of the Physics lab's existence and equipment during the visit, and it will be included in the visit report.
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="biology_lab_image" class="col-form-label"><i class="fa fa-camera" aria-hidden="true"></i> Take Biology Lab Picture Upload <span class="required">*</span></label>
                    </div>
                    <div class="col-xs-6">
                        <input name="biology_lab_image" id="biology_lab_image" type="file" accept="image/*" capture="camera" class="form-control" placeholder="Take Picture" />
                    </div>
                </div>
            </div>

            <div class="block_div" style="margin-bottom: 35px;">
                <div class="row">
                    <div id="result_response"></div>
                    <div class="col-xs-12" style="text-align: center;">
                        <button class="btn btn-small" type="submit" name="submitButton" value="same">Upload Image <i class="fa fa-upload" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>

    <?php
        $next_button = 0;
    } ?>

    <?php if ($input->high_sec_l == 1 and $input->physics_lab_image != NULL and $input->biology_lab_image != NULL and $input->chemistry_lab_image == NULL and $input->chemistry_lab == 'Yes') { ?>
        <input type="hidden" name="form" value="picture_file" />
        <input type="hidden" name="form" value="picture_file" />
        <div class="alert alert-danger" style="margin-top: 5px;">
            <h5><i class="fa fa-camera" aria-hidden="true" style="color: #AA4644;"></i> Higher Secondary School Chemistry Lab Image</h5>
            Please take a picture of the Higher Secondary School Chemistry Lab with both the assigned official and officer present. This picture will serve as evidence of the Physics lab's existence and equipment during the visit, and it will be included in the visit report.
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="chemistry_lab_image" class="col-form-label"><i class="fa fa-camera" aria-hidden="true"></i> Take Chemistry Lab Picture Upload <span class="required">*</span></label>
                    </div>
                    <div class="col-xs-6">
                        <input name="chemistry_lab_image" id="chemistry_lab_image" type="file" accept="image/*" capture="camera" class="form-control" placeholder="Take Picture" />
                    </div>
                </div>
            </div>

            <div class="block_div" style="margin-bottom: 35px;">
                <div class="row">
                    <div id="result_response"></div>
                    <div class="col-xs-12" style="text-align: center;">
                        <button class="btn btn-small" type="submit" name="submitButton" value="same">Upload Image <i class="fa fa-upload" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    <?php
        $next_button = 0;
    } ?>
    <?php if ($next_button == 1) { ?>
        <input type="hidden" name="form" value="g" />

        <div class="block_div" style="margin-bottom: 35px;">
            <div class="row">
                <div id="result_response"></div>
                <div class="col-xs-4" style="text-align: center;">
                    <a class="btn btn-small" href='<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/f"); ?>'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                </div>

                <div class="col-xs-4" style="text-align: center;">
                    <button class="btn btn-small" type="submit" name="submitButton" value="same">Save (G)</button>
                </div>
                <?php if ($input->g == 1) { ?>
                    <div class="col-xs-4" style="text-align: center;">
                        <a class="btn btn-small" href='<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/h"); ?>'>Next <i class="fa fa-arrow-right" aria-hidden="true"></i></a>

                    </div>
                <?php } ?>
            </div>
        </div>


    <?php } ?>

</form>
<script>
    $('#visits').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this); // Create FormData object
        var submitButtonValue = $(document.activeElement).val();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("visit_app/add_visit_report"); ?>', // URL to submit form data
            data: formData,
            contentType: false, // Not to set any content type header
            processData: false, // Not to process data
            success: function(response) {
                // Display response
                if (response == 'success') {
                    switch (submitButtonValue) {
                        case "same":
                            location.reload();
                            break;
                        case "next":
                            location.reload();
                            break;
                        default:
                            alert("Unknown button clicked");
                    }
                } else {
                    $('#result_response').html(response);
                }
            }
        });
    });
</script>