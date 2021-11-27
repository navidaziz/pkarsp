<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> Home </li>
        <li> <a href="<?php echo site_url("student/class_and_section/"); ?>"> Classes and Sections</a> </li>
        <li><?php echo $title; ?></li>
        
       
      </ul>
      <!-- /BREADCRUMBS -->
      <div class="row"> </div>
    </div>
  </div>
</div>
<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row"> 
  <!-- MESSENGER -->
  <div class="col-md-12">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-bell"></i> <?php echo $students[0]->Class_title." (".$students[0]->section_title.")"; ?> <?php echo $title; ?></h4>
        <!--<div class="tools">
            
				<a href="#box-config" data-toggle="modal" class="config">
					<i class="fa fa-cog"></i>
				</a>
				<a href="javascript:;" class="reload">
					<i class="fa fa-refresh"></i>
				</a>
				<a href="javascript:;" class="collapse">
					<i class="fa fa-chevron-up"></i>
				</a>
				<a href="javascript:;" class="remove">
					<i class="fa fa-times"></i>
				</a>
				

			</div>--> 
      </div>
      <div class="box-body">
        <div class="table-responsive">
          
              <?php 
			  
			  $count = 1;
			  foreach($students as $student): 
			  
			  
			  if($count == 1){ ?>
				  
				  <table class="table table-bordered">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('student_class_no'); ?></th>
                <th><?php echo $this->lang->line('student_name'); ?></th>
               <?php foreach($student->tests as $test){ ?>
                <th colspan="2"><?php  echo $test->test_title ?></th>
                <?php } ?>
                <th>Total Points</th>
              </tr>
            </thead>
            <tbody>
				  
				<?php  $count++; }  ?>
              
              
              
              <tr  >
                <td><?php echo $student->student_class_no; ?></td>
                <td><?php echo $student->student_name; ?></td>
                <?php foreach($student->tests as $test){ 
				?>
               <!-- <td ><?php  echo $test->result->total_test_questions; ?></td>-->
                <td ><?php  echo $test->result->total_questions; ?></td>
                  <td style=" 
                  
                  <?php 
				  if($test->result->total_questions!=0){
				  if($test->result->total_questions<$test->result->total_test_questions){ ?>
                  background-color:yellow;
                  <?php } 
				  }else{ ?>
					   background-color:red;
					  <?php }?>
                  "
                   ><?php  echo $test->result->got_marks; ?></td>
                  
                <?php 
				
				} ?>
                <td><?php echo $student->total_points ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php echo $pagination; ?> </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>
