<?php
class Item_model extends CI_Model {

    private $table = 'items';
    private $item_name;
    private $quantity;
    private $description;

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $this->db->select('items.id, items.name, categories.name as category_name, items.quantity, items.quantity_available, items.description, image_path');
        $this->db->from('items');
        $this->db->join('categories', 'items.category_id = categories.id');
        $query = $this->db->get();
        return $query->result();
    }

    public function add($item_name, $item_category_id, $item_quantity, $item_description, $image_path) {
        $data = array(
            'name' => $item_name,
            'category_id'=> $item_category_id,
            'quantity' => $item_quantity,
            'quantity_available' => $item_quantity,
            'description' => $item_description,
            'image_path' => $image_path
        );

        $this->db->insert($this->table, $data);
    }

    public function remove_item($item_id) {
        $this->db->where('id', $item_id);
        $this->db->delete($this->table);
    }


    public function decrease_quantity($item_id)
        {
            $this->db->set('quantity', 'quantity - 1', FALSE);
            $this->db->where('id', $item_id);
            $this->db->update('items');
        }
        public function increase_quantity($item_id, $return_quantity)
        {
            $this->db->set('quantity', 'quantity + ' . $return_quantity, FALSE);
            $this->db->where('id', $item_id);
            $this->db->update('items');
        }

        public function get_categories()
    {
        $query = $this->db->get('categories');
        return $query->result_array();
    }
        // ...
        public function add_category($category_name)
        {
            $data = array(
                'name' => $category_name
            );

            $this->db->insert('categories', $data);
        }

        public function add_official($designation, $wing)
        {
            $data = array(
                'designation' => $designation,
                'wing' => $wing,
            );

            $this->db->insert('officials', $data);
        }

        public function get_officials()
    {
        $query = $this->db->get('officials');
        return $query->result_array();
    }

    public function get_wings()
{
    $query = $this->db->get('wings');
    return $query->result_array();
}

public function get_image_path($item_id)
{
    $this->db->select('image_path');
    $this->db->where('id', $item_id);
    $query = $this->db->get($this->table);

    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->image_path;
    }

    return null; // No image found for the item
}
    // other methods for updating and retrieving items
}
