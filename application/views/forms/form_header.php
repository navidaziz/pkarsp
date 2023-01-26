<section class="content-header">
    <h2 style="display:inline;"><?php echo ucwords(strtolower($school->schoolName)); ?>
        <small style="margin-left: 10px;"> (<?php
                                            $query = "SELECT typeTitle FROM `school_type` WHERE typeId = '" . $school->school_type_id . "'";
                                            $school_type = $this->db->query($query)->row()->typeTitle;
                                            echo $school_type; ?>)
        </small>
    </h2>
    <br />
    <small>
        <h4>Institute ID: <?php echo $school->schools_id; ?> <?php if ($school->registrationNumber) { ?> - REG No: <?php echo $school->registrationNumber ?> <?php } ?></h4>
    </small>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active"><?php echo @ucfirst($title); ?>s Session: <?php echo $session_detail->sessionYearTitle; ?></li>
    </ol>
</section>