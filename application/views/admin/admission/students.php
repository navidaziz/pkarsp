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
          <table class="table table-bordered">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('student_class_no'); ?></th>
                <th><?php echo $this->lang->line('student_name'); ?></th>
                <th><?php echo $this->lang->line('student_father_name'); ?></th>
                <th><?php echo $this->lang->line('student_data_of_birth'); ?></th>
                <th><?php echo $this->lang->line('student_address'); ?></th>
                <th><?php echo $this->lang->line('student_admission_no'); ?></th>
                <th><?php echo $this->lang->line('student_image'); ?></th>
                <th><?php echo $this->lang->line('Class_title'); ?></th>
                <th><?php echo $this->lang->line('section_title'); ?></th>
                <th><?php echo $this->lang->line('Action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($students as $student): ?>
              <tr>
                <td><?php echo $student->student_class_no; ?></td>
                <td><?php echo $student->student_name; ?></td>
                <td><?php echo $student->student_father_name; ?></td>
                <td><?php echo $student->student_data_of_birth; ?></td>
                <td><?php echo $student->student_address; ?></td>
                <td><?php echo $student->student_admission_no; ?></td>
                <td><?php
                echo file_type(base_url("assets/uploads/".$student->student_image));
            ?></td>
                <td><?php echo $student->Class_title; ?></td>
                <td><?php echo $student->section_title; ?>
              
                <?php 
				
				 $sections = $this->student_model->getList("SECTIONS", "section_id", "section_title", $where ="");
				
				?>
                <!--<form action="<?php echo site_url("student/update_student_section") ?>" method="post">
                
                <input type="hidden" name="student_id" value="<?php echo $student->student_id ?>"   />
                 <input type="hidden" name="class_id" value="<?php echo $student->class_id ?>"   />
                  <input type="hidden" name="section_id" value="<?php echo $student->section_id ?>"   />
                    <?php
  echo form_dropdown("student_section_id", array("0"=>"Select Section")+$sections, "", "class=\"form-control\" required style=\"\" onchange=\"this.form.submit()\"");
                    ?>
              </form>-->
               
               
                
                </td>
                <td style="text-align:center">
                
                <?php if(in_array($student->student_id, $online_users)){ ?>
                <span style="color:green; text-align:center;"><strong>Online</strong></span>
                <?php }else{ ?>
              
               
               <a class="llink llink-view" href="<?php echo site_url("student/login/".$student->student_id); ?>"> Login </a>
               <?php } ?>
                </td>
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
