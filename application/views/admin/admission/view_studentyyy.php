



<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> Home </li>
        <!--<li> <a href="<?php echo site_url("student/class_and_section/"); ?>"> Classes and Sections</a> </li>
         <li> <a href="<?php echo site_url("student/students_list/".$this->session->userdata('class_id')."/".$this->session->userdata('section_id')); ?>"> Students List</a> </li>-->
      <li ><?php echo $title; ?> </li>
      
       <span class="pull-right">
       
      <?php   
	  if($this->session->userdata('logged_in')){
	  ?>	
       
      <a href="<?php echo site_url("student/logout/"); ?>"> Logout  </a>
	   <?php }else{ ?> 
       
      
       
       <a href="<?php echo site_url("student/login/")."/".$students[0]->student_id; ?>"> login </a>
	   <?php } ?></span>
      </ul>
    
    
    <h3><?php echo "Welcome Dear <i style='color:red'>".$this->session->userdata('student_name')."</i>"; ?></h3>
    </div>
  </div>
</div>
<div class="row">
      <?php $this->load->view(PUBLIC_DIR."components/nav"); ?>
      <div class="col-md-3">
        <div class="table-responsive">
        <h3 class="title"><?php echo $title; ?> <span style="font-size:20px !important;"> <a class="llink llink-view pull-right" href="<?php echo site_url("student/edit_student/".$students[0]->student_id."/"); ?>"> Edit </a></span></h3>
          <table class="table">
            <thead>
            </thead>
            <tbody>
              <?php foreach($students as $student): ?>
              <tr>
                <th><?php echo $this->lang->line('student_class_no'); ?></th>
                <td><?php echo $student->student_class_no; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('student_name'); ?></th>
                <td><?php echo $student->student_name; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('student_father_name'); ?></th>
                <td><?php echo $student->student_father_name; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('student_data_of_birth'); ?></th>
                <td><?php echo $student->student_data_of_birth; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('student_address'); ?></th>
                <td><?php echo $student->student_address; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('student_admission_no'); ?></th>
                <td><?php echo $student->student_admission_no; ?></td>
              </tr>
              <tr>
                <th>Student Image</th>
                <td><?php
                    echo file_type(base_url("assets/uploads/".$student->student_image));
                ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('Class_title'); ?></th>
                <td><?php echo $student->Class_title; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('section_title'); ?></th>
                <td><?php echo $student->section_title; ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      
      <div class="col-md-9">
              <h3 class="title">Tests</h3>

      <table class="table table-bordered">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('test_type'); ?></th>
                <th><?php echo $this->lang->line('test_title'); ?></th>
                
                <th><?php echo $this->lang->line('subject_title'); ?></th>
				<th>Total Que.</th>
                <th>Attempt Que.</th>
                <th>Obtain Marks</th>
                <th><?php echo $this->lang->line('Action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($tests as $test): ?>
              <tr>
                <td><?php echo $test->test_type; ?></td>
                <td><?php echo $test->test_title; ?></td>
                <td><?php echo $test->subject_title; ?></td>
                <td><?php 
				if($test->result->total_test_questions){
				echo  $test->result->total_test_questions;
				}?></td>
                
                <td><?php 
				if($test->result->total_questions){
				echo  $test->result->total_questions;
				}?></td>
                <td><?php echo  $test->result->got_marks ?></td>
                <td>
                <?php  if($this->session->userdata('logged_in')){ ?>
                
                <?php if($test->result->total_questions){ ?>
               
                <?php if($test->result->total_questions>=$test->result->total_test_questions){ ?>
                Completed
                <?php }?>
                <?php if($test->result->total_questions<$test->result->total_test_questions){ ?>
					<a class="llink llink-view" href="<?php echo site_url("student/test/".$test->test_id."/"); ?>"> Resume </a>
					
				<?php 	} ?>
               
                <?php }else{ ?>
                 <a class="llink llink-view" href="<?php echo site_url("student/test/".$test->test_id."/"); ?>"> Start Test </a>
                <?php } ?>
                
                 
              
                <?php }else{ ?> <em><span style="font-size:9px !important;">Need Login</span></em> <?php } ?>
                
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
      
      </div>
      
      
    </div>
