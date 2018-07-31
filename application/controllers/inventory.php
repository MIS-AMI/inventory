<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
		$this->load->model('inventory_model');
	}

	public function index()
	{
		$data['items'] = $this->inventory_model->select_items();
		$data['cart_items'] = $this->inventory_model->select_cart_items();
		$this->load->view('inv_view',$data);
	}
	
	public function add_items()
    {
		$item_skus 			= $this->input->post('item_sku');
		$item_names 		= $this->input->post('item_name');
		$item_quantities 	= $this->input->post('item_quantity');
		$item_prices 		= $this->input->post('item_price');
		for($i=0;$i<count($item_skus);$i++){
			if(!empty($item_skus[$i]) && !empty($item_names[$i]) && !empty($item_quantities[$i]) && !empty($item_prices[$i]))
			$this->inventory_model->add_item($item_skus[$i],$item_names[$i],$item_quantities[$i],$item_prices[$i]);
		}
		redirect(base_url().'inventory/index');
	}
	
	public function add_items_to_cart()
    {
		$item_skus 			= $this->input->post('sku_needed');
		$quantities 		= $this->input->post('quantity_needed');
		$item_total_price	= Array();
		for($i=0;$i<count($item_skus);$i++){
			if(!empty($item_skus[$i]) && !empty($quantities[$i])){
				$item_specification = $this->inventory_model->select_item_with_sku($item_skus[$i]);
				$item_total_price[$i] = $item_specification[0]['item_price']*$quantities[$i];
				$item_inv_qty = $this->inventory_model->select_item_with_sku($item_skus[$i])[0]['item_quantity'];
				if($item_inv_qty >= $quantities[$i]) {
                    $this->inventory_model->add_item_to_cart($item_skus[$i], $quantities[$i], $item_total_price[$i]);
                }
                else{
                    redirect(base_url().'inventory/index');
                }
			}
		}
		redirect(base_url().'inventory/index');
	}
	
	public function sku_select_box()
    {
		echo json_encode($this->inventory_model->select_items());
	}
	
	public function remove_cart_item()
    {
		echo json_encode($this->inventory_model->remove_cart_item($this->input->post('item_sku')));
	}

	public function add_transaction()
    {
        $trans_items = $this->input->post("trans_items");
        for($i = 0;$i< count($trans_items); $i++){
            if($i==0) continue;
            $this->inventory_model->insert_transaction($trans_items[$i]["trans_item_sku"],'1',$trans_items[$i]["trans_qty_needed"],$trans_items[$i]["trans_total_price"],$trans_items[$i]["trans_added_by"]);
        }
        echo json_encode("Transation Inserted Successfully");
    }
}
