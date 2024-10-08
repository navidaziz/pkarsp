<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Messages extends Admin_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model("general_modal");
      $this->load->model("user_m");
      $this->load->model("school_m");
   }

   public function inbox()
   {
      $user_id = $this->session->userdata('userId');
      $query = "SELECT 
					`schools`.`schoolId` AS `schools_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`district_id`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
				FROM
					`schools`
               WHERE `schools`.`owner_id`='" . $user_id . "'";
      $this->data['school'] = $this->db->query($query)->row();
      $this->data['title'] = 'Inbox Messages / Notifications';
      $this->data['description'] = 'info about Inbox Messages';
      $this->data['view'] = 'messages/inbox';
      $this->load->view('layout', $this->data);
   }
   public function school_message_details($message_id)
   {

      $message_id = (int) $message_id;

      if ($this->input->post("deficiency_completed")) {
         $school_id = (int) $this->input->post('school_id');
         $query = "UPDATE school SET file_status=1  WHERE schoolId ='" . $school_id . "' and file_status=5";

         if ($this->db->query($query)) {
            redirect('messages/school_message_details/' . $message_id);
         } else {
            redirect('messages/school_message_details/' . $message_id);
         }
      }

      if ($this->input->post("deficiency_challan")) {
         $school_id = (int) $this->input->post('school_id');
         $InserData = array(
            'school_id' => $school_id,
            'reg_type_id' => $this->input->post('reg_type_id'),
            'bt_no' => $this->input->post('challan_no'),
            'bt_date' => $this->input->post('challan_date'),
         );

         if ($this->db->insert('bank_transaction', $InserData)) {
            $this->session->set_flashdata('msg_success', 'Bank Challan Add Successfully.');
         } else {
            $this->session->set_flashdata('msg_error', "Something's wrong, Please try again.");
         }
         redirect('messages/school_message_details/' . $message_id);
      }

      $query1 = "  SELECT * FROM `message_for_all` where message_id=$message_id ";
      $query1 = $this->db->query($query1);
      $message_info = $query1->row();
      if($message_info){
      $query = "  SELECT * FROM `message_for_all_attachment` where message_id=$message_info->message_id ";
      $query = $this->db->query($query);
      $attachments = $query->result();

      $userId = $this->session->userdata('userId');
      $query="SELECT schoolId FROM schools WHERE owner_id = ?";
      $school = $this->db->query($query, [$userId])->row();
      if($school){
      $query="SELECT COUNT(*) as total FROM message_school WHERE message_id = ? and school_id = ? ";
      $school_message = $this->db->query($query,[$message_id, $school->schoolId])->row()->total;
         if($school_message>0){
            //echo "It is specific school message";
            $message_log['message_id'] = $message_id;
            $message_log['school_id'] = $school->schoolId;
            $message_log['user_id'] = $userId;
            $this->db->insert('message_read_log', $message_log);
            
         }else{
            //echo "Not school Message";
         }
      }

      $query="SELECT `users`.`userTitle`, message_read_log.read_date 
      FROM message_read_log 
      INNER JOIN `users` ON(`users`.`userId` = `message_read_log`.`user_id`)
      WHERE message_read_log.message_id = ?";
      $this->data['message_read_logs'] = $this->db->query($query, [$message_id])->result();

      $this->data['message_info'] = $message_info;
      $this->data['attachments'] = $attachments;
      //var_dump($this->data['attachments']);exit;
      $this->data['title'] = 'School Message Details';
      $this->data['description'] = 'info about Message ';
      $this->data['view'] = 'messages/school_message_details';
      $this->load->view('layout', $this->data);
   }else{
      echo 'Error in message ID';
   }
   }
   public function sent_messages()
   {

      ini_set("memory_limit", "512M");

      $limit = 25;

      $offset = $this->uri->segment(3, 0);

      $query1 = "SELECT `message_for_all`.message_id,message_for_all.subject,message_for_all.discription,message_for_all.created_date,message_for_all.select_all,schools.schoolName,message_school.school_id FROM `message_for_all`  left join message_school on message_for_all.message_id=message_school.message_id left join schools on message_school.school_id=schools.schoolId
    
  
   
    order by `message_for_all`.`message_id` DESC limit $limit offset $offset";
      $query1 = $this->db->query($query1);
      //var_dump($query1->result());exit;
      $q = $this->db->get('message_for_all');
      $number_of_rows = $q->num_rows();

      // pagination code is executed and dispaly pagination in view
      $this->load->library('pagination');
      $config = [
         'base_url' => base_url('messages/sent_messages'),
         'per_page' => 25,
         'total_rows' => $number_of_rows,
         'full_tag_open' => '<ul class="pagination pagination-sm">',
         'full_tag_close' => '</ul>',
         'first_tag_open' => '<li>',
         'first_tag_close' => '</li>',
         'last_tag_open' => '<li>',
         'last_tag_close' => '</li>',
         'next_tag_open' => '<li>',
         'next_tag_close' => '</li>',
         'prev_tag_open' => '<li>',
         'prev_tag_close' => '</li>',
         'num_tag_open' => '<li>',
         'num_tag_close' => '</li>',
         'cur_tag_open' => '<li class="active"><a>',
         'cur_tag_close' => '</a></li>',
      ];

      $this->pagination->initialize($config);
      //var_dump($query1->result());exit;

      $this->data['messages_for_all_schools'] = $query1->result();
      $this->data['title'] = 'Sent Messages';
      $this->data['description'] = 'info about Sent Messages';
      $this->data['view'] = 'messages/sent_messages';
      $this->load->view('layout', $this->data);
   }
   public function message_details($message_id)
   {
      $message_id = (int) $message_id;
      $query1 = "  SELECT * FROM `message_for_all` where message_id=$message_id ";
      $query1 = $this->db->query($query1);
      $message_info = $query1->row();
      $query = "  SELECT * FROM `message_for_all_attachment` where message_id=$message_info->message_id ";
      $query = $this->db->query($query);

      //   $query="SELECT * FROM `message_school` WHERE `message_school`.`message_id` = '".$message_info->message_id."'";
      //   $school = $this->db->query($query)->result();
      //   if($school){
      //       $this->data['school_id'] = $school->school_id;
      //   }else{
      //       $this->data['school_id'] = NULL;
      //   }

      $this->data['message_info'] = $message_info;
      //////////////////////////////////////////
      $query1 = " SELECT count(`message_school`.`message_id`) as selectedschools,
         (select * from schools where LOCATE($message_info->like_text,`schools`.`schoolName`)>0
         
            and (district_id=$message_info->district_id OR $message_info->district_id =0)
            and (schools.level_of_school_id=message_for_all.level_id OR message_for_all.level_id=0)
         

            
         ) as totalschools,`message_for_all`.*,`levelofinstitute`.`levelofInstituteTitle`,`district`.`districtTitle`,message_school.school_id
            FROM `message_for_all`
            left join levelofinstitute
            on `message_for_all`.`level_id`=`levelofinstitute`.`levelofInstituteId`
            left join district
            on `message_for_all`.`district_id`=`district`.`districtId`
            left join message_school
            on `message_for_all`.`message_id`=`message_school`.`message_id`
            group by `message_for_all`.`message_id`
            order by `message_for_all`.`message_id` DESC";
      ///////////////////////////////////////////
      $this->data['attachments'] = $query->result();

      $query="SELECT `users`.`userTitle`, message_read_log.read_date 
      FROM message_read_log 
      INNER JOIN `users` ON(`users`.`userId` = `message_read_log`.`user_id`)
      WHERE message_read_log.message_id = ?";
      $this->data['message_read_logs'] = $this->db->query($query, [$message_id])->result();

      $query = "SELECT * FROM `message_school` WHERE `message_school`.`message_id` = '" . $message_info->message_id . "'";
      $school = $this->db->query($query)->result();
      //var_dump($school);
      if ($school) {
         $this->data['school_id'] = $school[0]->school_id;
      } else {
         $this->data['school_id'] = NULL;
      }


      //var_dump($this->data['attachments']);exit;
      $this->data['title'] = 'Message Details';
      $this->data['description'] = 'info about Message ';
      $this->data['view'] = 'messages/message_details';
      $this->load->view('layout', $this->data);
   }

   public function get_messages_by_school_id()
   {
      $schools_id = $this->input->post('schools_id');

      $q = $this->db
         ->query("SELECT `message_for_all`.message_id,message_for_all.subject,message_for_all.discription,message_for_all.created_date,message_for_all.select_all,schools.schoolName,message_school.school_id FROM `message_for_all`  left join message_school on message_for_all.message_id=message_school.message_id left join schools on message_school.school_id=schools.schoolId
             where message_school.school_id=$schools_id order by `message_for_all`.`message_id` DESC");
      $messages = $q->result();
      $counter = 1;
      $arr = [];
      $html = "";
      foreach ($messages as $message) {
         $html .=
            '<tr class="bg-success">
                  <td>' .
            $counter++ .
            '</td>

                  <td class=" message"><a href="' .
            base_url('messages/message_details/' . $message->message_id) .
            '">
                    <strong style="font-size: 14px;"> <i style="font-size: 16px;" class="fa fa-star"></i> <i style="color:red;font-size: 16px;" class="fa fa-envelope-o"></i>' .
            $message->subject .
            '</strong>
                  </a> </td>
                  <td>';

         if (!empty($message->schoolName)) {
            $html .= $message->schoolName;
         }

         $html .=
            '</td>
                  <td style="font-size: 14px;text-align: left;"><i class="fa fa-clock-o" aria-hidden="true"></i>' .
            date("l , dS F Y", strtotime($message->created_date)) .
            '</td>
                 <td><a href="' .
            base_url('messages/delete/' . $message->message_id) .
            '" class="btn btn-default btn-xs" id="">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a></td>
                </tr>';
      }
      $arr['rows'] = $html;

      echo json_encode($arr);
      exit();
   }
   public function create_message()
   {
      if ($_POST) {
         // echo "<pre>";
         // print_r($_FILES);
         // exit();
         $imgString = '';
         $pdfString = '';
         $docString = '';
         date_default_timezone_set("Asia/Karachi");
         $dated = date("d-m-Y h:i:s");
         $insert['discription'] = $this->input->post('discription');
         $insert['subject'] = $this->input->post('subject');
         $insert['created_by'] = $this->session->userdata('userId');
         $insert['created_date'] = $dated;
         // echo "<pre>"; print_r($_POST);exit;
         $arr = [];

         //////////////////////////////

         $insert['district_id'] = $this->input->post('district');
         $insert['level_id'] = $this->input->post('level_of_school_id');
         $insert['like_text'] = $this->input->post('like_text');
         if ($_POST['ids']) {
            $insert['select_all'] = "no";
         } else {
            $insert['select_all'] = "yes";
         }

         $this->db->set($insert);
         $this->db->insert("message_for_all");
         $message_id = $this->db->insert_id();
         if ($this->db->affected_rows()) {
            $arr["status"] = true;

            $arr["msg"] = "Message Sent successfully";
            if (isset($_POST['ids'])) {
               $school_ids = $this->input->post('ids');
               for ($i = 0; $i < count($school_ids); $i++) {
                  $data = [
                     'message_id' => $message_id,
                     'school_id' => $school_ids[$i],
                  ];
                  $this->db->set($data);
                  $this->db->insert("message_school");
                  $id = $this->db->insert_id();
               }
            }

            $images_data = [];
            //var_dump($_FILES);exit;
            $files = $_FILES;
            if (isset($_FILES['otherimages']) && !empty($_FILES['otherimages']['name'])) {



               $cpt = count($_FILES['otherimages']['name']);

               $config = [];
               $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/notifications/' . date('Y-m-d') . "/";
               if (!file_exists($upload_dir)) {
                  mkdir($upload_dir, 0777, true);  //create directory if not exist
               }

               $this->load->library('upload', $config);
               for ($i = 0; $i < $cpt; $i++) {
                  $_FILES['otherimages[]']['name'] = $files['otherimages']['name'][$i];
                  $_FILES['otherimages[]']['type'] = $files['otherimages']['type'][$i];
                  $_FILES['otherimages[]']['tmp_name'] = $files['otherimages']['tmp_name'][$i];
                  $_FILES['otherimages[]']['error'] = $files['otherimages']['error'][$i];
                  $_FILES['otherimages[]']['size'] = $files['otherimages']['size'][$i];
                  $config['upload_path'] = $upload_dir;
                  $config['allowed_types'] = 'gif|jpeg|jpg|png|doc|docx|pdf';
                  $config['max_size'] = 0;
                  //$random = rand(1, 1000000000);
                  // $makeRandom = hash('sha512', $random . config_item("encryption_key"));
                  // $makeRandom .= "____";
                  // $makeRandom .= $files['otherimages']['name'][$i];
                  $file_name = 'PSRA-' . date('Y-m-d') . "-" . time() . "-" . $message_id;
                  $config['file_name'] = $file_name;
                  $this->upload->initialize($config);
                  if ($this->upload->do_upload("otherimages[]")) {
                     $images_data[] = $this->upload->data();
                  }
               }
               // var_dump($images_data);exit();
            }
            $num_images = count($images_data);
            //echo $num_images;exit;
            //var_dump($images_data);exit;
            if ($num_images > 0) {
               for ($i = 0; $i < $num_images; $i++) {
                  $data = [
                     'message_id' => $message_id,
                     'attachment_name' => $images_data[$i]['file_name'],
                     'folder' => 'notifications/' . date('Y-m-d'),
                  ];
                  $this->db->set($data);
                  $this->db->insert("message_for_all_attachment");
                  $id = $this->db->insert_id();
                  $file_extension = pathinfo($images_data[$i]['file_name'], PATHINFO_EXTENSION);
                  if ($file_extension == 'jpg' || $file_extension == 'png') {
                     $imgString .= $images_data[$i]['file_name'] . ",";
                  } elseif ($file_extension == 'pdf' || $file_extension == 'docx' || $file_extension == 'doc') {
                     $pdfString .= $images_data[$i]['file_name'] . ",";
                  }
               };
            }
         } else {
            $arr["status"] = false;

            $arr["msg"] = "Sorry Message Failed to Send!";
         }

         foreach ($_POST['ids'] as $id) {
            $sql = "SELECT * FROM `schools` 
           join users on users.userId = schools.owner_id
           where schoolId='" . $id . "' AND firebaseAppKey!='' ";
            $query = $this->db->query($sql);
            $data = $query->result_array();
            if ($data) {
               $json['title'] =  trim($this->input->post('subject'));
               $json['description'] = trim($this->input->post('discription'));
               $json['date'] = date('d M Y g:i A', time());
               $json['image_url'] = substr($imgString, 0, -1);
               $json['pdf_url'] = substr($pdfString, 0, -1);
               // $json['doc_url']= substr($docString, 0,-1);  
               $response = $this->send($data[0]['firebaseAppKey'], $json);
               // echo "<pre>"; print_r($json); exit();
            }
         }
         echo json_encode($arr);
         redirect('Messages/create_message');
         exit();
         ////////////////////////////////
      }
      $district_query = "SELECT
          `districtId`
          , `districtTitle`
      FROM
          `district` ORDER by districtTitle ASC;";
      $this->data['districts'] = $this->user_m->runQuery($district_query);
      $query = "  SELECT
                    
                    `schools`.`schoolId`
                    , `schools`.`schoolName`
                    , `district`.`districtTitle`
                     ,`levelofinstitute`.`levelofInstituteTitle`

                    
                FROM
                    `schools`
                    LEFT JOIN `district` 
                        ON (`schools`.`district_id` = `district`.`districtId`)
                        LEFT JOIN `levelofinstitute` 
                        ON (`schools`.`level_of_school_id` = `levelofinstitute`.`levelofInstituteId`) 
                        WHERE `schools`.`registrationNumber` > 0
                        ORDER BY `schools`.`schoolId` ASC";
      $query = $this->db->query($query);

      $this->data['schools'] = $query->result();
      // echo "<pre />";
      $this->data['level_of_institute'] = $this->general_modal->level_of_institute();
      $this->data['title'] = 'Message';
      $this->data['description'] = 'info about Message';
      $this->data['view'] = 'messages/messages';
      $this->load->view('layout', $this->data);
   }
   public function sendToTopic($to, $message)
   {
      $fields = array(
         'to' => '/topics/' . $to,
         'data' => $message,
      );
      return $this->sendPushNotification($fields);
   }

   // sending push message to multiple users by firebase registration ids
   public function sendMultiple($registration_ids, $message)
   {
      $fields = array(
         'to' => $registration_ids,
         'data' => $message,
      );

      return $this->sendPushNotification($fields);
   } // add firebased page access fucntion, xyz_post, send, sendPushNotification
   // public function SendNotification(){ 

   //     $json['title']=  trim($this->input->post('title'));  
   //     $json['description']= trim($this->input->post('description')); 
   //     $json['date']= date('d M Y g:i A',time()); 
   //     $query = $this->db->query("SELECT * FROM users where firebaseAppKey!='' ");
   //     $data = $query->result_array();  

   //     foreach($data as $row){
   //      $response = $this->send($row['firebaseAppKey'], $json);  
   //     //  echo "<pre>"; print_r($response);
   //     }

   //     redirect('Firebase/index');
   // }

   public function send($to, $message)
   {
      $fields = array(
         'to' => $to,
         'data' => $message,
      );
      return $this->sendPushNotification($fields);
   }

   private function sendPushNotification($fields)
   {
      $url = 'https://fcm.googleapis.com/fcm/send';
      $headers = array(
         'Authorization: key=' . "AAAAHJlhfTw:APA91bFDv64vZkfKeDcfY0LNJnWpEmWXC5CqzkXDqpJLHhloamRLRDAT-Chrf1kD6BpRpgdbbfzR6kvfW5S4YGQPBfBwWyfvGqR7B8MIo-RH_JLu8ujy31vkO7O8jcpH2gf-yvY6clDN",
         'Content-Type: application/json'
      );
      // Open connection
      $ch = curl_init();
      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // Disabling SSL Certificate support temporarly
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
      // Execute post
      $result = curl_exec($ch);
      if ($result === FALSE) {
         die('Curl failed: ' . curl_error($ch));
      }
      // Close connection
      curl_close($ch);
      return $result;
   }
   public function send_message_to_single_school()
   {





      $imgString = '';
      $pdfString = '';
      if ($_POST) {
         //var_dump($_POST);exit;
         date_default_timezone_set("Asia/Karachi");
         $dated = date("Y-m-d h:i:s");
         $insert['discription'] = $this->input->post('discription');
         $insert['subject'] = $this->input->post('subject');

         $insert['created_by'] = $this->session->userdata('userId');
         $insert['created_date'] = $dated;
         //var_dump($insert);exit;

         $is_deficiency_message = $this->input->post('is_deficiency_message');
         if ($is_deficiency_message) {
            $school_session_id = $this->input->post('school_session_id');
            if ($school_session_id) {
               $deficiency = array();
               $deficiency['pending_type'] = 'Deficiency';
               $deficiency['pending_date'] = date("Y-m-d");
               $deficiency['pending_reason'] = $this->input->post('deficiency_reason');
               $this->db->where('schoolId', $school_session_id);
               $this->db->update('school', $deficiency);
               $insert['school_session_id'] = $school_session_id;
            }
            $insert['message_type'] = 'Deficiency';
            $insert['message_reason'] = $this->input->post('deficiency_reason');
         } else {
            $insert['message_type'] = 'General';
            $insert['message_reason'] = $this->input->post('deficiency_reason');
         }


         $arr = [];

         //////////////////////////////

         $insert['district_id'] = 0;
         $insert['level_id'] = 0;
         $insert['like_text'] = "";

         $insert['select_all'] = "no";

         $this->db->set($insert);
         $this->db->insert("message_for_all");
         $message_id = $this->db->insert_id();
         if ($this->db->affected_rows()) {
            $arr["status"] = true;

            $arr["msg"] = "Message Sent successfully";

            $data = [
               'message_id' => $message_id,
               'school_id' => $this->input->post('school_id_for_message'),
            ];

            $school_id = $this->input->post('school_id_for_message');
            $this->db->set($data);
            $this->db->insert("message_school");
            $id = $this->db->insert_id();
            if ($id) {
               $images_data = [];

               $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/school/' . $school_id . "/";
               if (!file_exists($upload_dir)) {
                  mkdir($upload_dir, 0777, true);  //create directory if not exist
               }




               //var_dump($_FILES);exit;
               $files = $_FILES;
               if (isset($_FILES['otherimages']) && !empty($_FILES['otherimages']['name'])) {
                  $cpt = count($_FILES['otherimages']['name']);
                  //echo "hellow";exit;
                  //var_dump($_FILES['otherimages']['name']);exit;
                  $config = [];

                  $this->load->library('upload', $config);
                  for ($i = 0; $i < $cpt; $i++) {
                     $_FILES['otherimages[]']['name'] = $files['otherimages']['name'][$i];
                     $_FILES['otherimages[]']['type'] = $files['otherimages']['type'][$i];
                     $_FILES['otherimages[]']['tmp_name'] = $files['otherimages']['tmp_name'][$i];
                     $_FILES['otherimages[]']['error'] = $files['otherimages']['error'][$i];
                     $_FILES['otherimages[]']['size'] = $files['otherimages']['size'][$i];
                     $config['upload_path'] = $upload_dir;


                     $config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|pdf';
                     $config['max_size'] = 0;
                     $file_name = 'PSRA-' . date('Y-m-d') . "-" . time() . "-" . $message_id;
                     $config['file_name'] = $file_name;

                     $this->upload->initialize($config);
                     if ($this->upload->do_upload("otherimages[]")) {
                        $images_data[] = $this->upload->data();
                     }
                  }
                  //var_dump($images_data);exit();
               }
               $num_images = count($images_data);
               //echo $num_images;exit;
               //var_dump($images_data);exit;
               if ($num_images > 0) {
                  for ($i = 0; $i < $num_images; $i++) {
                     $data = [
                        'message_id' => $message_id,
                        'attachment_name' => $images_data[$i]['file_name'],
                        'folder' => 'school/' . $school_id,
                     ];
                     $this->db->set($data);
                     $this->db->insert("message_for_all_attachment");
                     $id = $this->db->insert_id();
                     $file_extension = pathinfo($images_data[$i]['file_name'], PATHINFO_EXTENSION);
                     if ($file_extension == 'jpg' || $file_extension == 'png') {
                        $imgString .= $images_data[$i]['file_name'] . ",";
                     } elseif ($file_extension == 'pdf' || $file_extension == 'docx' || $file_extension == 'doc') {
                        $pdfString .= $images_data[$i]['file_name'] . ",";
                     }
                  }
               }
            } else {
               $arr["status"] = false;

               $arr["msg"] = "Sorry Message Failed to Send!";
               $this->db->where('message_id', $message_id);
               $this->db->delete('message_for_all');
            }
         } else {
            $arr["status"] = false;

            $arr["msg"] = "Sorry Message Failed to Send!";
         }



         // foreach($_POST['ids'] as $id){ 
         $sql = "SELECT * FROM `schools` 
            join users on users.userId = schools.owner_id
            where schoolId='" . $this->input->post('school_id_for_message') . "' AND firebaseAppKey!='' ";
         $query = $this->db->query($sql);
         $data = $query->result_array();
         if ($data) {
            $json['title'] =  trim($this->input->post('subject'));
            $json['description'] = trim(strip_tags($this->input->post('discription')));
            $json['date'] = date('d M Y g:i A', time());
            $json['image_url'] = substr($imgString, 0, -1);
            $json['pdf_url'] = substr($pdfString, 0, -1);
            $response = $this->send($data[0]['firebaseAppKey'], $json);
            // echo "<pre>"; print_r($json); exit();
         }
         // } 

         echo json_encode($arr);
         exit();
         ////////////////////////////////
      }
   }

   public function send_registration_certificate_to_school()
   {
      $arr = [];
      if ($_POST) {
         $school_id = $this->input->post('school_id');
         $html =
            '<h3>We have sent you School Registration Certificate</h3>
             <h5>Please Download or Print it</h5>
             <div class="col-sm-12 bg-info">
             <form method="post" action="https://psra.gkp.pk/schoolReg/school/certificate">
             <input type="hidden" name="school_id" value="' .
            $school_id .
            '">
             
             <input type="submit" class="btn btn-primary" value="Download">
             </form>
             </div>
             


      ';

         date_default_timezone_set("Asia/Karachi");
         $dated = date("d-m-Y h:i:s");
         $insert['discription'] = $html;
         $insert['subject'] = "School Registration certificate";

         $insert['created_by'] = $this->session->userdata('userId');
         $insert['created_date'] = $dated;
         $insert['select_all'] = "no";
         //var_dump($insert);exit;

         //////////////////////////////

         $insert['district_id'] = 0;
         $insert['level_id'] = 0;
         $insert['like_text'] = "";

         $this->db->set($insert);
         $this->db->insert("message_for_all");
         $message_id = $this->db->insert_id();
         if ($this->db->affected_rows()) {
            $row = $this->db
               ->where('schoolId', $school_id)
               ->get('school')
               ->row();

            $schools_id = $row->schools_id;
            $arr["status"] = true;

            $arr["msg"] = "Message Sent successfully";

            $data = [
               'message_id' => $message_id,
               'school_id' => $schools_id,
            ];
            $this->db->set($data);
            $this->db->insert("message_school");
            $id = $this->db->insert_id();
         } else {
            $arr['status'] = false;
            $arr['msg'] = "Message sending failed! Please Try again";
         }
      } else {
         $arr['status'] = false;
         $arr['msg'] = "Message sending failed! Please Try again";
      }

      echo json_encode($arr);
      exit();
   }
   public function filter_schools_by_level_and_district()
   {
      if ($_POST) {
         $district = '0';
         $level = '0';
         $string = $this->input->post('matchString');
         $district = $this->input->post('district');
         //echo $district;exit;
         $level = $this->input->post('level');
         if ($district == '0' && $level == '0') {
            $condition = "WHERE `schools`.`schoolName` Like '%$string%' OR `schools`.`schoolId` = '$string'";
         } elseif ($district == '0') {
            $condition = "WHERE  `schools`.`level_of_school_id`= $level AND `schools`.`schoolName` Like '%$string%' OR `schools`.`schoolId` = '$string'";
         } elseif ($level == '0') {
            $condition = "WHERE  `schools`.`district_id`= $district AND `schools`.`schoolName` Like '%$string%' OR `schools`.`schoolId` = '$string'";
         } else {
            $condition = "WHERE  `schools`.`district_id`= $district AND `schools`.`level_of_school_id`= $level AND `schools`.`schoolName` Like '%$string%' OR `schools`.`schoolId` = '$string'";
         }

         $query = "  SELECT
                    
                    `schools`.`schoolId`
                    , `schools`.`schoolName`
                    , `district`.`districtTitle`
                    ,`levelofinstitute`.`levelofInstituteTitle`

                    
                FROM
                    `schools`
                    LEFT JOIN `district` 
                        ON (`schools`.`district_id` = `district`.`districtId`)
                      LEFT JOIN `levelofinstitute` 
                        ON (`schools`.`level_of_school_id` = `levelofinstitute`.`levelofInstituteId`)
                        $condition";
         $query = $this->db->query($query);
         $schools = $query->result();
         $table_data = "<tr><td>Total Schools</td><td><b style='color:red;'>" . count($schools) . "</b></td></tr>";
         foreach ($schools as $school) {
            $table_data .=
               "<tr>
                      <td><input form='myForm'  class='checkbox' type='checkbox' name='ids[]' value='" .
               $school->schoolId .
               "' ></td>
                       <td style='font-weight: bold;'>" .
               $school->schoolId .
               "</td>
                      <td style='font-weight: bold;'>" .
               $school->schoolName .
               "</td>
                      
                      <td style='font-weight: bold;'>" .
               $school->districtTitle .
               "</td>
                      <td style='font-weight: bold;'>" .
               $school->levelofInstituteTitle .
               "</td>
                    </tr>";
         }

         echo $table_data;
         exit();
      }
   }

   public function create_form()
   {
      $this->data['title'] = 'age';
      $this->data['description'] = 'info about age';
      $this->data['view'] = 'age/create';
      $this->load->view('layout', $this->data);
   }

   public function create_process($id = null)
   {
      //validation configuration
      $validation_config = [
         [
            'field' => 'ageTitle',
            'label' => 'Age Title',
            'rules' => 'trim|required',
         ],
      ];
      $post_data = $this->input->post();
      //var_dump($post_data);exit;
      // unset($posts['text_password']);
      $this->form_validation->set_rules($validation_config);
      if ($this->form_validation->run() === true) {
         if ($id == null) {
            $msg = "New Age has been created successfully";
            $type = "msg_success";
            $insert_id = $this->age_m->save($post_data);
         } else {
            $type = "msg";
            $msg = "Age has been updated successfully";
            $insert_id = $this->age_m->save($post_data, $id);
         }

         if ($insert_id) {
            $this->session->set_flashdata($type, $msg);
            redirect('age');
         } else {
            $this->session->set_flashdata('msg_error', "Something's wrong, Please try later");
            redirect('age/create_form');
         }
      } else {
         if ($id == null) {
            $this->create_form();
         } else {
            $this->session->set_flashdata('msg_error', "Something's wrong, Please try again.");
            $path = "age/edit/" . $id;
            redirect($path);
         }
      }
   }

   /**
    * edit a district
    * @param $district id integer
    */
   public function edit($id)
   {
      $id = (int) $id;
      $this->data['age'] = $this->age_m->get($id);
      $this->data['title'] = 'Age';
      $this->data['description'] = 'here you can edit and save the changes on fly.';
      $this->data['view'] = 'age/edit';
      $this->load->view('layout', $this->data);
   }

   public function delete($id)
   {
      $id = (int) $id;
      $where = ['complainTypeId' => $id];
      $result = $this->age_m->delete($where);
      if ($result) {
         $this->session->set_flashdata('msg_success', "complain Type successfully deleted.");
         redirect('complain_type');
      } else {
         $this->session->set_flashdata('msg_error', "Something's wrong, Please try later");
         redirect('complain_type');
      }
   }
}