  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <h2 style="display:inline;">
              <?php echo @ucfirst($title); ?>
          </h2>
          <small><?php echo @$description; ?></small>
          <ol class="breadcrumb">
              <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
              <!-- <li><a href="#">Examples</a></li> -->
              <li class="active"><?php echo @ucfirst($title); ?>s</li>
          </ol>
      </section>

      <!-- Main content -->
      <section class="content" style="background-image:url(img/fairview-hospital-hero.jpg); background-repeat:no-repeat; min-height:500px;" />

      <!-- Small boxes (Stat box) -->
      <div class="row">
          <legend style="font-weight: bolder;margin:20px 10px;font-size: 26px;">Registered Schools Info</legend>

          <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                  <div class="inner">
                      <h3>
                          <?php echo $registered_schools; ?>
                      </h3>
                      <p>
                          Total Registrations
                      </p>
                  </div>
                  <div class="icon">
                      <i class="fa fa-university"></i>
                  </div>
                  <a href="list_user.php" class="small-box-footer">
                      More info <i class="fa fa-arrow-circle-right"></i>
                  </a>
              </div>
          </div><!-- ./col -->
          <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-blue">
                  <div class="inner">
                      <h3>
                          <?php echo $renewed_schools; ?>
                      </h3>
                      <p>
                          Total Renewal (current session)
                      </p>
                  </div>
                  <div class="icon">
                      <i class="fa fa-university"></i>
                  </div>
                  <a href="list_user.php" class="small-box-footer">
                      More info <i class="fa fa-arrow-circle-right"></i>
                  </a>
              </div>

          </div><!-- ./col -->
          <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                  <div class="inner">
                      <h3>
                          <?php echo $primary; ?>
                      </h3>
                      <p>
                          Primary
                      </p>
                  </div>
                  <div class="icon">
                      <i class="fa fa-university"></i>
                  </div>
                  <a href="list_user.php" class="small-box-footer">
                      More info <i class="fa fa-arrow-circle-right"></i>
                  </a>
              </div>

          </div><!-- ./col -->
          <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-purple">
                  <div class="inner">
                      <h3>
                          <?php echo $middle; ?>
                      </h3>
                      <p>
                          Middle
                      </p>
                  </div>
                  <div class="icon">
                      <i class="fa fa-university"></i>
                  </div>
                  <a href="list_user.php" class="small-box-footer">
                      More info <i class="fa fa-arrow-circle-right"></i>
                  </a>
              </div>

          </div><!-- ./col -->
          <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                  <div class="inner">
                      <h3>
                          <?php echo $high; ?>
                      </h3>
                      <p>
                          High
                      </p>
                  </div>
                  <div class="icon">
                      <i class="fa fa-university"></i>
                  </div>
                  <a href="list_user.php" class="small-box-footer">
                      More info <i class="fa fa-arrow-circle-right"></i>
                  </a>
              </div>

          </div><!-- ./col -->
          <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-black">
                  <div class="inner">
                      <h3>
                          <?php echo $high_sec; ?>
                      </h3>
                      <p>
                          High Sec/Inter Collages
                      </p>
                  </div>
                  <div class="icon">
                      <i style="color:white;" class="fa fa-university"></i>
                  </div>
                  <a href="list_user.php" class="small-box-footer">
                      More info <i class="fa fa-arrow-circle-right"></i>
                  </a>
              </div>

          </div><!-- ./col -->
          <div class="clearfix"></div>


          <!-- Main row -->
          <!-- /.row (main row) -->

      </div>
      <!-- /.content-wrapper -->
      <div class="row" style="background-color: #fff;">
          <legend style="font-weight: bolder;margin: 10px;font-size: 26px;">District & Level Wise Registered Schools</legend>
          <div class="table-responsive">


              <table style="font-size: 18px;" class="table table-responsive table-hover table-bordered table-condensed table-striped">
                  <tr class="bg-danger">

                      <th>District</th>
                      <th>Primary</th>
                      <th>Middle</th>

                      <th>High</th>

                      <th>Higher Sec/Inter Collage</th>
                      <th>Total Schools</th>

                  </tr>
                  <tbody>
                      <?php $counter = 1; ?>
                      <?php $total_schools_in_district = 0; ?>
                      <?php foreach ($levelwise_registered_schools as $district) : ?>
                          <tr>
                              <td><?php echo $district->districtTitle;

                                    ?></td>
                              <td><?php echo $district->primaryschools;

                                    $total_schools_in_district += $district->primaryschools;
                                    ?></td>



                              <td><?php echo @$district->middleschools;
                                    $total_schools_in_district += $district->middleschools; ?></td>

                              <td><?php echo @$district->Highschools;
                                    $total_schools_in_district += $district->Highschools;
                                    ?></td>
                              <td><?php echo $district->inter_collages;
                                    $total_schools_in_district += $district->inter_collages;
                                    ?></td>
                              <td style="color:red;font-weight:bolder"><?php echo  $total_schools_in_district;
                                                                        $total_schools_in_district = 0;
                                                                        ?></td>

                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
          </div>
      </div>

      <div>
          <table>
              <tr>
                  <th>School</th>
                  <th>2018-19</th>
                  <th>2019-20</th>
                  <th>2020-21</th>
                  <th>2021-22</th>
              </tr>

              <?php $query = 'SELECT 
                            `schools`.`schoolId`,
                            `schools`.`registrationNumber`,
                            `schools`.`schoolName`,
                            `district`.`districtTitle`,
                            `reg_type`.`regTypeTitle`,
                            `levelofinstitute`.`levelofInstituteTitle`,
                            IF((SELECT COUNT(*) FROM school AS s WHERE s.`session_year_id`=1 AND s.status=1 AND s.schools_id = school.`schools_id`), 1, "" ) AS `a`,
                            IF((SELECT COUNT(*) FROM school AS s WHERE s.`session_year_id`=2 AND s.status=1 AND s.schools_id = school.`schools_id`), 1, "" ) AS `b`,
                            IF((SELECT COUNT(*) FROM school AS s WHERE s.`session_year_id`=3 AND s.status=1 AND s.schools_id = school.`schools_id`), 1, "" ) AS `c`,
                            IF((SELECT COUNT(*) FROM school AS s WHERE s.`session_year_id`=4 AND s.status=1 AND s.schools_id = school.`schools_id`), 1, "" ) AS `d`
                            FROM
                            `schools`,
                            `school`,
                            `district`,
                            `levelofinstitute`,
                            `reg_type` 
                            WHERE `schools`.`schoolId` = `school`.`schools_id` 
                            AND `district`.`districtId` = `schools`.`district_id` 
                            AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id` 
                            AND `reg_type`.`regTypeId` = `school`.`reg_type_id` 
                            AND schools.`district_id`=13
                            AND schools.`registrationNumber`>0
                            GROUP BY schools.`schoolId`';
                $schools = $this->db->query($query)->result();
                foreach ($schools as $school) { ?>
                  <tr>
                      <td><?php echo $school->schoolName; ?></td>
                      <td><?php echo $school->a; ?></td>
                      <td><?php
                            if ($school->a != 1) {
                                echo $school->b;
                            } ?></td>
                      <td><?php
                            if ($school->a != 1 and $school->b != 1) {
                                echo $school->c;
                            } ?></td>
                      <td><?php
                            if ($school->a != 1 and $school->b != 1 and $school->c != 1) {
                                echo $school->d;
                            } ?></td>

                  </tr>
              <?php  }
                ?>
          </table>
      </div>
      </section>
  </div>
  </div>