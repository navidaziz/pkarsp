<?php
$start_time = microtime(true);
$query = "SELECT * FROM age";
$ages = $this->db->query($query)->result();
$query = "SELECT * FROM class";
$classes = $this->db->query($query)->result();
?>
<table class="table table_small table-bordered">
    <tr>
        <th rowspan="2">Classes</th>
        <th colspan="19">Age Categories</th>
        <th colspan="3"></th>
    </tr>
    <tr>
        <?php
        $count = 1;
        foreach ($ages  as $age) { ?>
            <th><?php echo $age->ageTitle; ?></th>
        <?php } ?>
        <th>Total</th>
        <th>Non-Muslims</th>
        <th>Special Students</th>
    </tr>

    <?php

    foreach ($classes  as $class) { ?>

        <tr>
            <th style="width: 75px"><?php echo $class->classTitle ?></th>
            <?php
            $total_class_enrollment = 0;
            foreach ($ages  as $age) { ?>
                <td style="text-align: center;">
                    <?php
                    $query = "SELECT SUM(`enrolled`) as enrolled  
                    FROM `age_and_class` 
                    INNER JOIN school ON(school.schoolId = age_and_class.school_id)
                    WHERE school.session_year_id=6
                    AND age_id ='" . $age->ageId . "' 
                    AND class_id ='" . $class->classId . "'";
                    $query_result = $this->db->query($query)->result();
                    if ($query_result) {
                        $total_class_enrollment += $query_result[0]->enrolled;
                        echo $query_result[0]->enrolled;
                    }
                    ?></td>
            <?php
                $total_school_entrollment += $total_class_enrollment;
            } ?>
            <th style="text-align: center; "><?php echo $total_class_enrollment; ?></th>
            <?php $query = "SELECT SUM(`non_muslim`) as non_muslim,
                      SUM(`disabled`) as disabled FROM `school_enrolments`  
                                    WHERE session_id =  '6'
                                    AND class_id ='" . $class->classId . "'  ";
            $query_result = $this->db->query($query)->result();
            ?>
            <th style=" text-align: center;"><?php if ($query_result) {
                                                    echo $query_result[0]->non_muslim;
                                                } ?> </th>
            <th style=" text-align: center;"> <?php if ($query_result) {
                                                    echo $query_result[0]->disabled;
                                                } ?> </th>


        </tr>

    <?php } ?>
    <tr>
        <th style="text-align: right; ">Total</th>
        <?php
        $total_school_entrollment  = 0;
        foreach ($ages  as $age) { ?>
            <th style="text-align: center; "><?php
                                                $query = "SELECT SUM(`enrolled`) as enrolled  
                    FROM `age_and_class` 
                    INNER JOIN school ON(school.schoolId = age_and_class.school_id)
                    WHERE school.session_year_id=6
                    AND age_id ='" . $age->ageId . "'";
                                                $query_result = $this->db->query($query)->result();
                                                if ($query_result) {
                                                    $total_school_entrollment += $query_result[0]->enrolled;
                                                    echo $query_result[0]->enrolled;
                                                }
                                                ?></th>
        <?php } ?>


        <th style="text-align: center; "><?php echo $total_school_entrollment; ?></th>
        <?php $query = "SELECT SUM(`non_muslim`) as non_muslim, SUM(`disabled`) as disabled
                                  FROM `school_enrolments`  
                                  WHERE  school_id ='" . $school_id . "'";
        $query_result = $this->db->query($query)->result();
        ?>
        <th style="text-align: center; "><?php if ($query_result) {
                                                echo $query_result[0]->non_muslim;
                                            } ?> </th>
        <th style="text-align: center; "> <?php if ($query_result) {
                                                echo $query_result[0]->disabled;
                                            } ?> </th>
        <td></td>
    </tr>

</table>
<?php
$end_time = microtime(true); // Record the end time in seconds with microseconds

$execution_time = $end_time - $start_time; // Calculate the execution time

echo "<small>Execution Time: " . $execution_time . " seconds </small>";
?>