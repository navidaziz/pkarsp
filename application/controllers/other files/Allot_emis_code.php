<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Allot_emis_code extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   public function index()
   {

      $query = "SELECT `schoolId`,`registrationNumber`,`schoolName` , `emis_code`
                FROM `schools` 
                WHERE `registrationNumber`>0 and emis_code ='' LIMIT 10";
      $emis_pending_schools = $this->db->query($query)->result();
      if ($emis_pending_schools) {
         foreach ($emis_pending_schools as $emis_pending_school) {

            echo $emis_pending_school->schoolId . " - " . $emis_pending_school->registrationNumber . " - " . $emis_pending_school->schoolName . '-' . $emis_pending_school->emis_code . " - ";

            $school_id = $emis_pending_school->schoolId;
            $curl = curl_init();

            curl_setopt_array($curl, array(
               CURLOPT_URL => 'http://175.107.63.148:9090/ords/emis/psra/emiscode?id=2010201220172019',
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_ENCODING => '',
               CURLOPT_MAXREDIRS => 10,
               CURLOPT_TIMEOUT => 0,
               CURLOPT_FOLLOWLOCATION => true,
               //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
               CURLOPT_CUSTOMREQUEST => 'GET',
               //CURLOPT_POSTFIELDS => array("school_id" => $school_id),
               // CURLOPT_HTTPHEADER => array(
               // 	'x-api-key: n2r5u8x/A?D(G+KbPdSgVkYp3s6v9y$B'
               // ),
               CURLOPT_FAILONERROR => TRUE
            ));
            //var_dump($curl);
            if (curl_errno($curl)) {
               $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
               curl_close($curl);
               $response['response'] = false;
               $response['message'] = 'Request Error:' . curl_error($curl);
               curl_close($curl);
               var_dump($response);
            } else {
               $response = array();
               $response = curl_exec($curl);
               curl_close($curl);
               $emis_code = json_decode($response);
               echo $emis_code->items[0]->emiscode;
            }
            echo "<br />";
         }
      } else {
         echo "No new regsitered school found.";
      }
   }
}
