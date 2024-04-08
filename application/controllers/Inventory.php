<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends CI_Controller
{
    //sone changes here....
    public function __construct()
    {
        parent::__construct();
        $this->load->model('item_model');
        $this->load->model('item_allotment_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['items'] = $this->item_model->get_all();
        $data['categories'] = $this->item_model->get_categories();
        $data['officials'] = $this->item_model->get_officials();
        $data['wings'] = $this->item_model->get_wings();
        $data['allotedItems'] = $this->item_allotment_model->getItemsWithRemainingQuantity();
        //  print_r($officials);
        //  exit;
        $this->load->view('inventory_list3', $data);
    }

    public function add_item()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
        $this->form_validation->set_rules('description', 'Description', 'required');

        // Check if the form validation passed
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('inventory_list3');
        } else {
            // Get the item data from the form
            $name = $this->input->post('name');
            $category_id = $this->input->post('category_id');
            $quantity = $this->input->post('quantity');
            $description = $this->input->post('description');

            // Check if an image was uploaded
            if (!empty($_FILES['item_image']['name']) or 1 == 1) {
                $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/inventory/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);  //create directory if not exist
                }
                $config['upload_path'] = $upload_dir;
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('item_image')) {
                    // File upload failed
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error_message', $error);
                    redirect('inventory');
                } else {
                    $upload_data = $this->upload->data();
                    $image_path = 'uploads/inventory/' . $upload_data['file_name'];
                }
            } else {
                // No image uploaded
                $image_path = ''; // Set an empty image path or any default image path if needed
            }

            // Add the item to the database with the image path
            $this->item_model->add($name, $category_id, $quantity, $description, $image_path);
            redirect('inventory');
        }
    }



    /*public function allot_item()
  {

      $this->form_validation->set_rules('allot_id', 'Item', 'required');
      $this->form_validation->set_rules('official_desig', 'Official Designation', 'required');
      $this->form_validation->set_rules('allot_quantity', 'Allot Quantity', 'required');
      $this->form_validation->set_rules('allotment_date', 'Allotment Date', 'required');

      if ($this->form_validation->run() === FALSE)
      {
          $data['items'] = $this->item_model->get_all();
          $this->load->view('inventory_list', $data);
      }
      else*/
    public function allot_item()
    {
        // Check if a file is uploaded
        if ($_FILES['item_image_allot']['name'] != "") {
            // Handle image upload
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/inventory/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);  //create directory if not exist
            }
            $config['upload_path'] = $upload_dir;
            $config['allowed_types'] = 'jpg|jpeg|png|gif'; // Define allowed file types
            $config['max_size'] = 2048; // Define max file size in kilobytes (2MB)

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('item_image_allot')) {
                // File upload failed
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error_message', $error);
                redirect('inventory'); // Redirect back to the inventory page with an error message
            } else {
                // File uploaded successfully, get the uploaded file data
                $upload_data = $this->upload->data();
                $image_path = 'uploads/inventory/' . $upload_data['file_name'];
            }
        } else {
            // No file was uploaded, set $image_path to an empty string or a default value
            $image_path = ''; // You can modify this to a default image path if needed
        }

        $data = array(
            'item_id' => $this->input->post('allot_id'),
            'allot_quantity' => $this->input->post('allot_quantity'),
            'official_desig' => $this->input->post('official_desig'),
            'allot_desc' => $this->input->post('allot_desc'),
            'allotment_date' => $this->input->post('allotment_date'),
            'image_path' => $image_path,
            'item_image_path' => $this->input->post('original_image_path')
        );


        $this->item_allotment_model->allot_item($data);
        redirect('inventory');
    }


    public function allot_item1()
    { {
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/inventory/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);  //create directory if not exist
            }
            $config['upload_path'] = $upload_dir;
            $config['allowed_types'] = 'jpg|jpeg|png|gif'; // Define allowed file types
            $config['max_size'] = 2048; // Define max file size in kilobytes (2MB)

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('item_image_allot')) {
                // File upload failed
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error_message', $error);
                redirect('inventory'); // Redirect back to the inventory page with an error message
            } else {
                // File uploaded successfully, get the uploaded file data
                $upload_data = $this->upload->data();
                $image_path = 'uploads/inventory/' . $upload_data['file_name'];
            }
            $data = array(
                'item_id' => $this->input->post('allot_id'),
                'allot_quantity' => $this->input->post('allot_quantity'),
                'official_desig' => $this->input->post('official_desig'),
                'allot_desc' => $this->input->post('allot_desc'),
                'allotment_date' => $this->input->post('allotment_date'),
                'image_path' => $image_path
            );

            // print_r($data);
            // exit;

            $this->item_allotment_model->allot_item($data);
            redirect('inventory');
        }
    }






    public function return_item()
    {
        $this->form_validation->set_rules('id_allot', 'ID Allot', 'required');
        $this->form_validation->set_rules('return_quantity', 'Return Quantity', 'required');
        $this->form_validation->set_rules('return_date', 'Return Date', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('inventory_list3');
        } else {
            $id_allot = $this->input->post('id_allot');
            $return_quantity = $this->input->post('return_quantity');
            $return_date = $this->input->post('return_date');

            // Update the item_allotments table to mark the item as returned
            $this->item_allotment_model->return_item($id_allot, $return_quantity, $return_date);

            // Redirect to the inventory page
            redirect('inventory');
        }
    }

    public function add_category()
    {
        $category_name = $this->input->post('category_name');

        // Call the method in the item_model to add the category
        $this->item_model->add_category($category_name);

        // Redirect back to the inventory list page
        redirect('inventory');
    }

    public function add_official()
    {

        $this->form_validation->set_rules('offical_designation', 'Offical Designation', 'required');
        $this->form_validation->set_rules('offical_wing', 'Offical Wing', 'required');

        if ($this->form_validation->run() === FALSE) {

            $this->load->view('inventory_list3');
        } else {

            $designation = $this->input->post('offical_designation');
            $wing = $this->input->post('offical_wing');

            $this->item_model->add_official($designation, $wing);
            redirect('inventory');
        }
    }

    public function add_quantity()
    {
        // Get the input data
        $itemId = $this->input->post('item_id');
        $quantityToAdd = $this->input->post('add_quantity');
        $itemDescription = $this->input->post('item_description');

        // Update the item quantity in the model
        $this->item_allotment_model->add_quantity($itemId, $quantityToAdd, $itemDescription);

        // Redirect back to the inventory page
        redirect('inventory');
    }
}
