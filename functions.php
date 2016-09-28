<?php
    // Get Project Style
	add_action('wp_enqueue_scripts', 'nustream_resources');
	
	// Navigation Menus
	register_nav_menus(array(
		'primary' => __( 'Primary Menu'),
		'footer' => __( 'Footer Menu'),
	));

    // Set Style File
    function nustream_resources(){
        wp_enqueue_style('style', get_stylesheet_uri());
    }

    // Generate Guid
    function GUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
	
	// Create Supplier
    function create_supplier($createSupplierArray) {
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        create_supplier_request($createSupplierArray);
    }

    // Edit Supplier
    function edit_supplier($createSupplierArray) {
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        edit_supplier_request($createSupplierArray);
    }

    function get_supplier_brief_info($supplierType){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        return get_supplier_brief_info_request($supplierType);
    }

?>