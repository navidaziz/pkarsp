<?php if ($school) { ?>
    <div class="alert alert-success" role="alert" style="display: none;">

        <h4 class="alert-heading">Instititute ID: <?php echo $school->schools_id; ?>
            <button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close">
                <span style="color: inherit;" aria-hidden="true">&times;</span>
            </button>
        </h4>
        <h4>
            <?php if ($school->registrationNumber > 0) { ?> REG. No:
                <?php echo $school->registrationNumber ?>
            <?php } else {
                echo '<span style="color:#721c24">Not Registered Yet!</span>';
            } ?>
        </h4>
        <h4><?php echo $school->schoolName; ?></h4>
        <small style="color: inherit;">

            <?php if ($school->division) {
                echo "Region: <strong style='color: inherit;' >" . $school->division . "</strong>";
            } else {
                echo "Region: Null";
            } ?>
            <?php if ($school->districtTitle) {
                echo " , District: <strong style='color: inherit;' >" . $school->districtTitle . "</strong>";
            } else {
                echo "District: Null";
            } ?>
            <?php if ($school->tehsilTitle) {
                echo " , Tehsil: <strong style='color: inherit;' >" . $school->tehsilTitle . "</strong>";
            } else {
                echo " , Tehsil: Null";
            } ?>

            <?php if ($school->ucTitle) {
                echo " , Unionconsil: <strong style='color: inherit;' >" . $school->ucTitle . "</strong>";
            } else {
                echo " , Unionconsil: Null";
            } ?>

            <?php if ($school->address) {
                echo " , Address:  <strong style='color: inherit;' >" . $school->address . "</strong>";
            } else {
                echo " Address: Null";
            } ?>
        </small>
        <hr>
        <p class="mb-0" style="text-align: center;">
            <a href="<?php echo site_url('visits/school_detail/' . $school->schools_id) ?>" class="btn btn-success">View Instititute Detail</a>
        </p>


    </div>
<?php } else { ?>
    <div class="alert alert-danger" role="alert" style="display: none;">
        <h4 class="alert-heading">Apologies!</h4>

        <p style="color: inherit;">The institute you're searching for was not found. Please try again with a different <strong style="color: black;">Institute ID</strong>.</p>
        <hr>
        <p class="mb-0"></p>
    </div>
<?php } ?>