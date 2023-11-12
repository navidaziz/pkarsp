<?php
class Item_allotment_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_items()
    {
        $query = $this->db->get('items');
        return $query->result_array();
    }

    public function add_item($name, $quantity)
    {
        $data = array(
            'name' => $name,
            'quantity' => $quantity
        );
        $this->db->insert('items', $data);
    }

    public function remove_item($name, $quantity)
    {
        $this->db->set('quantity', "quantity - $quantity", FALSE);
        $this->db->where('name', $name);
        $this->db->where('quantity >=', $quantity);
        $this->db->update('items');
    }

    public function allot_item($datas)
  {

      $this->db->set('quantity_available', 'quantity_available -'. $datas['allot_quantity'], FALSE);
      $this->db->where('id', $datas['item_id']);
      $this->db->update('items');

      $data = array(
          'item_id' => $datas['item_id'],
          'quantity'=> $datas['allot_quantity'],
          'designation_id' => $datas['official_desig'],
          'item_desc' => $datas['allot_desc'],
          'allotment_date' => $datas['allotment_date'],
          'quantity_remaining' => $datas['allot_quantity'],
          'image_path'=> $datas['image_path'],
          'item_image_path' => $datas['item_image_path']
          //'return_date' => $datas['return_date'],
          //'returned' => 0
      );
      $this->db->insert('item_allotments', $data);
  }


  /*  public function return_item($name, $quantity, $official_name)
    {
        $this->db->set('quantity', "quantity + $quantity", FALSE);
        $this->db->where('name', $name);
        $this->db->update('items');

        $this->db->where('item_name', $name);
        $this->db->where('quantity', $quantity);
        $this->db->where('official_name', $official_name);
        $this->db->delete('allotments');
    }*/

    public function get_allotments()
    {
        $query = $this->db->get('allotments');
        return $query->result_array();
    }

    public function add($data)
    {
        $this->db->insert('item_allotments', $data);
    }
    public function get_allotment_by_item_id($item_id)
{

    $this->db->select('item_allotments.*, items.quantity');
    $this->db->join('items', 'items.id = item_allotments.item_id');
    $this->db->where('item_allotments.item_id', $item_id);
    $query = $this->db->get('item_allotments');
    return $query->row_array();
}

       public function return_item($id_allot,$return_quantity, $return_date)
       {

        $this->db->select('item_id');
        $this->db->from('item_allotments');
        $this->db->where('id', $id_allot);
        $query = $this->db->get();
        $row = $query->row();
        $itemId = $row->item_id;

        // Subtract quantity_return from quantity_available in items table
        $this->db->set('quantity_available', 'quantity_available + ' . $return_quantity, false);
        $this->db->where('id', $itemId);
        $this->db->update('items');


         $this->db->set('quantity_remaining', 'quantity_remaining -'. $return_quantity, FALSE);
         $this->db->where('id', $id_allot);
         $this->db->update('item_allotments');

         $data = array(
             'allot_id' => $id_allot,
             'quantity_return'=> $return_quantity,
             'date_return' => $return_date
         );
         $this->db->insert('item_return', $data);

       }

       public function getItemsWithRemainingQuantity() {
        $this->db->select('item_allotments.id, items.name as item_name, categories.name as category_name, officials.designation as official_designation, wings.wing_name as wing_name, item_allotments.quantity_remaining, item_allotments.item_desc, item_allotments.image_path, item_allotments.item_image_path');
        $this->db->from('item_allotments');
        $this->db->join('officials', 'officials.id = item_allotments.designation_id');
        $this->db->join('wings', 'wings.id = officials.wing');
        $this->db->join('items', 'items.id = item_allotments.item_id');
        $this->db->join('categories', 'categories.id = items.category_id');
        $this->db->where('item_allotments.quantity_remaining >', 0);
        $query = $this->db->get();
        return $query->result();
}

        public function add_quantity($itemId, $quantityToAdd, $itemDescription) {
        // Get the current item's quantity and available quantity
        $item = $this->db->get_where('items', array('id' => $itemId))->row();
        $currentQuantity = $item->quantity;
        $currentAvailableQuantity = $item->quantity_available;

        // Calculate the new quantity and available quantity
        $newQuantity = $currentQuantity + $quantityToAdd;
        $newAvailableQuantity = $currentAvailableQuantity + $quantityToAdd;

        // Update the item's quantity and available quantity in the database
        $this->db->where('id', $itemId);
        $this->db->update('items', array('quantity' => $newQuantity, 'quantity_available' => $newAvailableQuantity, 'description' => $itemDescription));
    }

}
