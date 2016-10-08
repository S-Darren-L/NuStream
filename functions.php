<?php
    // Get Project Style
	add_action('wp_enqueue_scripts', 'nustream_resources');

    // Get Project Script
    add_action('wp_enqueue_scripts', 'nustream_scripts');

    // Get JQuery Script
    add_action('wp_enqueue_scripts', 'jquery_scripts');
	
	// Navigation Menus
	register_nav_menus(array(
		'primary' => __( 'Primary Menu'),
		'footer' => __( 'Footer Menu'),
	));

    // Set Style File
    function nustream_resources(){
        wp_enqueue_style('style', get_stylesheet_uri());
    }

    // Set Script File
    function nustream_scripts(){
        wp_enqueue_script('script', get_template_directory_uri() . '/js/main-script.js');
    }

    // Set JQuery File
    function jquery_scripts(){
        wp_enqueue_script('jquery');
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
        return create_supplier_request($createSupplierArray);
    }

    function get_supplier_brief_info($supplierType){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        return get_supplier_brief_info_request($supplierType);
    }

    // Get Supplier Detail
    function get_supplier_detail($supplierID){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        return get_supplier_detail_request($supplierID);
    }

    // Edit Supplier
    function edit_supplier($updateSupplierArray) {
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        return edit_supplier_request($updateSupplierArray);
    }

    // Set File Path And Name
    function set_file_path_and_name($uploaderType, $uploaderID, $uploadPath, $uploadName, $uploadType){
        require_once(__DIR__ . '/include/repository/file-repository.php');
        return set_file_path_and_name_request($uploaderType, $uploaderID, $uploadPath, $uploadName, $uploadType);
    }

    // Get All Images
    function download_all_images($uploadPath){
        require_once(__DIR__ . '/include/repository/file-repository.php');
        return download_all_images_request($uploadPath);
    }

    // Create Team
    function create_team($createTeamArray){
        require_once(__DIR__ . '/include/repository/team-repository.php');
        return create_team_request($createTeamArray);
    }

    // Get Team ID By Tam Leader
    function get_team_id_by_team_leader($teamLeaderID){
        require_once(__DIR__ . '/include/repository/team-repository.php');
        return get_team_id_by_team_leader_request($teamLeaderID);
    }

    // Get All Agent Team Member Info
    function get_all_team_leaders(){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return get_all_team_leaders_request();
    }

    // Create Account
    function create_agent_account($createAccountArray){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return create_agent_account_request($createAccountArray);
    }

    // Update Account Team ID
    function update_account_team_id($updateAccountTeamIdArray){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return update_account_team_id_request($updateAccountTeamIdArray);
    }

    // Update Account
    function update_account($updateAccountArray){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return update_account_request($updateAccountArray);
    }

    // Get Agent Account
    function get_agent_account($accountID){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return get_agent_account_request($accountID);
    }

    // Deactivate Account
    function deactivate_account($deactivateAccountArray){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return deactivate_account_request($deactivateAccountArray);
    }

    // Log in
    function login($loginArray){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return login_request($loginArray);
    }
?>