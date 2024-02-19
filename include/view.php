<div class="wrap">
<h1 class="wp-heading-inline">WP List Table</h1>
<hr class="wp-header-end">
<?php 
require_once(ABSPATH.'wp-admin/includes/class-wp-list-table.php');
class AjaxCrudListTableClass extends WP_List_Table{
	// define data set for WP_List_Table => data
	var $data = array(
		array('id'=>1, 'name'=>'Sanjay', 'designation'=>'Web Developer', 'email'=>'sanjay@gmail.com', 'address'=> 'Dhaka, Bangladesh'),
		array('id'=>2, 'name'=>'Morad', 'designation'=>'Wordpress Developer', 'email'=>'morad@gmail.com', 'address'=> 'Rangppur, Bangladesh'),
		array('id'=>3, 'name'=>'Masud', 'designation'=>'Shopify Developer', 'email'=>'masud@gmail.com', 'address'=> 'Narsingdi, Bangladesh'),
		array('id'=>4, 'name'=>'Mohosin', 'designation'=>'Webflow Developer', 'email'=>'mohosin@gmail.com', 'address'=> 'Khulna, Bangladesh')
	);

	// prepare_items
	public function prepare_items(){
		$this->items = $this->data;
		$columns = $this->get_columns();
		$hidden = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array($columns, $hidden, $sortable);
	}

	// hidden columns
	public function get_hidden_columns(){
		return array("email");
	}

	// sortable columns
	public function get_sortable_columns(){
		return array(
			"name" => array("name", true),
			"address" => array("address", false)
		);
	}

	// get_columns
	public function get_columns(){
		$columns = array(
			"id" => "ID",
			"name" => "Name",
			"designation" => "Designation",
			"email" => "Email",
			"address" => "Address" 
		);
		return $columns;
	}

	// column_default
	public function column_default($item, $column_name){
		switch($column_name){
			case 'id':
			case 'name':
			case 'designation':
			case 'email':
			case 'address':
				return $item[$column_name];
			default:
				return "no value";
		}
	}
}

function AjaxCrudListTable_layout(){
	$ajax_wp_list_talbe = new AjaxCrudListTableClass();

	// calling prepare_items from class
	$ajax_wp_list_talbe->prepare_items();

	$ajax_wp_list_talbe->display();
}
AjaxCrudListTable_layout();

?>
</div>