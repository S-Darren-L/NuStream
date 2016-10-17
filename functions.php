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
            $url = get_home_url() . '/admin-files-management';
            echo("<script>window.location.assign('$url');</script>");
        } else if ($_SESSION['AccountPosition'] === 'AGENT') {
            $url = get_home_url() . '/agent-my-cases';
            echo("<script>window.location.assign('$url');</script>");
        }else if ($_SESSION['AccountPosition'] === 'ACCOUNTANT') {
            $url = get_home_url() . '/accountant-files-management';
            echo("<script>window.location.assign('$url');</script>");
        }else if ($_SESSION['AccountPosition'] === 'SUPERUSER') {
    //                $url = get_home_url() . '/super-user-home-page';
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
        require_once('fpdf/fpdf.php');
        require_once('fpdi/fpdi.php');

        // Set URL
        $homeURL = get_home_url();

        $pdf = new FPDI();

        $pdf->setSourceFile("C:\Users\Darren\Desktop\a.pdf");
        $tplIdxA = $pdf->importPage(1, '/MediaBox');

        $pdf->setSourceFile("C:\Users\Darren\Desktop\b.pdf");
        $tplIdxB = $pdf->importPage(1, '/MediaBox');

        $pdf->addPage();
        // place the imported page of the first document:
        $pdf->useTemplate($tplIdxA,0,0,200,280);
        $pdf->addPage();
        // place the imported page of the snd document:
        $pdf->useTemplate($tplIdxB,0,0,200,280);

        $uploadPath = "wp-content/themes/NuStream/Upload/";
        $filename = $uploadPath . "test.pdf";
        $pdf->Output($filename,'F');
//        $pdf->Output();

    }

    // Combine PDF Array
    function combine_pdf_array($reportInvoicesArray){
        require_once('fpdf/fpdf.php');
        require_once('fpdi/fpdi.php');

        $pdf = new FPDI();
        foreach ($reportInvoicesArray as  $reportInvoiceKey => $reportInvoiceFile) {
            $pdf->setSourceFile($reportInvoiceFile);
            $tplIdxA = $pdf->importPage(1, '/MediaBox');
            $pdf->addPage();
            // place the imported page of the first document:
            $pdf->useTemplate($tplIdxA,0,0,200,280);
        }
        $uploadPath = "wp-content/themes/NuStream/Upload/";
        $filename = $uploadPath . "combine file array.pdf";
        $pdf->Output($filename,'F');
        return $filename;
    }

    // Convert Image To PDF
    function convert_image_to_pdf($image){
        require_once('fpdf/fpdf.php');
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image($image,10,10,180,280);
        $uploadPath = "wp-content/themes/NuStream/Upload/";
        $filename = $uploadPath . rand(10000, 99999) . rand(10000, 99999) . ".pdf";
        $pdf->Output($filename,'F');
        return $filename;
    }

    // Generate Case Report
    function generate_case_report($reportFromArray, $reportInvoicesArray){
        // Generate Case Report Form
        $reportFormFile = generate_case_report_from($reportFromArray);
//        $reportInvoicesFile = combine_case_report_invoices($reportInvoicesArray);
//        $finalReportFile = combine_files($reportFormFile, $reportInvoicesFile);
    }

    // Generate Case Report Form
    function generate_case_report_from($reportFromArray){
        $MLS = $reportFromArray['MLS'];
        $address = $reportFromArray['address'];
        $teamLeader = $reportFromArray['teamLeader'];
        $teamMember = $reportFromArray['teamMember'];
        $sellerName = $reportFromArray['sellerName'];
        $propertyType = $reportFromArray['propertyType'];
        $stagingSupplier = $reportFromArray['stagingSupplier'];
        $stagingContact = $reportFromArray['stagingContact'];
        $stagingFinalPrice = $reportFromArray['stagingFinalPrice'];
        $cleanUpSupplier = $reportFromArray['cleanUpSupplier'];
        $cleanUpContact = $reportFromArray['cleanUpContact'];
        $cleanUpFinalPrice = $reportFromArray['cleanUpFinalPrice'];
        $touchUpSupplier = $reportFromArray['touchUpSupplier'];
        $touchUpContact = $reportFromArray['touchUpContact'];
        $touchUpFinalPrice = $reportFromArray['touchUpFinalPrice'];
        $inspectionSupplier = $reportFromArray['inspectionSupplier'];
        $inspectionContact = $reportFromArray['inspectionContact'];
        $inspectionFinalPrice = $reportFromArray['inspectionFinalPrice'];
        $yardWorkSupplier = $reportFromArray['yardWorkSupplier'];
        $yardWorkContact = $reportFromArray['yardWorkContact'];
        $yardWorkFinalPrice = $reportFromArray['yardWorkFinalPrice'];
        $storageSupplier = $reportFromArray['storageSupplier'];
        $storageContact = $reportFromArray['storageContact'];
        $storageFinalPrice = $reportFromArray['storageFinalPrice'];
        $relocateHomeSupplier = $reportFromArray['relocateHomeSupplier'];
        $relocateHomeContact = $reportFromArray['relocateHomeContact'];
        $relocateHomeFinalPrice = $reportFromArray['relocateHomeFinalPrice'];
        $giftPackageSupplier = $reportFromArray['giftPackageSupplier'];
        $giftPackageContact = $reportFromArray['giftPackageContact'];
        $giftPackageFinalPrice = $reportFromArray['giftPackageFinalPrice'];
        $company = $reportFromArray['company'];
        $photoGraphicPrice = $reportFromArray['photoGraphicPrice'];
        $openHouseBrochurePrice = $reportFromArray['openHouseBrochurePrice'];

        require_once('tcpdf/tcpdf.php');

// create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 001');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

// ---------------------------------------------------------

// set default font subsetting mode
        $pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 8, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

// set text shadow effect
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
        $html = <<<EOD
<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
<i>This is the first example of TCPDF library.</i>
<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
<p>Please check the source code documentation and other examples for further information.</p>
<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
EOD;

// Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
        $uploadPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . "Upload/";
        $filename = $uploadPath . "generatedPDF.pdf";
        ob_clean();
        $pdf->Output($filename,'F');
    }

    // Combine Case Report Invoices
    function combine_case_report_invoices($reportInvoicesArray){
        foreach ($reportInvoicesArray as  $reportInvoiceKey => $reportInvoiceFile) {
            $reportInvoiceFile = strtolower($reportInvoiceFile);
            $allowedImagesType =  array('png' ,'jpg');
            $allowedFilesType ='pdf';
            $ext = pathinfo($reportInvoiceFile, PATHINFO_EXTENSION);
            if(in_array($ext, $allowedImagesType)){
                // Convert Image to PDF
                $reportInvoiceFile = convert_image_to_pdf($reportInvoiceFile);
//                echo $reportInvoiceFile;
                $reportInvoicesArray[$reportInvoiceKey] = $reportInvoiceFile;
            }else if($ext === $allowedFilesType){
                // Is PDF File, Do Nothing
            }else{
                // TODO: File Type Is Not Supported
            }
        }
        try {
            $reportInvoicesFile = combine_pdf_array($reportInvoicesArray);
        }catch(Exception $e) {
            echo "Unable combine all PDFs, some file types are not supported";
        }
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
            'BYCASE',
            'BYSIZE1000'
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

    // Get Property Type
    function get_property_types(){
        $propertyTypes = array(
            'CONDO',
            'HOUSE',
            'SEMI',
            'TOWNHOUSE'
        );
        return $propertyTypes;
    }

    // Test Input
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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

    // Default Estimate Staging Price
    function default_staging_price_estimate($houseSize){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_default_supplier_by_type('STAGING'));
        return calculate_staging_price_estimate($houseSize, $supplierResult);
    }

    // Estimate Staging Price By ID
    function staging_price_estimate_by_id($houseSize, $supplierID){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_supplier_detail_request($supplierID));
        return calculate_staging_price_estimate($houseSize, $supplierResult);
    }

    // Calculate Staging Price
    function calculate_staging_price_estimate($houseSize, $supplierResult){
        $servicePrice = $supplierResult['PricePerUnit'] * $houseSize;
        if($servicePrice < $supplierResult['MinimumPrice']){
            $servicePrice = $supplierResult['MinimumPrice'];
        }
        return $servicePrice;
    }

    // Default Estimate Photography Price
    function default_photography_price_estimate($propertyType){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_default_supplier_by_type('PHOTOGRAPHY'));
        return calculate_photography_price_estimate($propertyType, $supplierResult);
    }

    // Estimate Photography Price By ID
    function photography_price_estimate_by_id($propertyType, $supplierID){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_supplier_detail_request($supplierID));
        return calculate_photography_price_estimate($propertyType, $supplierResult);
    }

    // Calculate Photography Price
    function calculate_photography_price_estimate($propertyType, $supplierResult){
        if($propertyType === 'CONDO')
            $servicePrice = $supplierResult['PricePerCondo'];
        else if($propertyType === 'HOUSE')
            $servicePrice = $supplierResult['PricePerHouse'];
        else if($propertyType === 'SEMI')
            $servicePrice = $supplierResult['PricePerSemi'];
        else if($propertyType === 'TOWNHOUSE')
            $servicePrice = $supplierResult['PricePerTownhouse'];
        else
            $servicePrice = 0;
        return $servicePrice;
    }

    // Default Estimate Clean Up Price
    function default_clean_up_price_estimate($houseSize){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_default_supplier_by_type('CLEANUP'));
        return calculate_clean_up_price_estimate($houseSize, $supplierResult);
    }

    // Estimate Clean Up Price By ID
    function clean_up_price_estimate_by_id($houseSize, $supplierID){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_supplier_detail_request($supplierID));
        return calculate_clean_up_price_estimate($houseSize, $supplierResult);
    }

    // Calculate Estimate Clean Up Price
    function calculate_clean_up_price_estimate($houseSize, $supplierResult){
        $servicePrice = $supplierResult['PricePer1000Unit'] * $houseSize/1000;
        if($servicePrice < $supplierResult['MinimumPrice']) {
            $servicePrice = $supplierResult['MinimumPrice'];
        }
        return $servicePrice;
    }

    // Default Estimate Relocate Home Price
    function default_relocate_home_price_estimate(){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_default_supplier_by_type('RELOCATEHOME'));
        return calculate_relocate_home_price_estimate($supplierResult);
    }

    // Estimate Relocate Home Price By ID
    function relocate_home_price_estimate_by_id($supplierID){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_supplier_detail_request($supplierID));
        return calculate_relocate_home_price_estimate($supplierResult);
    }

    // Calculate Estimate Relocate Home Price
    function calculate_relocate_home_price_estimate($supplierResult){
        $servicePrice = $supplierResult['PricePerCase'];
        return $servicePrice;
    }

    // Default Estimate Touch Up Price
    function default_touch_up_price_estimate(){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_default_supplier_by_type('TOUCHUP'));
        return calculate_touch_up_price_estimate($supplierResult);
    }

    // Estimate Touch Up Price By ID
    function touch_up_price_estimate_by_id($supplierID){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_supplier_detail_request($supplierID));
        return calculate_touch_up_price_estimate($supplierResult);
    }

    // Calculate Estimate Touch Up Price
    function calculate_touch_up_price_estimate($supplierResult){
        $servicePrice = $supplierResult['PricePerCase'];
        return $servicePrice;
    }

    // Default Estimate Inspection Price
    function default_inspection_price_estimate($propertyType){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_default_supplier_by_type('INSPECTION'));
        return calculate_inspection_price_estimate($propertyType, $supplierResult);
    }

    // Estimate Inspection Price By ID
    function inspection_price_estimate_by_id($propertyType, $supplierID){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_supplier_detail_request($supplierID));
        return calculate_inspection_price_estimate($propertyType, $supplierResult);
    }

    // Calculate Estimate Inspection Price
    function calculate_inspection_price_estimate($propertyType, $supplierResult){
        if($propertyType === 'CONDO')
            $servicePrice = $supplierResult['PricePerCondo'];
        else if($propertyType === 'HOUSE')
            $servicePrice = $supplierResult['PricePerHouse'];
        else if($propertyType === 'SEMI')
            $servicePrice = $supplierResult['PricePerSemi'];
        else if($propertyType === 'TOWNHOUSE')
            $servicePrice = $supplierResult['PricePerTownhouse'];
        else
            $servicePrice = 0;
        return $servicePrice;
    }

    // Default Estimate Yard Work Price
    function default_yard_work_price_estimate(){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_default_supplier_by_type('YARDWORK'));
        return calculate_yard_work_price_estimate($supplierResult);
    }

    // Estimate Yard Work Price By ID
    function yard_work_price_estimate_by_id($supplierID){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_supplier_detail_request($supplierID));
        return calculate_yard_work_price_estimate($supplierResult);
    }

    // Calculate Estimate Yard Work Price
    function calculate_yard_work_price_estimate($supplierResult){
        $servicePrice = $supplierResult['PricePerCase'];
        return $servicePrice;
    }

    // Default Estimate Storage Price
    function default_storage_price_estimate(){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_default_supplier_by_type('STORAGE'));
        return calculate_storage_price_estimate($supplierResult);
    }

    // Estimate Storage Price By ID
    function storage_price_estimate_by_id($supplierID){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $supplierResult = mysqli_fetch_array(get_supplier_detail_request($supplierID));
        return calculate_storage_price_estimate($supplierResult);
    }

    // Calculate Estimate Storage Price
    function calculate_storage_price_estimate($supplierResult){
        $servicePrice = $supplierResult['PricePerCase'];
        return $servicePrice;
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
    function download_all_files_by_path($uploadPath){
        require_once(__DIR__ . '/include/repository/file-repository.php');
        return download_all_files_by_path_request($uploadPath);
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

    // Get All Team Members By Team ID
    function get_all_team_members_by_team_id($teamID){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return get_all_team_members_by_team_id_request($teamID);
    }

    // Create Account
    function create_agent_account($createAccountArray){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return create_agent_account_request($createAccountArray);
    }

    // Superuser Create Account
    function superuser_create_account($createAccountArray){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return superuser_create_account_request($createAccountArray);
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

    // Get Admin Or Accountant Account
    function get_admin_or_accountant_account($accountID){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return get_admin_or_accountant_account_request($accountID);
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

    // Check Password
    function check_password($accountID, $password){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return check_password_request($accountID, $password);
    }

    // Reset Password
    function reset_member_password($accountID, $password){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return reset_member_password_request($accountID, $password);
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

    // Get Admin And Account Member Brief Info
    function get_admin_and_account_member_brief_info($orderVariable){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return get_admin_and_account_member_brief_info_request($orderVariable);
    }

    // Update Account Email
    function update_account_email($accountID, $email){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return update_account_email_request($accountID, $email);
    }

    // Update Account Contact Number
    function update_contact_number($accountID, $contactNumber){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return update_contact_number_request($accountID, $contactNumber);
    }

    // Create Case
    function create_case($createCaseArray){
        require_once(__DIR__ . '/include/repository/case-repository.php');
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        $MLS = $createCaseArray['MLSNumber'];
        $createCaseResult = create_case_request($createCaseArray);
        if($createCaseResult === true){
            //Create All Services
            foreach (get_supplier_types() as $supplierType){
                $supplierResult = mysqli_fetch_array(get_default_supplier_by_type($supplierType));
                $supplierID = $supplierResult['SupplierID'];
                // Insert Service
                $createServiceArray = array(
                    "serviceSupplierID" => $supplierID,
                    "supplierType" => $supplierType
                );
                $createServiceResult = create_service_details($createServiceArray);
                $result_rows = [];
                while($row = mysqli_fetch_array($createServiceResult))
                {
                    $result_rows[] = $row;
                }
                $serviceID = $result_rows[0]["LAST_INSERT_ID()"];

                // Insert Case-Service
                $caseCaseServiceArray = array(
                    "MLS" => $MLS,
                    "serviceID" => $serviceID,
                    "serviceSupplierType" => $supplierType
                );
                $createCaseServiceResult = create_case_service_details($caseCaseServiceArray);
            }
        }
        return $createCaseResult;
    }

    // Get Cases Brief Info
    function get_cases_brief_info($agentAccountID){
        require_once(__DIR__ . '/include/repository/case-repository.php');
        return get_cases_brief_info_request($agentAccountID);
    }

    // Get Case By ID
    function get_case_by_id($MLS){
        require_once(__DIR__ . '/include/repository/case-repository.php');
        return get_case_by_id_request($MLS);
    }

    // Update Case
    function update_case($updateCaseArray){
        require_once(__DIR__ . '/include/repository/case-repository.php');
        return update_case_request($updateCaseArray);
    }

    // Get All Case Services ID
    function get_all_case_services_by_MLS($MLS){
        require_once(__DIR__ . '/include/repository/case-service-repository.php');
        return get_all_case_services_by_MLS_request($MLS);
    }

    // Create Case Service
    function create_case_service_details($caseCaseServiceArray){
        require_once(__DIR__ . '/include/repository/case-service-repository.php');
        return create_case_service_details_request($caseCaseServiceArray);
    }

    // Get Service Details
    function get_service_details_by_id($serviceID){
        require_once(__DIR__ . '/include/repository/service-repository.php');
        return get_service_details_by_id_request($serviceID);
    }

    // Update Service Details
    function update_service_details($serviceArray){
        require_once(__DIR__ . '/include/repository/service-repository.php');
        return update_service_details_request($serviceArray);
    }

    // Delete Service By ID
    function delete_service_and_case_service_by_id($serviceID){
        // Delete Service By ID
        require_once(__DIR__ . '/include/repository/service-repository.php');
        $deleteServiceResult = delete_service_by_id_request($serviceID);
        // Delete Case Service By ID
        require_once(__DIR__ . '/include/repository/case-service-repository.php');
        return delete_case_service_by_id_request($serviceID);
    }

    // Create Service Details
    function create_service_details($createServiceArray){
        require_once(__DIR__ . '/include/repository/service-repository.php');
        return create_service_details_request($createServiceArray);
    }


?>