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

    // Redirect To Login
    function redirectToLogin(){
        $url = get_home_url();
        echo("<script>window.location.assign('$url');</script>");
    }

    //
    function logoutUser(){
        // Set Cookie Name
        $cookieName = 'userLogin';

        // Destroy Session
        // Unset all of the session variables.
        $_SESSION = array();

        // Finally, destroy the session.
        session_destroy();

        // Destroy Cookie
        if(isset($_COOKIE[$cookieName])){
            $expiry = time() - 60*60*24*180;
            $deleteCookie = setcookie($cookieName, "", $expiry, '/', $_SERVER['SERVER_NAME'], false, false);
        }

        // Redirect To Login
        redirectToLogin();
    }

    // Navigate
    function navigateToUserHomePage(){
        if ($_SESSION['AccountPosition'] === 'ADMIN') {
    //                $url = get_home_url() . '/admin-file-management/';
    //                echo("<script>window.location.assign('$url');</script>");
        } else if ($_SESSION['AccountPosition'] === 'AGENT') {
    //                $url = get_home_url() . '/my-cases/';
    //                echo("<script>window.location.assign('$url');</script>");
        }else if ($_SESSION['AccountPosition'] === 'ACCOUNTANT') {
            $url = get_home_url() . '/accountant-files-management/';
            echo("<script>window.location.assign('$url');</script>");
        }else if ($_SESSION['AccountPosition'] === 'SUPERUSER') {
    //                $url = get_home_url() . '/super-user-home-page/';
    //                echo("<script>window.location.assign('$url');</script>");
        }
    }

    // Generate Password
    function generate_password(){
        $length = 8;
        $keyspace = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new Exception('$keyspace must be at least two characters long');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

    // Encrypt Email
    function encrypt_email($conn, $email){
        $email = encrypt($conn, $email);
        return $email;
    }

    // Encrypt Password
    function encrypt_password($conn, $password){
        $password = encrypt($conn, $password);
        $password = md5($password);
        return $password;
    }

    // Encrypt
    function encrypt($conn, $data){
        $data = strip_tags($data);
        $data = stripslashes($data);
        $data = mysqli_real_escape_string($conn, $data);
        return $data;
    }

    // Send User Password By Email
    function send_user_password($email, $firstName, $lastName,$password){
        $to = $email;
        $subject = 'NuStream Account Password';
        $message = 'Hello ' . $firstName . " " . $lastName . ", \r\n \r\n" .
            "You have registered with NuStream successfully. Your Password is " . $password .
            ". To change your password, visit the following address: http://www.nustreamtoronto.com/ \r\n \r\n" .
            "sincerely,  \r\n " . "NuStream";
        $headers = 'From: NuStream';

        $sendEmailResult = mail($to, $subject, $message, $headers);
        return $sendEmailResult;
    }

    // Combine Files
    function combine_files(){
//        require_once('fpdf/fpdf.php');
//        require_once('fpdi/fpdi.php');
//
//        // Set URL
//        $homeURL = get_home_url();
//
//        $pdf = new FPDI();
//
//        $pdf->setSourceFile("C:\Users\Darren\Desktop\a.pdf");
//        $tplIdxA = $pdf->importPage(1, '/MediaBox');
//
//        $pdf->setSourceFile("C:\Users\Darren\Desktop\b.pdf");
//        $tplIdxB = $pdf->importPage(1, '/MediaBox');
//
//        $pdf->addPage();
//        // place the imported page of the first document:
//        $pdf->useTemplate($tplIdxA, 10, 10, 90);
//        // place the imported page of the snd document:
//        $pdf->useTemplate($tplIdxB, 100, 10, 90);
//
//        $pdf->Output();

    }

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

	// Get Suppliers Type
	function get_supplier_types(){
	    $supplierTypes = array(
            'STAGING',
            'PHOTOGRAPHY',
            'CLEANUP',
            'RELOCATEHOME',
            'TOUCHUP',
            'INSPECTION',
            'YARDWORK',
            'STORAGE'
        );
        return $supplierTypes;
    }

	// Get Price Unit
	function get_price_units(){
        $priceUnits = array(
            'BYSIZE',
            'BYHOUR',
            'BYHOUSETYPE',
            'BYCASE'
        );
        return $priceUnits;
    }

	// Get Payment Term
	function get_payment_terms(){
        $paymentTerms = array(
            'MONTHLY',
            'SEMIMONTHLY',
            'OTHER'
        );
        return $paymentTerms;
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

    // Get Supplier Brief Info
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

    // Get Init Suppliers Data
    function init_suppliers_data($dataType){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        return init_suppliers_data_request($dataType);
    }

    // Deactivate Supplier
    function deactivate_supplier_by_id($supplierID){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        return deactivate_supplier_by_id_request($supplierID);
    }

    // Set File Path And Name
    function set_file_path_and_name($uploaderType, $uploaderID, $uploadPath, $uploadName, $uploadType){
        require_once(__DIR__ . '/include/repository/file-repository.php');
        return set_file_path_and_name_request($uploaderType, $uploaderID, $uploadPath, $uploadName, $uploadType);
    }

    // Get All Images
    function download_all_files($uploadPath){
        require_once(__DIR__ . '/include/repository/file-repository.php');
        return download_all_files_request($uploadPath);
    }

    // Create Team
    function create_team($createTeamArray){
        require_once(__DIR__ . '/include/repository/team-repository.php');
        return create_team_request($createTeamArray);
    }

    // Get Team ID By Team Leader
    function get_team_id_by_team_leader($teamLeaderID){
        require_once(__DIR__ . '/include/repository/team-repository.php');
        return get_team_id_by_team_leader_request($teamLeaderID);
    }

    // Get Team By Team ID
    function get_team_by_team_id($teamID){
        require_once(__DIR__ . '/include/repository/team-repository.php');
        return get_team_by_team_id_request($teamID);
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
    function deactivate_account_by_id($accountID){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return deactivate_account_by_id_request($accountID);
    }

    // Log in
    function login($loginArray){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return login_request($loginArray);
    }

    // Check if account exist
    function is_account_exist($email){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return is_account_exist_request($email);
    }

    // Get All Member Brief Info
    function get_agent_member_brief_info($orderVariable){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return get_agent_member_brief_info_request($orderVariable);
    }
?>