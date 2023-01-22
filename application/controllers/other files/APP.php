<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class APP extends MY_Controller {

    public $title;
    public $description;
    public $short_description;
    public $date; 
    
    public function updateNotifyKey(){
    if ($this->input->post()) {
      $this->db->where(array('userId'=>$this->input->post('user_id')));
      $this->db->update("users", array('firebaseAppKey'=>$this->input->post('firebaseAppKey')));
    //   print_r($this->db->last_query());exit();
      $affectedRows = $this->db->affected_rows();
      if ($affectedRows) {
        $response["success"] = "200";
        $response["message"] = "update successfully";
        echo json_encode($response);
      } else {
        $response["success"] = "201";
        $response["message"] = "already exist same key";
        echo json_encode($response);
      }
    }else{
      $response["success"] = "401";
      $response["message"] = "Access denied. Invalid access method";
      echo json_encode($response);
    }
   }
   
   public function testNotification(){
        $json['title']=  "This is the Title";  
        $json['description']= "Here will be the descriptoin of notification"; 
        $json['date']= date('d M Y g:i A',time());  
        $json['image_url']= "a995a284a5b7e131c716db04de3346e4.jpg,a995a284a5b7e131c716db04de3346e4.jpg";  
        $json['pdf_url']= "Etea.pdf,Etea.pdf";  
        $json['doc_url']= "kpktext-e-book proposal.docx,kpktext-e-book proposal.docx";  
        echo $response = $this->send("dcT0tufWTtmN7cIi8qZ2Gp:APA91bFGjckFgVpZGgvIYPFZCvv0BIYb8Ffy5HvZqc5bw-omsZMJA7GnAxP0JoV5ZDkiNIq3uSYfKejkfnlcpBuX7EZmn1s1QyIkr2h5633crEHbqBiLEuhuFZufFTh5A7sjo6ErN_ti", $json);
   }
   public function send($to, $message) {
        $fields = array(
            'to' => $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }

    private function sendPushNotification($fields) {
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


    //Firebase notification setting
   
    public function login()
    {
      if ($this->input->post()) {
      $username = $this->input->post('appus_username');
      $password = $this->input->post('appus_password'); 
      $query_login= "SELECT * FROM users where userName = '$username' AND userPassword = '$password'";
      $query = $this->db->query($query_login); $response["userData"]=array();
     if(!$query){
         $response['message']='error in sql query';
         $response['success']='201';
     }       
     else{
      if ($query->num_rows() > 0){
       $result =  $query->result_array();         
       foreach ($result as $row_show) { 
         if ($row_show['userStatus'] != '1'){
            $response["success"] = "204";
            $response["message"] = "your account is Bloked temporarly, contact admin"; // through sms API in signup time
         } 
         // check the status of users whethre it is block or not
         elseif ($row_show['role_id'] !='15') {
           $response["success"] = "401";
           $response["message"] = "Access denied. you'r not Authorized Person";
         }
         // return the app users data 
         else{ 
           $data['user_id']            = $row_show['userId']; 
           $data['role_id']            = $row_show['role_id']; 
           $data['userTitle']          = $row_show['userTitle']; 
           $data['userName']      = $row_show['userName']; 
           $data['userEmail']           = $row_show['userEmail'];
           $data['gender']         = $row_show['gender']; 
           $data['contactNumber']       = $row_show['contactNumber'];   
           $data['district_id']          = $row_show['district_id'];           
           $data['createdDate']          = $row_show['createdDate'];           
           array_push($response["userData"], $data);
           $response["success"] = 200;
         }           
      }
              

      }else{
        $response["success"] = 0;
        $response["message"] = "Username or password incorrect"; 
      } 
     }     
      

    }else{
       $response["success"] = 0;
       $response["message"] = "Acces denied, invaid request";  
    }echo json_encode($response);
}
    
}