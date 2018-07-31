<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_model extends CI_Model {
	
	public function add_item($item_sku,$item_name,$item_quantity,$item_price)
    {
		$this->db->insert('inv_items',array(
		'item_sku'		=>$item_sku,
		'item_name'		=>$item_name,
		'item_quantity'	=>$item_quantity,
		'item_price'	=>$item_price
		));
		return $this->db->affected_rows();
	}
	
	public function add_item_to_cart($item_sku,$quantity_needed,$total_price)
    {
		$this->db->insert('shopping_cart',array(
		'item_sku'		=>$item_sku,
		'quantity'		=>$quantity_needed,
		'total_price'	=>$total_price,
        'inv_status'    =>0
		));
		return $this->db->affected_rows();
	}

	public function insert_transaction($item_sku,$trans_type,$quantity_needed,$total_price,$added_by)
    {
        $this->db->from('inv_items');
        $this->db->where('inv_items.item_sku',$item_sku);
        $query = $this->db->get();
        if($query && $query->num_rows()>0){
            $item = $query->result_array()[0];

            //update inventory quantity to the new quantity
            $inv_items_data = array(
                'item_quantity' => $item['item_quantity'] - $quantity_needed
            );
            $this->db->where('item_sku', $item_sku);
            $this->db->update('inv_items', $inv_items_data);

            //update the inventory flag in the shopping cart to 1 (out of inventory)
            $shoping_cart_data = array(
                'inv_status' => 1
            );
            $this->db->where('item_sku', $item_sku);
            $this->db->update('shopping_cart', $shoping_cart_data);
        }

		$this->db->insert('inv_transactions',array(
		'trans_item_sku'	=>$item_sku,
		'trans_type_id'		=>$trans_type,
		'trans_quantity'	=>$quantity_needed,
		'trans_total_price'	=>$total_price,
		'trans_added_by'	=>$added_by
		));
		return $this->db->affected_rows();
	}
	
	public function remove_cart_item($item_sku)
    {
		$this->db->where('item_sku', $item_sku);
		$this->db->delete('shopping_cart');
		return $this->db->affected_rows();
	}
	
	public function select_items()
    {
		$query = $this->db->get('inv_items');
		if($query && $query->num_rows()>0){
			return $query->result_array();
		}
	}
	
	public function select_item_with_sku($item_sku)
    {
		$this->db->from('inv_items');
		$this->db->where('inv_items.item_sku',$item_sku);
		$query = $this->db->get();
		if($query && $query->num_rows()>0){
			return $query->result_array();
		}
	}
	
	public function select_cart_items()
    {
		$this->db->from('shopping_cart');
		$this->db->where('inv_status', 0);
		$this->db->select('shopping_cart.item_sku, inv_items.item_name, SUM(quantity) total_quantity, SUM(total_price) as total, inv_status');
		$this->db->group_by('shopping_cart.item_sku');
		$this->db->order_by('total','desc');
		$this->db->join('inv_items','shopping_cart.item_sku = inv_items.item_sku');
		$query = $this->db->get();
		if($query && $query->num_rows()>0){
			return $query->result_array();
		}
	}
}