<?php

    // Start Session
    session_start();

    /*
    Template Name: Agent Mobile Case File Upload
    */

    // Get Case ID
    $MLS = $_GET['CID'];
    $isRefreshPage = $_GET['RF'];
    $uploadBasePath = "wp-content/themes/NuStream/Upload/case/" . $MLS;
    $PageURL = get_home_url() . '/agent-mobile-case-file-upload';
    $houseImageURL =  get_home_url() . "/wp-content/themes/NuStream/Upload/case/" . $MLS . "/HouseImage/";
    $defaultHouseImageURL =  get_home_url() . "/wp-content/themes/NuStream/img/house.jpg";

    // Init Date
    // Get Case Statuses
    $caseStatuses = get_case_statuses();

    // Get Case Basic Details
    $caseDetailsArray = array();
    $caseDetailsArray = get_case_basic_details($MLS);

    // Get All Services Info
    $stagingServiceArray = array();
    $stagingServiceArray = get_service_detail($caseDetailsArray['StagingID']);
    $touchUpServiceArray = array();
    $touchUpServiceArray = get_service_detail($caseDetailsArray['TouchUpID']);
    $cleanUpServiceArray = array();
    $cleanUpServiceArray = get_service_detail($caseDetailsArray['CleanUpID']);
    $yardWorkServiceArray = array();
    $yardWorkServiceArray = get_service_detail($caseDetailsArray['YardWorkID']);
    $inspectionServiceArray = array();
    $inspectionServiceArray = get_service_detail($caseDetailsArray['InspectionID']);
    $storageServiceArray = array();
    $storageServiceArray = get_service_detail($caseDetailsArray['StorageID']);
    $relocateHomeServiceArray = array();
    $relocateHomeServiceArray = get_service_detail($caseDetailsArray['RelocateHomeID']);
    $photographyServiceArray = array();
    $photographyServiceArray = get_service_detail($caseDetailsArray['PhotographyID']);

    // Get All Files
    $stagingImageFilesArray = get_staging_files();
    $cleanUpImageFilesArray = get_clean_up_files();
    $touchUpImageFilesArray = get_touch_up_files();
    $yardWorkImageFilesArray = get_yard_work_files();
    $inspectionImageFilesArray = get_inspection_files();
    $storageImageFilesArray = get_storage_files();
    $relocateHomeImageFilesArray = get_relocate_home_files();
    $stagingImageFilesArray = get_staging_files();

    // Get Case Basic Details
    function get_case_basic_details($MLS){
        $getCaseResult = get_case_by_id($MLS);
        if($getCaseResult !== null){
            $caseDetailsArray = mysqli_fetch_array($getCaseResult);
        }
        else{
            echo die("Cannot find account");
        }
        $getCoStaffResult = get_agent_account($caseDetailsArray['CoStaffID']);
        if($getCoStaffResult !== null){
            $coStaffArray = mysqli_fetch_array($getCoStaffResult);
            $caseDetailsArray['CoStaffName'] = $coStaffArray['FirstName'] . " " . $coStaffArray['LastName'];
        }
        return $caseDetailsArray;
    }

    // Get Service Details By ID
    function get_service_detail($serviceID){
        global $isRefreshPage;
        $serviceDetailsResult = get_service_details_by_id($serviceID);
        $serviceDetailsArray = mysqli_fetch_array($serviceDetailsResult);
        $isActive = $isRefreshPage === "1" ? $_SESSION['CaseEstimate'][$serviceID]['isServiceChecked'] : $serviceDetailsArray['IsActivate'];
        $serviceDetailsArray['IsChecked'] = $isActive === 'checked' ? 'checked' : null;
        $serviceDetailsArray['IsDisabled'] = $serviceDetailsArray['InvoiceStatus'] === 'APPROVED' ? 'disabled' : null;
        if($isRefreshPage === '1'){
            $serviceDetailsArray['ServiceSupplierID'] = $_SESSION['CaseEstimate'][$serviceID]['supplierID'];
            $serviceDetailsArray['RealCost'] = $_SESSION['CaseEstimate'][$serviceID]['serviceRealCost'];
        }
        return $serviceDetailsArray;
    }

    // Get All Files
    function get_staging_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/Staging/";
        $stagingImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/")),
            "BeforeLivingRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "LivingRoom/")),
            "BeforeDinningRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "DinningRoom/")),
            "BeforeMasterRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "MasterRoom/")),
            "AfterLivingRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "LivingRoom/")),
            "AfterDinningRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "DinningRoom/")),
            "AfterMasterRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "MasterRoom/"))
        );
        return $stagingImageFilesArray;
    }
    function get_clean_up_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/CleanUp/";
        $cleanUpImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/")),
            "BeforeLivingRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "LivingRoom/")),
            "BeforeKitchen" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "Kitchen/")),
            "BeforeWashRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "WashRoom/")),
            "AfterLivingRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "LivingRoom/")),
            "AfterKitchen" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "Kitchen/")),
            "AfterWashRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "WashRoom/"))
        );
        return $cleanUpImageFilesArray;
    }
    function get_touch_up_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/TouchUp/";
        $touchUpImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/")),
            "Before1" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "1/")),
            "Before1" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "2/")),
            "Before3" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "3/")),
            "Before4" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "4/")),
            "Before5" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "5/")),
            "After1" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "1/")),
            "After2" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "2/")),
            "After3" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "3/")),
            "After4" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "4/")),
            "After5" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "5/"))
        );
        return $touchUpImageFilesArray;
    }
    function get_yard_work_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/YardWork/";
        $yardWorkImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/")),
            "BeforeFrontYard" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "FrontYard/")),
            "BeforeBackYard" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "BackYard/")),
            "AfterFrontYard" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "FrontYard/")),
            "AfterBackYard" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "BackYard/"))
        );
        return $yardWorkImageFilesArray;
    }
    function get_inspection_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/Inspection/";
        $inspectionImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/")),
            "Report" => mysqli_fetch_array(download_file_by_path($uploadPath . "Report/"))
        );
        return $inspectionImageFilesArray;
    }
    function get_storage_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/Storage/";
        $storageImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/"))
        );
        return $storageImageFilesArray;
    }
    function get_relocate_home_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/RelocateHome/";
        $relocateHomeImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/"))
        );
        return $relocateHomeImageFilesArray;
    }

    // Upload File
    function upload_file($uploadPath, $uploadTmp, $uploadName){
        if(!is_dir($uploadPath)){
            mkdir($uploadPath, 0777, true);
        }

        if (!$uploadTmp) {
            die("No File Selected, Please Upload Again.");
        } else {
            $uploadResult = move_uploaded_file($uploadTmp, $uploadPath . $uploadName);
        }

        if($uploadResult){
            $setFilePathAndNameResult = set_file_path_and_name($uploadPath, $uploadName);
        }
    }

    // Remove File
    function remove_file($dir, $fileName){
        if(!is_null($fileName)){
            if (is_dir($dir)) {
                $objects = scandir($dir);
                foreach ($objects as $object) {
                    if ($object != "." && $object != "..") {
                        if (filetype($dir."/".$object) == "dir")
                            rrmdir($dir."/".$object);
                        else unlink   ($dir."/".$object);
                    }
                }
                reset($objects);
                rmdir($dir);
            }
            $removeFileResult = remove_file_by_name($fileName);
        }
    }

    // Upload Staging
    if(isset($_POST['submit_staging'])){
        global $PageURL;
        $serviceID = $stagingServiceArray['ServiceID'];
        $uploadPath = $uploadBasePath . "/Staging/";

        $invoiceUploadTmp = $_FILES['upload_staging_invoice']['tmp_name'];
        $invoiceUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_staging_invoice']['name']);

        $beforeLivingRoomUploadTmp = $_FILES['upload_staging_before_living_room']['tmp_name'];
        $beforeLivingRoomUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_staging_before_living_room']['name']);

        $beforeDinningRoomUploadTmp = $_FILES['upload_staging_before_dinning_room']['tmp_name'];
        $beforeDinningRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_staging_before_dinning_room']['name']);

        $beforeMasterRoomUploadTmp = $_FILES['upload_staging_before_master_room']['tmp_name'];
        $beforeMasterRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_staging_before_master_room']['name']);

        $afterLivingRoomUploadTmp = $_FILES['upload_staging_after_living_room']['tmp_name'];
        $afterLivingRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_staging_after_living_room']['name']);

        $afterDinningRoomUploadTmp = $_FILES['upload_staging_after_dinning_room']['tmp_name'];
        $afterDinningRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_staging_after_dinning_room']['name']);

        $afterMasterRoomUploadTmp = $_FILES['upload_staging_after_master_room']['tmp_name'];
        $afterMasterRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_staging_after_master_room']['name']);

        if(!empty($invoiceUploadTmp)){
            remove_file($stagingImageFilesArray['Invoice']["FilePath"], $stagingImageFilesArray['Invoice']["FileName"]);
            upload_file($uploadPath . "Invoice/", $invoiceUploadTmp, $invoiceUploadName);
        }
        if(!empty($beforeLivingRoomUploadTmp)){
            remove_file($stagingImageFilesArray['BeforeLivingRoom']["FilePath"], $stagingImageFilesArray['BeforeLivingRoom']["FileName"]);
            upload_file($uploadPath . "Before/" . "LivingRoom/", $beforeLivingRoomUploadTmp, $beforeLivingRoomUploadName);
        }
        if(!empty($beforeDinningRoomUploadTmp)){
            remove_file($stagingImageFilesArray['BeforeDinningRoom']["FilePath"], $stagingImageFilesArray['BeforeDinningRoom']["FileName"]);
            upload_file($uploadPath . "Before/" . "DinningRoom/", $beforeDinningRoomUploadTmp, $beforeDinningRoomUploadName);
        }
        if(!empty($beforeMasterRoomUploadTmp)){
            remove_file($stagingImageFilesArray['BeforeMasterRoom']["FilePath"], $stagingImageFilesArray['BeforeMasterRoom']["FileName"]);
            upload_file($uploadPath . "Before/" . "MasterRoom/", $beforeMasterRoomUploadTmp, $beforeMasterRoomUploadName);
        }
        if(!empty($afterLivingRoomUploadTmp)){
            remove_file($stagingImageFilesArray['AfterLivingRoom']["FilePath"], $stagingImageFilesArray['AfterLivingRoom']["FileName"]);
            upload_file($uploadPath . "After/" . "LivingRoom/", $afterLivingRoomUploadTmp, $afterLivingRoomUploadName);
        }
        if(!empty($afterDinningRoomUploadTmp)){
            remove_file($stagingImageFilesArray['AfterDinningRoom']["FilePath"], $stagingImageFilesArray['AfterDinningRoom']["FileName"]);
            upload_file($uploadPath . "After/" . "DinningRoom/", $afterDinningRoomUploadTmp, $afterDinningRoomUploadName);
        }
        if(!empty($afterMasterRoomUploadTmp)) {
            remove_file($stagingImageFilesArray['AfterMasterRoom']["FilePath"], $stagingImageFilesArray['AfterMasterRoom']["FileName"]);
            upload_file($uploadPath . "After/" . "MasterRoom/", $afterMasterRoomUploadTmp, $afterMasterRoomUploadName);
        }

        $updateServiceInvoiceResult = update_service_invoice($serviceID, $uploadPath . "Invoice/");
        $updateServiceImageResult = update_service_image($serviceID, $uploadPath);
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }

    if(isset($_POST['submit_clean_up'])){
        global $PageURL;
        $serviceID = $cleanUpServiceArray['ServiceID'];
        $uploadPath = $uploadBasePath . "/CleanUp/";

        $invoiceUploadTmp = $_FILES['upload_clean_up_invoice']['tmp_name'];
        $invoiceUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_clean_up_invoice']['name']);

        $beforeLivingRoomUploadTmp = $_FILES['upload_clean_up_before_living_room']['tmp_name'];
        $beforeLivingRoomUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_clean_up_before_living_room']['name']);

        $beforeKitchenUploadTmp = $_FILES['upload_clean_up_before_kitchen']['tmp_name'];
        $beforeKitchenUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_clean_up_before_kitchen']['name']);

        $beforeWashRoomUploadTmp = $_FILES['upload_clean_up_before_wash_room']['tmp_name'];
        $beforeWashRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_clean_up_before_wash_room']['name']);

        $afterLivingRoomUploadTmp = $_FILES['upload_clean_up_after_living_room']['tmp_name'];
        $afterLivingRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_clean_up_after_living_room']['name']);

        $afterKitchenRoomUploadTmp = $_FILES['upload_clean_up_after_kitchen']['tmp_name'];
        $afterKitchenRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_clean_up_after_kitchen']['name']);

        $afterWashRoomUploadTmp = $_FILES['upload_clean_up_after_wash_room']['tmp_name'];
        $afterWashRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_clean_up_after_wash_room']['name']);

        if(!empty($invoiceUploadTmp)){
            remove_file($cleanUpImageFilesArray['Invoice']["FilePath"], $cleanUpImageFilesArray['Invoice']["FileName"]);
            upload_file($uploadPath . "Invoice/", $invoiceUploadTmp, $invoiceUploadName);
        }
        if(!empty($beforeLivingRoomUploadTmp)){
            remove_file($cleanUpImageFilesArray['BeforeLivingRoom']["FilePath"], $cleanUpImageFilesArray['BeforeLivingRoom']["FileName"]);
            upload_file($uploadPath . "Before/" . "LivingRoom/", $beforeLivingRoomUploadTmp, $beforeLivingRoomUploadName);
        }
        if(!empty($beforeKitchenUploadTmp)){
            remove_file($cleanUpImageFilesArray['BeforeKitchen']["FilePath"], $cleanUpImageFilesArray['BeforeKitchen']["FileName"]);
            upload_file($uploadPath . "Before/" . "Kitchen/", $beforeKitchenUploadTmp, $beforeKitchenUploadName);
        }
        if(!empty($beforeWashRoomUploadTmp)){
            remove_file($cleanUpImageFilesArray['BeforeWashRoom']["FilePath"], $cleanUpImageFilesArray['BeforeWashRoom']["FileName"]);
            upload_file($uploadPath . "Before/" . "WashRoom/", $beforeWashRoomUploadTmp, $beforeWashRoomUploadName);
        }
        if(!empty($afterLivingRoomUploadTmp)){
            remove_file($cleanUpImageFilesArray['AfterLivingRoom']["FilePath"], $cleanUpImageFilesArray['AfterLivingRoom']["FileName"]);
            upload_file($uploadPath . "After/" . "LivingRoom/", $afterLivingRoomUploadTmp, $afterLivingRoomUploadName);
        }
        if(!empty($afterKitchenRoomUploadTmp)){
            remove_file($cleanUpImageFilesArray['AfterKitchen']["FilePath"], $cleanUpImageFilesArray['AfterKitchen']["FileName"]);
            upload_file($uploadPath . "After/" . "Kitchen/", $afterKitchenRoomUploadTmp, $afterKitchenRoomUploadName);
        }
        if(!empty($afterWashRoomUploadTmp)) {
            remove_file($cleanUpImageFilesArray['AfterWashRoom']["FilePath"], $cleanUpImageFilesArray['AfterWashRoom']["FileName"]);
            upload_file($uploadPath . "After/" . "WashRoom/", $afterWashRoomUploadTmp, $afterWashRoomUploadName);
        }

        $updateServiceInvoiceResult = update_service_invoice($serviceID, $uploadPath . "Invoice/");
        $updateServiceImageResult = update_service_image($serviceID, $uploadPath);
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }

    if(isset($_POST['submit_touch_up'])){
        global $PageURL;
        $serviceID = $touchUpImageFilesArray['ServiceID'];
        $uploadPath = $uploadBasePath . "/TouchUp/";

        $invoiceUploadTmp = $_FILES['upload_touch_up_invoice']['tmp_name'];
        $invoiceUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_touch_up_invoice']['name']);

        $before1UploadTmp = $_FILES['upload_touch_up_before_1']['tmp_name'];
        $before1UploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_touch_up_before_1']['name']);

        $before2UploadTmp = $_FILES['upload_touch_up_before_2']['tmp_name'];
        $before2UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_before_2']['name']);

        $before3UploadTmp = $_FILES['upload_touch_up_before_3']['tmp_name'];
        $before3UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_before_3']['name']);

        $before4UploadTmp = $_FILES['upload_touch_up_before_4']['tmp_name'];
        $before4UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_before_4']['name']);

        $before5UploadTmp = $_FILES['upload_touch_up_before_5']['tmp_name'];
        $before5UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_before_5']['name']);

        $after1UploadTmp = $_FILES['upload_touch_up_after_1']['tmp_name'];
        $after1UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_after_1']['name']);

        $before2UploadTmp = $_FILES['upload_touch_up_after_2']['tmp_name'];
        $before2UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_after_2']['name']);

        $after3UploadTmp = $_FILES['upload_touch_up_after_3']['tmp_name'];
        $after3UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_after_3']['name']);

        $after4UploadTmp = $_FILES['upload_touch_up_after_4']['tmp_name'];
        $after4UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_after_4']['name']);

        $after5UploadTmp = $_FILES['upload_touch_up_after_5']['tmp_name'];
        $after5UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_after_5']['name']);

        if(!empty($invoiceUploadTmp)){
            remove_file($touchUpImageFilesArray['Invoice']["FilePath"], $touchUpImageFilesArray['Invoice']["FileName"]);
            upload_file($uploadPath . "Invoice/", $invoiceUploadTmp, $invoiceUploadName);
        }
        if(!empty($before1UploadTmp)){
            remove_file($touchUpImageFilesArray['Before1']["FilePath"], $touchUpImageFilesArray['Before1']["FileName"]);
            upload_file($uploadPath . "Before/" . "1/", $before1UploadTmp, $before1UploadName);
        }
        if(!empty($before2UploadTmp)){
            remove_file($touchUpImageFilesArray['Before2']["FilePath"], $touchUpImageFilesArray['Before2']["FileName"]);
            upload_file($uploadPath . "Before/" . "2/", $before2UploadTmp, $before2UploadName);
        }
        if(!empty($before3UploadTmp)){
            remove_file($touchUpImageFilesArray['Before3']["FilePath"], $touchUpImageFilesArray['Before3']["FileName"]);
            upload_file($uploadPath . "Before/" . "3/", $before3UploadTmp, $before3UploadName);
        }
        if(!empty($before4UploadTmp)){
            remove_file($touchUpImageFilesArray['Before4']["FilePath"], $touchUpImageFilesArray['Before4']["FileName"]);
            upload_file($uploadPath . "Before/" . "4/", $before4UploadTmp, $before4UploadName);
        }
        if(!empty($before5UploadTmp)){
            remove_file($touchUpImageFilesArray['Before5']["FilePath"], $touchUpImageFilesArray['Before5']["FileName"]);
            upload_file($uploadPath . "Before/" . "5/", $before5UploadTmp, $before5UploadName);
        }
        if(!empty($after1UploadTmp)) {
            remove_file($touchUpImageFilesArray['After1']["FilePath"], $touchUpImageFilesArray['After1']["FileName"]);
            upload_file($uploadPath . "After/" . "1/", $after1UploadTmp, $after1UploadName);
        }
        if(!empty($after2UploadTmp)){
            remove_file($touchUpImageFilesArray['After2']["FilePath"], $touchUpImageFilesArray['After2']["FileName"]);
            upload_file($uploadPath . "After/" . "2/", $after2UploadTmp, $after2UploadName);
        }
        if(!empty($after3UploadTmp)){
            remove_file($touchUpImageFilesArray['After3']["FilePath"], $touchUpImageFilesArray['After3']["FileName"]);
            upload_file($uploadPath . "After/" . "3/", $after3UploadTmp, $after3UploadName);
        }
        if(!empty($after4UploadTmp)){
            remove_file($touchUpImageFilesArray['After4']["FilePath"], $touchUpImageFilesArray['After4']["FileName"]);
            upload_file($uploadPath . "After/" . "4/", $after4UploadTmp, $after4UploadName);
        }
        if(!empty($after5UploadTmp)) {
            remove_file($touchUpImageFilesArray['After5']["FilePath"], $touchUpImageFilesArray['After5']["FileName"]);
            upload_file($uploadPath . "After/" . "5/", $after5UploadTmp, $after5UploadName);
        }

        $updateServiceInvoiceResult = update_service_invoice($serviceID, $uploadPath . "Invoice/");
        $updateServiceImageResult = update_service_image($serviceID, $uploadPath);
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }

    if(isset($_POST['submit_yard_work'])){
        global $PageURL;
        $serviceID = $yardWorkServiceArray['ServiceID'];
        $uploadPath = $uploadBasePath . "/YardWork/";

        $invoiceUploadTmp = $_FILES['upload_yard_work_invoice']['tmp_name'];
        $invoiceUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_yard_work_invoice']['name']);

        $beforeFrontYardUploadTmp = $_FILES['upload_yard_work_before_front']['tmp_name'];
        $beforeFrontYardUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_yard_work_before_front']['name']);

        $beforeBackYardUploadTmp = $_FILES['upload_yard_work_before_back']['tmp_name'];
        $beforeBackYardUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_yard_work_before_back']['name']);

        $afterFrontYardUploadTmp = $_FILES['upload_yard_work_after_front']['tmp_name'];
        $afterFrontYardUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_yard_work_after_front']['name']);

        $afterBackYardUploadTmp = $_FILES['upload_yard_work_after_back']['tmp_name'];
        $afterBackYardUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_yard_work_after_back']['name']);

        if(!empty($invoiceUploadTmp)){
            remove_file($cleanUpImageFilesArray['Invoice']["FilePath"], $cleanUpImageFilesArray['Invoice']["FileName"]);
            upload_file($uploadPath . "Invoice/", $invoiceUploadTmp, $invoiceUploadName);
        }
        if(!empty($beforeFrontYardUploadTmp)){
            remove_file($cleanUpImageFilesArray['BeforeFrontYard']["FilePath"], $yardWorkImageFilesArray['BeforeFrontYard']["FileName"]);
            upload_file($uploadPath . "Before/" . "FrontYard/", $beforeFrontYardUploadTmp, $beforeFrontYardUploadName);
        }
        if(!empty($beforeBackYardUploadTmp)){
            remove_file($cleanUpImageFilesArray['BeforeBackYard']["FilePath"], $yardWorkImageFilesArray['BeforeBackYard']["FileName"]);
            upload_file($uploadPath . "Before/" . "BackYard/", $beforeBackYardUploadTmp, $beforeBackYardUploadName);
        }
        if(!empty($afterFrontYardUploadTmp)){
            remove_file($cleanUpImageFilesArray['AfterFrontYard']["FilePath"], $yardWorkImageFilesArray['AfterFrontYard']["FileName"]);
            upload_file($uploadPath . "After/" . "FrontYard/", $afterFrontYardUploadTmp, $afterFrontYardUploadName);
        }
        if(!empty($afterBackYardUploadTmp)){
            remove_file($cleanUpImageFilesArray['AfterBackYard']["FilePath"], $yardWorkImageFilesArray['AfterBackYard']["FileName"]);
            upload_file($uploadPath . "After/" . "BackYard/", $afterBackYardUploadTmp, $afterBackYardUploadName);
        }

        $updateServiceInvoiceResult = update_service_invoice($serviceID, $uploadPath . "Invoice/");
        $updateServiceImageResult = update_service_image($serviceID, $uploadPath);
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }

    if(isset($_POST['submit_inspection'])){
        global $PageURL;
        $serviceID = $yardWorkServiceArray['ServiceID'];
        $uploadPath = $uploadBasePath . "/Inspection/";

        $reportUploadTmp = $_FILES['upload_inspection_report']['tmp_name'];
        $reportUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_inspection_report']['name']);

        $invoiceUploadTmp = $_FILES['upload_inspection_invoice']['tmp_name'];
        $invoiceUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_inspection_invoice']['name']);

        if(!empty($reportUploadTmp)){
            remove_file($inspectionImageFilesArray['Report']["FilePath"], $inspectionImageFilesArray['Report']["FileName"]);
            upload_file($uploadPath . "Report/", $reportUploadTmp, $reportUploadName);
        }
        if(!empty($invoiceUploadTmp)){
            remove_file($inspectionImageFilesArray['Invoice']["FilePath"], $inspectionImageFilesArray['Invoice']["FileName"]);
            upload_file($uploadPath . "Invoice/", $invoiceUploadTmp, $invoiceUploadName);
        }

        $updateServiceInvoiceResult = update_service_invoice($serviceID, $uploadPath . "Invoice/");
        $updateServiceImageResult = update_service_image($serviceID, $uploadPath . "Report/"); // For Report
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }

    if(isset($_POST['submit_storage'])) {
        global $PageURL;
        $serviceID = $storageImageFilesArray['ServiceID'];
        $uploadPath = $uploadBasePath . "/Storage/";

        $invoiceUploadTmp = $_FILES['upload_storage_invoice']['tmp_name'];
        $invoiceUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_storage_invoice']['name']);

        if(!empty($invoiceUploadTmp)){
            remove_file($storageImageFilesArray['Invoice']["FilePath"], $storageImageFilesArray['Invoice']["FileName"]);
            upload_file($uploadPath . "Invoice/", $invoiceUploadTmp, $invoiceUploadName);
        }

        $updateServiceInvoiceResult = update_service_invoice($serviceID, $uploadPath . "Invoice/");
        $updateServiceImageResult = update_service_image($serviceID, $uploadPath);
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }

    if (isset($_POST['submit_relocate_home'])) {
        global $PageURL;
        $serviceID = $relocateHomeImageFilesArray['ServiceID'];
        $uploadPath = $uploadBasePath . "/RelocateHome/";

        $invoiceUploadTmp = $_FILES['upload_relocate_home_invoice']['tmp_name'];
        $invoiceUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_relocate_home_invoice']['name']);

        if(!empty($invoiceUploadTmp)){
            remove_file($relocateHomeImageFilesArray['Invoice']["FilePath"], $relocateHomeImageFilesArray['Invoice']["FileName"]);
            upload_file($uploadPath . "Invoice/", $invoiceUploadTmp, $invoiceUploadName);
        }

        $updateServiceInvoiceResult = update_service_invoice($serviceID, $uploadPath . "Invoice/");
        $updateServiceImageResult = update_service_image($serviceID, $uploadPath);
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }
//    if(isset($_GET['back'])){
//        history.go(-1);
//    }

