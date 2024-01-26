<table class="table">
        <tr>
          <td>
            <h5 style="text-transform: uppercase;"><?php echo @$school->schoolName; ?> <?php if (!empty($school->ppcCode)) {
                                                                                          echo " - PPC Code" . $school->ppcCode;
                                                                                        } ?></h5>
            <h5> Apply for <strong><?php echo $school->levelofInstituteTitle ?></strong> level, <strong><?php echo @$school->regTypeTitle; ?></strong></h5>
          </td>
          <td>
            <small>
              School Id # <?php echo $school->schoolId; ?> <br />
              <?php if ($school->registrationNumber != 0) : ?>
                <?php echo "Registration # " . @$school->registrationNumber; ?><br />
              <?php endif; ?>
              Session Year: <?php echo @$school->sessionYearTitle; ?><br />
              Case: <?php echo @$school->regTypeTitle; ?><br />
              File No: <strong><?php
                                $query = "SELECT * FROM `school_file_numbers` WHERE `school_id`='$school->schoolId'";
                                $file_numbers = $this->db->query($query)->result();
                                $count = 1;
                                foreach ($file_numbers as $file_number) {
                                  if ($count > 1) {
                                    echo ", ";
                                  }
                                  echo $file_number->file_number;

                                  $count++;
                                }
                                ?></strong><br />
            </small>

          </td>
        </tr>

      </table>