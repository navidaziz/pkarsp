<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_dashboard extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->helper('project_helper');
   }





   public function index()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/index', $this->data);
   }

   public function registration_summary()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/registration_summary', $this->data);
   }

   public function other_summary()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/other_summary', $this->data);
   }

   public function level_wise_other_summary()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Level Wise Other Summary';
      $this->load->view('md_dashboard/level_wise_other_summary', $this->data);
   }

   public function summary()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/summary', $this->data);
   }
   public function level_wise_summary()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/level_wise_summary', $this->data);
   }
   public function region_wise_summary()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/regsion_wise_summary', $this->data);
   }
   public function district_wise_summary()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/district_wise_summary', $this->data);
   }
   public function yearly_monthly_summary()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/yearly_monthly_summary', $this->data);
   }
   public function yearly_monthly_session_summary()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/yearly_monthly_session_summary', $this->data);
   }
   public function daily_progress_report()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/daily_progress_report', $this->data);
   }
   public function region_progress_report()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/region_progress_report', $this->data);
   }

   public function session_progress_report()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/session_progress_report', $this->data);
   }

   public function students_summary_report()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/students_summary_report', $this->data);
   }

   public function back()
   {

      // Database configuration
      $databaseHost = 'localhost';
      $databaseName = 'new_psra_db_4';
      $databaseUser = 'root';
      $databasePassword = '';

      // Google Drive configuration
      $folderId = 'your_google_drive_folder_id';
      $serviceAccountKeyFile = 'path/to/your/service-account-key.json';

      // Database backup filename (you can customize this)
      $backupFilename = 'database_backup_' . date('Y-m-d') . '.sql';

      // Create a database backup
      $backupCommand = "mysqldump -h$databaseHost -u$databaseUser -p$databasePassword $databaseName > $backupFilename";
      exec($backupCommand);

      // Initialize Google Drive client
      putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $serviceAccountKeyFile);
      $client = new Google_Client();
      $client->useApplicationDefaultCredentials();
      $client->setScopes(['https://www.googleapis.com/auth/drive.file']);
      $driveService = new Google_Service_Drive($client);

      // Upload the backup to Google Drive
      $fileMetadata = new Google_Service_Drive_DriveFile([
         'name' => $backupFilename,
         'parents' => [$folderId],
      ]);
      $fileContent = file_get_contents($backupFilename);
      $file = $driveService->files->create($fileMetadata, [
         'data' => $fileContent,
         'mimeType' => 'application/sql', // Adjust the MIME type if needed
         'uploadType' => 'multipart',
      ]);

      // Clean up: Delete the local backup file if needed
      unlink($backupFilename);

      echo 'Database backup successfully created and uploaded to Google Drive.';
   }
}
