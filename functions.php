<?php
	function demo001_resources(){
		wp_enqueue_style('style', get_stylesheet_uri());
	}
	
	add_action('wp_enqueue_scripts', 'demo001_resources');
	
	// Navigation Menus
	register_nav_menus(array(
		'primary' => __( 'Primary Menu'),
		'footer' => __( 'Footer Menu'),
	));
	
	
	// Get top ancestor
	function get_top_ancestor_id() {
		global $post;
		if($post->post_parent) {
			$ancestors = array_reverse(get_post_ancestors($post->ID));
			return $ancestors[0];
		}
		
		return $post->ID;
	}
	
	//Does page have children?
	function has_children() {
		global $post;
		$pages = get_pages('child_of=' . $post->Id);
		return count($pages);
	}
	
	//Create supplier

        echo htmlspecialchars($_POST['name']);
	/* function create_supplier() {
		echo '<script type="text/javascript">alert("It works.");</script>';
		$supplierName = 
		$HSTNumber = 
		$firstContactName = 
		$firstContactNumber = 
		$secondContactName = 
		$secondContactNumber = 
		$priceUnit = 
		$pricePerUnit =
		$paymentTerm = "";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$supplierName = test_input($_POST["supplierName"]);
			$HSTNumber = test_input($_POST["HSTNumber"]);
			$firstContactName = test_input($_POST["firstContactName"]);
			$firstContactNumber = test_input($_POST["firstContactNumber"]);
			$secondContactName = test_input($_POST["secondContactName"]);
			$secondContactNumber = test_input($_POST["secondContactNumber"]);
			$priceUnit = test_input($_POST["priceUnit"]);
			$pricePerUnit = test_input($_POST["pricePerUnit"]);
			$paymentTerm = test_input($_POST["paymentTerm"]);
		}
		//Test
		//TODO: call repository to insert data into database
	}
	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	} */

?>