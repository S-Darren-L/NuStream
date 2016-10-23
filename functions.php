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
            "You have registered with NuStream successfully. Your password is " . $password .
            ". To change your password, visit the following address: http://www.nustreamtoronto.com/ \r\n \r\n" .
            "sincerely,  \r\n " . "NuStream";
        $headers = 'From: NuStream';

        $sendEmailResult = mail($to, $subject, $message, $headers);
        return $sendEmailResult;
    }

    // Send User New Password By Email
    function send_user_new_password($email, $firstName, $lastName,$password){
        $to = $email;
        $subject = 'NuStream New Password';
        $message = 'Hello ' . $firstName . " " . $lastName . ", \r\n \r\n" .
            "Your new password is " . $password .
            ". To change your password, visit the following address: http://www.nustreamtoronto.com/ \r\n \r\n" .
            "sincerely,  \r\n " . "NuStream";
        $headers = 'From: NuStream';

        $sendEmailResult = mail($to, $subject, $message, $headers);
        return $sendEmailResult;
    }

    //Demo
    // Combine Files
    function combine_files()
    {
        require_once('fpdf/fpdf.php');
        require_once('fpdi/fpdi.php');

        // Set URL
        $homeURL = get_home_url();

        $pdf = new FPDI();

        $pdf->setSourceFile("C:\Users\Darren\Desktop\9408110466.pdf");
        $tplIdxA = $pdf->importPage(1, '/MediaBox');

        $pdf->setSourceFile("C:\Users\Darren\Desktop\generatedPDF.pdf");
        $tplIdxB = $pdf->importPage(1, '/MediaBox');

        $pdf->addPage();
        // place the imported page of the first document:
        $pdf->useTemplate($tplIdxA, 0, 0, 200, 280);
        $pdf->addPage();
        // place the imported page of the snd document:
        $pdf->useTemplate($tplIdxB, 0, 0, 200, 280);

        $uploadPath = "wp-content/themes/NuStream/Upload/";
        $filename = $uploadPath . "test.pdf";
        $pdf->Output($filename, 'F');
        //        $pdf->Output();
    }

    // Combine Case Report Invoices
    function combine_case_report_invoices($reportInvoicesArray, $MLS){
        foreach ($reportInvoicesArray as  $reportInvoiceKey => $reportInvoiceFile) {
            if(!empty($reportInvoiceFile)){
                $reportInvoiceFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . $reportInvoiceFile;
//                $reportInvoiceFile = strtolower($reportInvoiceFile);
                $allowedImagesType =  array('png' ,'jpg');
                $allowedFilesType ='pdf';
                $ext = pathinfo($reportInvoiceFile, PATHINFO_EXTENSION);
                if(in_array($ext, $allowedImagesType)){
                    // Convert Image to PDF
                    $reportInvoiceFile = convert_image_to_pdf($reportInvoiceFile, $MLS);
                    $reportInvoicesArray[$reportInvoiceKey] = $reportInvoiceFile;
                }else if($ext === $allowedFilesType){
                    // Is PDF File, Do Nothing
                }else{
                    // TODO: File Type Is Not Supported
                }
            }
        }
        try {
            $reportInvoicesFile = combine_pdf_array($reportInvoicesArray, $MLS);
            // If Succeed, Remove Temp Files
            if(!is_null($reportInvoiceFile)){
                try {
                    remove_temp_files($reportInvoicesArray);
                }
                catch (Exception $e){

                }
            }
        }catch(Exception $e) {
//            echo "Unable combine all PDFs, some file types are not supported";
        }
        return $reportInvoicesFile;
    }

    // Remove Temp Files
    function remove_temp_files($reportInvoicesArray){
        foreach ($reportInvoicesArray as $reportInvoiceKey => $reportInvoiceFile) {
            if (!is_null($reportInvoiceFile)) {
                $removeBool = unlink($reportInvoiceFile);
            }
        }
    }

    // Combine PDF Array
    function combine_pdf_array($reportInvoicesArray, $MLS){
        require_once('fpdf/fpdf.php');
        require_once('fpdi/fpdi.php');

        $pdf = new FPDI();
        foreach ($reportInvoicesArray as $reportInvoiceKey => $reportInvoiceFile) {
            $reportInvoiceFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . $reportInvoiceFile;
            $pdf->setSourceFile($reportInvoiceFile);
            $tplIdxA = $pdf->importPage(1, '/MediaBox');
            $pdf->addPage();
            // place the imported page of the first document:
            $pdf->useTemplate($tplIdxA,0,0,200,280);
        }
        $uploadPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . "Upload" . DIRECTORY_SEPARATOR . "case" . DIRECTORY_SEPARATOR . $MLS . DIRECTORY_SEPARATOR . "finalReport" . DIRECTORY_SEPARATOR;
        if(!is_dir($uploadPath)){
            mkdir($uploadPath, 0777, true);
        }
//        $uploadPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . "Upload" . DIRECTORY_SEPARATOR;
        $filename = $uploadPath . "combine_file_array.pdf";
        $pdf->Output($filename,'F');
        return $filename;
    }

    // Convert Image To PDF
    function convert_image_to_pdf($image, $MLS){
        require_once('fpdf/fpdf.php');
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image($image,10,10,180,280);
        $uploadPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . "Upload" . DIRECTORY_SEPARATOR . "case" . DIRECTORY_SEPARATOR . $MLS . DIRECTORY_SEPARATOR . "finalReport" . DIRECTORY_SEPARATOR;
        if(!is_dir($uploadPath)){
            mkdir($uploadPath, 0777, true);
        }
//        $uploadPath = "wp-content/themes/NuStream/Upload/";
        $filename = $uploadPath . rand(10000, 99999) . rand(10000, 99999) . ".pdf";
        $pdf->Output($filename,'F');
        return $filename;
    }

    // Generate Case Report
    function generate_case_report($reportFromArray, $reportInvoicesArray){
        // Generate Case Report Form
        $reportFormFile = generate_case_report_from($reportFromArray);
        $reportInvoicesArray['reportFormFile'] = $reportFormFile;

        $reportInvoicesFile = combine_case_report_invoices($reportInvoicesArray, $reportFromArray['MLS']);
    }

    // Generate Case Report Form
    function generate_case_report_from($reportFromArray){
        $MLS = $reportFromArray['MLS'];
        $address = $reportFromArray['address'];
        $teamLeader = $reportFromArray['teamLeader'];
        $teamMember = $reportFromArray['teamMember'];
        $propertyType = $reportFromArray['propertyType'];
        $sellingListingRate = $reportFromArray['sellingListingRate'];
        $listingPrice = $reportFromArray['listingPrice'];
        $stagingSupplier = $reportFromArray['stagingSupplier'];
        $stagingFinalPrice = $reportFromArray['stagingFinalPrice'];
        $cleanUpSupplier = $reportFromArray['cleanUpSupplier'];
        $cleanUpFinalPrice = $reportFromArray['cleanUpFinalPrice'];
        $touchUpSupplier = $reportFromArray['touchUpSupplier'];
        $touchUpFinalPrice = $reportFromArray['touchUpFinalPrice'];
        $inspectionSupplier = $reportFromArray['inspectionSupplier'];
        $inspectionFinalPrice = $reportFromArray['inspectionFinalPrice'];
        $yardWorkSupplier = $reportFromArray['yardWorkSupplier'];
        $yardWorkFinalPrice = $reportFromArray['yardWorkFinalPrice'];
        $storageSupplier = $reportFromArray['storageSupplier'];
        $storageFinalPrice = $reportFromArray['storageFinalPrice'];
        $relocateHomeSupplier = $reportFromArray['relocateHomeSupplier'];
        $relocateHomeFinalPrice = $reportFromArray['relocateHomeFinalPrice'];
        $totalCost = $reportFromArray['totalCost'];

        // Set URL
        $homeURL = get_home_url();
        $mainPath = $homeURL . "/wp-content/themes/NuStream/";
        $tableImagePath = $mainPath . "img/tablePageTitle.jpg";

        require_once('tcpdf/tcpdf.php');

// create new PDF document
//        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $custom_layout = array(350, 300);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $custom_layout, true, 'UTF-8', false);

// set document information
//        $pdf->SetCreator(PDF_CREATOR);
//        $pdf->SetAuthor('Nicola Asuni');
//        $pdf->SetTitle('TCPDF Example 001');
//        $pdf->SetSubject('TCPDF Tutorial');
//        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//        $pdf->SetHeaderData($tableImagePath, PDF_HEADER_LOGO_WIDTH, '', '', array(0,64,255), array(0,64,128));
//        $pdf->setFooterData(array(0,64,0), array(0,64,128));

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
//        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

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
        $pdf->SetFont('aealarabiya', '', 6, '', false);

// Add a page
// This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

// set text shadow effect
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
        $html = <<<EOD
<!DOCTYPE html>
<style>
	.title {
		width:800px;
		margin:0 auto;
	}
	.title img {
		width: 100%;
	}

	.tablePart table {
		text-align: center;
		border:1px #000 solid;
		width:800px;
		margin:0 auto;
	}
</style>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="http://cdn.static.runoob.com/libs/angular.js/1.4.6/angular.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
	</head>
	<body>
		<!--<div class="title"><img src="$tableImagePath"></div>-->
		<div class="tablePart">
			<table border="1">
				<tr>
					<th colspan="12" style="text-align: center;">Part 1: Basic information</th>
				</tr>
				<tr>
					<td style="width:67px;" colspan="1">MLS#</td>
					<td style="width:733px;" colspan="11">$MLS</td>
				</tr>
				<tr>
					<td style="width:67px;" colspan="1">Address</td>
					<td style="width:733px;" colspan="11">$address</td>
				</tr>
				<tr>
					<td style="width:134px;" colspan="2">Team&nbsp;Leader</td>
					<td style="width:266px;" colspan="4">$teamLeader</td>
					<td style="width:134px;" colspan="2">Team&nbsp;Member</td>
					<td style="width:266px;" colspan="4">$teamMember</td>
				</tr>
				<tr>
					<td tyle="width:134px;" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Propety&nbsp;Type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td style="width:266px;" colspan="4">$propertyType</td>
					<td ctyle="width:134px;" colspan="2">Selling Listing Rate</td>
					<td style="width:266px;" colspan="4">$sellingListingRate %</td>
				</tr>
				<tr>
					<td tyle="width:134px;" colspan="2">Listing&nbsp;Price</td>
					<td style="width:266px;" colspan="4">$listingPrice</td>
				</tr>
				<tr>
					<th colspan="12" style="text-align: center;">Part 2:Group Expense</th>
				</tr>
				<tr style=" font-weight:bold;">
					<td colspan="4">Item</td>
					<td colspan="4">Supplier</td>
					<td colspan="4">Price</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:left;">Staging Service </td>
					<td colspan="4">$stagingSupplier</td>
					<td colspan="4">$stagingFinalPrice</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:left;">Clean up service</td>
					<td colspan="4">$cleanUpSupplier</td>
					<td colspan="4">$cleanUpFinalPrice</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:left;">Touch up service</td>
					<td colspan="4">$touchUpSupplier</td>
					<td colspan="4">$touchUpFinalPrice</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:left;">Inspection</td>
					<td colspan="4">$inspectionSupplier</td>
					<td colspan="4">$inspectionFinalPrice</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:left;">Yardwork</td>
					<td colspan="4">$yardWorkSupplier</td>
					<td colspan="4">$yardWorkFinalPrice</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:left;">Storage</td>
					<td colspan="4">$storageSupplier</td>
					<td colspan="4">$storageFinalPrice</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:left;">Relocation home </td>
					<td colspan="4">$relocateHomeSupplier</td>
					<td colspan="4">$relocateHomeFinalPrice</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:left; font-weight:bold;">Total Cost</td>
					<td colspan="8">$totalCost</td>
				</tr>
			</table>
		</div>

	</body>
</html>
EOD;

// Print text using writeHTMLCell()
        $pdf->writeHTMLCell(100,280,10,10, $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.

        $uploadPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . "Upload" . DIRECTORY_SEPARATOR . "case" . DIRECTORY_SEPARATOR . $MLS . DIRECTORY_SEPARATOR . "finalReport" . DIRECTORY_SEPARATOR;
        if(!is_dir($uploadPath)){
            mkdir($uploadPath, 0777, true);
        }
        $filename = $uploadPath . "generatedPDF.pdf";
        ob_clean();
        $pdf->Output($filename,'F');
        return $filename;
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

    // Get Case Statuses
    function get_case_statuses(){
        $caseStatuses = array(
            'OPEN',
            'FIRMDEAL',
            'CLOSED'
        );
        return $caseStatuses;
    }

    // Get Invoice Statuses
    function get_invoice_statuses(){
        $invoiceStatuses = array(
            'NEW',
            'PENDING',
            'APPROVED'
        );
        return $invoiceStatuses;
    }

    // Test Input
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Download File
    function download_file($fileName){
        if(file_exists($fileName) && is_readable($fileName)){
            $size = filesize($fileName);
            header('Content-Type: application/octet-stream');
            header('Content-Length: ' . $size);
            header('Content-Disposition: attachment; filename=' . $fileName);
            header('Content-Transfer_Encoding: binary');

            // Open The File In Binary Read-Only Mode
            $file = @ fopen($fileName, 'rb');
            if($file){
                // Stream The File And Exit
                fpassthru($file);
                exit;
            }
        }
    }

    // Generate Zip File
    function create_zip($uploadPath) {
        $zip_file = 'Final Report.zip';

        // Get real path for our folder
        $rootPath = realpath($uploadPath);

        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Zip archive will be created only after closing object
        $zip->close();


        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($zip_file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($zip_file));
        readfile($zip_file);
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

    // Get Supplier Name By Id
    function get_supplier_name_by_id($supplierID){
        require_once(__DIR__ . '/include/repository/supplier-repository.php');
        return get_supplier_name_by_id_request($supplierID);
    }

    // Set File Path And Name
    function set_file_path_and_name($uploadPath, $uploadName){
        require_once(__DIR__ . '/include/repository/file-repository.php');
        return set_file_path_and_name_request($uploadPath, $uploadName);
    }

    // Get All Images
    function download_all_files_by_path($uploadPath){
        require_once(__DIR__ . '/include/repository/file-repository.php');
        return download_all_files_by_path_request($uploadPath);
    }

    // Get File
    function download_file_by_path($uploadPath){
        require_once(__DIR__ . '/include/repository/file-repository.php');
        return download_file_by_path_request($uploadPath);
    }

    // Remove FIle By Name
    function remove_file_by_name($fileName){
        require_once(__DIR__ . '/include/repository/file-repository.php');
        return remove_file_by_name_request($fileName);
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

    // Forget Password
    function forget_password($forgetPasswordArray){
        require_once(__DIR__ . '/include/repository/account-repository.php');
        return forget_password_request($forgetPasswordArray);
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

                // Update Case Service ID
                $updateCaseServiceIDArray = array(
                    "MLS" => $MLS,
                    "serviceID" => $serviceID,
                    "serviceSupplierType" => $supplierType
                );
                $createCaseServiceResult = update_case_service_id($updateCaseServiceIDArray);
            }
        }
        return $createCaseResult;
    }

    // Check If MLS Exist
    function is_MLS_exist($MLS){
        require_once(__DIR__ . '/include/repository/case-repository.php');
        return is_MLS_exist_request($MLS);
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

    // Get Case By Service Type And ID
    function get_case_by_service_type_and_id($serviceType, $serviceID){
        require_once(__DIR__ . '/include/repository/case-repository.php');
        return get_case_by_service_type_and_id_request($serviceType, $serviceID);
    }

    // Get All Closed Cases
    function get_all_closed_cases(){
        require_once(__DIR__ . '/include/repository/case-repository.php');
        return get_all_closed_cases_request();
    }

    // Update Case Status And Final Price
    function update_case_status_and_final_price($MLS, $totalCost, $caseStatus){
        require_once(__DIR__ . '/include/repository/case-repository.php');
        return update_case_status_and_final_price_request($MLS, $totalCost, $caseStatus);
    }

    // Update Case Service ID
    function update_case_service_id($updateCaseServiceIDArray){
        require_once(__DIR__ . '/include/repository/service-repository.php');
        return update_case_service_id_request($updateCaseServiceIDArray);
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
    function delete_service_by_id($serviceID){
        // Delete Service By ID
        require_once(__DIR__ . '/include/repository/service-repository.php');
        return delete_service_by_id_request($serviceID);
    }

    // Create Service Details
    function create_service_details($createServiceArray){
        require_once(__DIR__ . '/include/repository/service-repository.php');
        return create_service_details_request($createServiceArray);
    }

    // Get All Services By Status
    function get_all_services_with_file_by_status($serviceStatus){
        require_once(__DIR__ . '/include/repository/service-repository.php');
        return get_all_services_with_file_by_status_request($serviceStatus);
    }

    // Update Service Invoice
    function update_service_invoice($serviceID, $uploadPath){
        require_once(__DIR__ . '/include/repository/service-repository.php');
        return update_service_invoice_request($serviceID, $uploadPath);
    }

    // Update Service Image
    function update_service_image($serviceID, $uploadPath){
        require_once(__DIR__ . '/include/repository/service-repository.php');
        return update_service_image_request($serviceID, $uploadPath);
    }

    // Update Service Status
    function update_service_status($serviceID, $invoiceStatus){
        require_once(__DIR__ . '/include/repository/service-repository.php');
        return update_service_status_request($serviceID, $invoiceStatus);
    }

?>