?>

<html>
<head>
    <title>Project</title>
    <script src="<?php bloginfo('template_url');?>/lib/jquery-3.1.1.min.js"></script>
    <script src="<?php bloginfo('template_url');?>/lib/angular-1.5.0/angular.js"></script>
    <script src="<?php bloginfo('template_url');?>/SiteScripts/App.js"></script>
    <script src="<?php bloginfo('template_url');?>/SiteScripts/MyController.js"></script>
    <script src="<?php bloginfo('template_url');?>/SiteScripts/Directives/UploadDirective.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/site.css">
</head>
<body>
    <div ng-app="App" ng-controller="myController">
        <div class="Back">
        </div>
        <div class="TopContainer">
            <div class="BackgroundGrey">
                <div>MLS#</div>
                <div><?php echo $caseDetailsArray['MLS'];?></div>
            </div>
            <div>
                <div>ADDRESS</div>
                <div><?php echo $caseDetailsArray['Address'];?></div>
            </div>
            <div class="BackgroundGrey">
                <div>PROPERTY TYPE</div>
                <div><?php echo $caseDetailsArray['PropertyType'];?>E</div>
            </div>
            <div>
                <div>LAND SIZE(LOT)</div>
                <div><?php echo $caseDetailsArray['LandSize'];?></div>
            </div>
            <div class="BackgroundGrey">
                <div>HOUSE SIZE(SQF)</div>
                <div><?php echo $caseDetailsArray['HouseSize'];?></div>
            </div>
            <div>
                <div>LISTING PRICE</div>
                <div><?php echo $caseDetailsArray['ListingPrice'];?></div>
            </div>
            <div class="BackgroundGrey">
                <div>OWNER'S NAME</div>
                <div><?php echo $caseDetailsArray['OwnerName'];?></div>
            </div>
            <div>
                <div>TEAM MEMBER'S NAME</div>
                <div><?php echo $caseDetailsArray['CoStaffName'];?></div>
            </div>
            <div class="BackgroundGrey">
                <div>SELLING LISTING RATE</div>
                <div><?php echo $caseDetailsArray['CommissionRate'] . "%";?></div>
            </div>
        </div>
        <div class="ButtonContainer">
            <ul>
                <li class="Button" ng-click="onStagingClick()">STAGING</li>
                <li class="Button" ng-click="onCleanupClick()">CLEAN UP</li>
                <li class="Button" ng-click="onTouchupClick()">TOUCH UP</li>
                <li class="Button" ng-click="onYardWorkClick()">YARD WORK</li>
            </ul>
            <ul>
                <li class="Button" ng-click="onInspectionClick()">INSPECTION</li>
                <li class="Button" ng-click="onStorageClick()">STORAGE</li>
                <li class="Button" ng-click="onRelocationClick()">RELOCATION</li>
            </ul>
        </div>

        <div class="StagingBar">
            <label>{{vm.Label}}</label>
            <div class="SAVE" ng-click="onSaveClick()">SAVE</div>
        </div>


        <div class="UploadContainer">
            <div ng-show="vm.showStaging" class="Staging">
                <form method="post" enctype="multipart/form-data" name="FileUploadFrom">
                    <label for="file-upload" class="custom-file-upload">
                        Upload
                    </label>
                    <input id="file-upload" type="file" accept="image/*;capture=camera" name="upload_staging_invoice" class="UploadInvoice"/>

                    <label class="BeforeAfterLabel">Before</label>
                    <label class="BeforeAfterLabel">After</label>
                    <upload name="upload_staging_before_living_room" label="LIVING ROOM"></upload>
                    <upload name="upload_staging_after_living_room" label="LIVING ROOM"></upload>
                    <upload name="upload_staging_before_dinning_room" label="DINING ROOM"></upload>

                    <upload name="upload_staging_after_dinning_room" label="DINING ROOM"></upload>
                    <upload name="upload_staging_before_master_room" label="MASTER ROOM"></upload>
                    <upload name="upload_staging_after_master_room" label="MASTER ROOM"></upload>
                    <input type="submit" style="display:none" name="submit_staging" class="SubmitButton" />
                </form>
            </div>

            <div ng-show="vm.showCleanup" class="Cleanup">
                <form method="post" enctype="multipart/form-data" name="FileUploadFrom">
                    <label for="file-upload1" class="custom-file-upload">
                        Upload
                    </label>
                    <input id="file-upload1" type="file" accept="image/*;capture=camera" name="upload_staging_invoice" class="UploadInvoice" />
                    <label class="BeforeAfterLabel">Before</label>
                    <label class="BeforeAfterLabel">After</label>
                    <upload name="upload_clean_up_before_living_room" label="LIVING ROOM"></upload>
                    <upload name="upload_clean_up_after_living_room" label="LIVING ROOM"></upload>
                    <upload name="upload_clean_up_before_kitchen" label="KITCHEN"></upload>
                    <upload name="upload_clean_up_after_kitchen" label="KITCHEN"></upload>
                    <upload name="upload_clean_up_before_wash_room" label="WASHROOM"></upload>
                    <upload name="upload_clean_up_after_wash_room" label="WASHROOM"></upload>
                    <input type="submit" style="display:none" name="submit_clean_up" class="SubmitButton" />
                </form>
            </div>

            <div ng-show="vm.showTouchup" class="Touchup">
                <form method="post" enctype="multipart/form-data" name="FileUploadFrom">
                    <label for="file-upload2" class="custom-file-upload">
                        Upload
                    </label>
                    <input id="file-upload2" type="file" accept="image/*;capture=camera" name="upload_staging_invoice" class="UploadInvoice" />
                    <label class="BeforeAfterLabel">Before</label>
                    <label class="BeforeAfterLabel">After</label>
                    <upload name="upload_touch_up_before_1" label=""></upload>
                    <upload name="upload_touch_up_after_1" label=""></upload>
                    <upload name="upload_touch_up_before_2" label=""></upload>
                    <upload name="upload_touch_up_after_2" label=""></upload>
                    <upload name="upload_touch_up_before_3" label=""></upload>
                    <upload name="upload_touch_up_after_3" label=""></upload>
                    <upload name="upload_touch_up_before_4" label=""></upload>
                    <upload name="upload_touch_up_after_4" label=""></upload>
                    <input type="submit" style="display:none" name="submit_touch_up" class="SubmitButton" />
                </form>
            </div>

            <div ng-show="vm.showYardWork" class="YardWork">
                <form method="post" enctype="multipart/form-data" name="FileUploadFrom">
                    <label for="file-upload3" class="custom-file-upload">
                        Upload
                    </label>
                    <input id="file-upload3" type="file" accept="image/*;capture=camera" name="upload_staging_invoice" class="UploadInvoice" />
                    <label class="BeforeAfterLabel">Before</label>
                    <label class="BeforeAfterLabel">After</label>
                    <upload name="upload_yard_work_before_front" label="FRONT YARD"></upload>
                    <upload name="upload_yard_work_after_front" label="FRONT YARD"></upload>
                    <upload name="upload_yard_work_before_back" label="BACK YARD"></upload>
                    <upload name="upload_yard_work_after_back" label="BACK YARD"></upload>
                    <input type="submit" style="display:none" name="submit_yard_work" class="SubmitButton" />
                </form>
            </div>

            <div ng-show="vm.showInspection" class="Innspection">
                <form method="post" enctype="multipart/form-data" name="FileUploadFrom">
                    <label for="file-upload4" class="custom-file-upload">
                        Upload
                    </label>
                    <input id="file-upload4" type="file" accept="image/*;capture=camera" name="upload_staging_invoice" class="UploadInvoice" />
                    <input type="submit" style="display:none" name="upload_inspection_report" class="SubmitButton" />
                </form>
            </div>

            <div ng-show="vm.showStorageWork" class="Storage">
                <form method="post" enctype="multipart/form-data" name="FileUploadFrom">
                    <label for="file-upload5" class="custom-file-upload">
                        Upload
                    </label>
                    <input id="file-upload5" type="file" accept="image/*;capture=camera" name="upload_staging_invoice" class="UploadInvoice" />
                    <input type="submit" style="display:none" name="upload_storage_invoice" class="SubmitButton" />
                </form>
            </div>

            <div ng-show="vm.showRelocation" class="Relocation">
                <form method="post" enctype="multipart/form-data" name="FileUploadFrom">
                    <label for="file-upload6" class="custom-file-upload">
                        Upload
                    </label>
                    <input id="file-upload6" type="file" accept="image/*;capture=camera" name="upload_staging_invoice" class="UploadInvoice" />
                    <input type="submit" style="display:none" name="upload_relocate_home_invoice" class="SubmitButton" />
                </form>
            </div>

        </div>
    </div>

</body>

</html>