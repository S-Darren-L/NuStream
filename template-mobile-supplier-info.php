<?php

	// Start Session
	session_start();

	/*
	Template Name: Mobile Supplier Info
	*/

	// Set Sub-menu URL
	$subMenuURL = get_home_url() . "/supplier-info/?SType=";

	$homeURL = get_home_url();
	$mainPath = $homeURL . "/wp-content/themes/NuStream/";
	$goBackImagePath = $mainPath . "img/goBack.png";

	// Get Supplier Type
	$supplierType = $_GET['SType'];
	if($supplierType === null)
		$supplierType = "STAGING";

	// Get All Member Brief Info
	$strdInfoArray = get_supplier_brief_table('STAGING');
	$cledBriefInfoArray = get_supplier_brief_table('CLEANUP');
	$toudBriefInfoArray = get_supplier_brief_table('TOUCHUP');
	$yardBriefInfoArray = get_supplier_brief_table('YARDWORK');
	$reldBriefInfoArray = get_supplier_brief_table('RELOCATEHOME');
	$stodBriefInfoArray = get_supplier_brief_table('STORAGE');
	$insdBriefInfoArray = get_supplier_brief_table('INSPECTION');
	$phodBriefInfoArray = get_supplier_brief_table('PHOTOGRAPHY');

	function get_supplier_brief_table($supplierType){
		$result = get_supplier_brief_info($supplierType);
		if($result === null)
			echo 'result is null';
		$result_rows = [];
		while($row = mysqli_fetch_array($result))
		{
			$result_rows[] = $row;
		}
		return $result_rows;
	}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NuStream 新勢力地產</title>


    <style>
        .buttonPart button:hover {
            color: white;
            background: black;
            cursor: pointer;
        }

        .buttonPart button {
    border: 1px solid lightgrey;
    background: none;
    width: 23%;
    font-size: 5px;
    padding: 2% 0px 2% 0px;
    font-weight: 700;
    outline: none;
        }

        .infoCentreInfoStyle {
            width: 100%;
            border-left: 8px solid red;
            margin-top: 2%;
            background: #EEE;
        }

        .infoCentreInfoTable {
            padding: 2%;
            width: 100%;
            display: table;
        }

            .infoCentreInfoTable > li {
                width: 32%;
                display: table-cell;
                text-align: center;
                vertical-align: middle;
            }

                .infoCentreInfoTable > li:nth-child(1) {
                    border-right: 1px solid lightgrey;
                    font-size: 0.9em;
                }

                .infoCentreInfoTable > li:nth-child(2) {
                    border-right: 1px solid lightgrey;
                    font-size: 0.8em;
                }

                .infoCentreInfoTable > li:nth-child(3) {
                    font-size: 0.8em;
                }
    </style>
</head>
<body>
    <div class=''>
        <div class="">
        </div>
        <div class="buttonPart">
            <button class="buttonStyle buttonWhite stagingButtton" id="str">STAGING</button>
            <button class="buttonStyle buttonWhite claenUpButtton" id="cle">CLEAN UP</button>
            <button class="buttonStyle buttonWhite touchUpButtton" id="tou">TOUCH UP</button>
            <button class="buttonStyle buttonWhite yardWorkButtton" id="yar">YARD WORK</button>
            <button class="buttonStyle buttonWhite relocationButtton" id="rel">RELOCATION HOME</button>
            <button class="buttonStyle buttonWhite storageButtton" id="sto">STORAGE</button>
            <button class="buttonStyle buttonWhite inspectionButtton" id="ins">INSPECTION</button>
            <button class="buttonStyle buttonWhite photographyButtton" id="pho">PHOTOGRAPHY</button>
        </div>


        <div id="strd" style="display:block;">
            <?php
            for($i = 0; $i < count($strdInfoArray); $i++) {
            echo '<div class="infoCentreInfoStyle">
                ';
                echo '<ul class="infoCentreInfoTable">
                    ';
                    echo '
                    <li>', $strdInfoArray[$i]["SupplierName"], '</li>';
                    echo '
                    <li>', $strdInfoArray[$i]["SupportLocation"], '</li>';
                    echo '
                    <li class="tableBorderColor">', $strdInfoArray[$i]["FirstContactName"], '</br>', $strdInfoArray[$i]["FirstContactNumber"], '</li>';
                    echo '
                </ul>';
                echo '
            </div>';
            }
            ?>
        </div>
        <div id="cled" style="display:none;">
            <?php
            for($i = 0; $i < count($cledBriefInfoArray); $i++) {
            echo '<div class="infoCentreInfoStyle">
                ';
                echo '<ul class="infoCentreInfoTable">
                    ';
                    echo '
                    <li>', $cledBriefInfoArray[$i]["SupplierName"], '</li>';
                    echo '
                    <li>', $cledBriefInfoArray[$i]["SupportLocation"], '</li>';
                    echo '
                    <li class="tableBorderColor">', $cledBriefInfoArray[$i]["FirstContactName"], '</br>', $cledBriefInfoArray[$i]["FirstContactNumber"], '</li>';
                    echo '
                </ul>';
                echo '
            </div>';
            }
            ?>
        </div>
        <div id="toud" style="display:none;">
            <?php
            for($i = 0; $i < count($toudBriefInfoArray); $i++) {
            echo '<div class="infoCentreInfoStyle">
                ';
                echo '<ul class="infoCentreInfoTable">
                    ';
                    echo '
                    <li>', $toudBriefInfoArray[$i]["SupplierName"], '</li>';
                    echo '
                    <li>', $toudBriefInfoArray[$i]["SupportLocation"], '</li>';
                    echo '
                    <li class="tableBorderColor">', $toudBriefInfoArray[$i]["FirstContactName"], '</br>', $toudBriefInfoArray[$i]["FirstContactNumber"], '</li>';
                    echo '
                </ul>';
                echo '
            </div>';
            }
            ?>
        </div>
        <div id="yard" style="display:none;">
            <?php
            for($i = 0; $i < count($yardBriefInfoArray); $i++) {
            echo '<div class="infoCentreInfoStyle">
                ';
                echo '<ul class="infoCentreInfoTable">
                    ';
                    echo '
                    <li>', $yardBriefInfoArray[$i]["SupplierName"], '</li>';
                    echo '
                    <li>', $yardBriefInfoArray[$i]["SupportLocation"], '</li>';
                    echo '
                    <li class="tableBorderColor">', $yardBriefInfoArray[$i]["FirstContactName"], '</br>', $yardBriefInfoArray[$i]["FirstContactNumber"], '</li>';
                    echo '
                </ul>';
                echo '
            </div>';
            }
            ?>
        </div>
        <div id="reld" style="display:none;">
            <?php
            for($i = 0; $i < count($reldBriefInfoArray); $i++) {
            echo '<div class="infoCentreInfoStyle">
                ';
                echo '<ul class="infoCentreInfoTable">
                    ';
                    echo '
                    <li>', $reldBriefInfoArray[$i]["SupplierName"], '</li>';
                    echo '
                    <li>', $reldBriefInfoArray[$i]["SupportLocation"], '</li>';
                    echo '
                    <li class="tableBorderColor">', $reldBriefInfoArray[$i]["FirstContactName"], '</br>', $reldBriefInfoArray[$i]["FirstContactNumber"], '</li>';
                    echo '
                </ul>';
                echo '
            </div>';
            }
            ?>
        </div>
        <div id="stod" style="display:none;">
            <?php
            for($i = 0; $i < count($stodBriefInfoArray); $i++) {
            echo '<div class="infoCentreInfoStyle">
                ';
                echo '<ul class="infoCentreInfoTable">
                    ';
                    echo '
                    <li>', $stodBriefInfoArray[$i]["SupplierName"], '</li>';
                    echo '
                    <li>', $stodBriefInfoArray[$i]["SupportLocation"], '</li>';
                    echo '
                    <li class="tableBorderColor">', $stodBriefInfoArray[$i]["FirstContactName"], '</br>', $stodBriefInfoArray[$i]["FirstContactNumber"], '</li>';
                    echo '
                </ul>';
                echo '
            </div>';
            }
            ?>
        </div>
        <div id="insd" style="display:none;">
            <?php
            for($i = 0; $i < count($insdBriefInfoArray); $i++) {
            echo '<div class="infoCentreInfoStyle">
                ';
                echo '<ul class="infoCentreInfoTable">
                    ';
                    echo '
                    <li>', $insdBriefInfoArray[$i]["SupplierName"], '</li>';
                    echo '
                    <li>', $insdBriefInfoArray[$i]["SupportLocation"], '</li>';
                    echo '
                    <li class="tableBorderColor">', $insdBriefInfoArray[$i]["FirstContactName"], '</br>', $insdBriefInfoArray[$i]["FirstContactNumber"], '</li>';
                    echo '
                </ul>';
                echo '
            </div>';
            }
            ?>
        </div>
        <div id="phod" style="display:none;">
            <?php
            for($i = 0; $i < count($phodBriefInfoArray); $i++) {
            echo '<div class="infoCentreInfoStyle">
                ';
                echo '<ul class="infoCentreInfoTable">
                    ';
                    echo '
                    <li>', $phodBriefInfoArray[$i]["SupplierName"], '</li>';
                    echo '
                    <li>', $phodBriefInfoArray[$i]["SupportLocation"], '</li>';
                    echo '
                    <li class="tableBorderColor">', $phodBriefInfoArray[$i]["FirstContactName"], '</br>', $phodBriefInfoArray[$i]["FirstContactNumber"], '</li>';
                    echo '
                </ul>';
                echo '
            </div>';
            }
            ?>
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
	function hideAll() {
		$('#strd').css('display', 'none');
		$('#cled').css('display', 'none');
		$('#toud').css('display', 'none');
		$('#yard').css('display', 'none');
		$('#reld').css('display', 'none');
		$('#stod').css('display', 'none');
		$('#insd').css('display', 'none');
		$('#phod').css('display', 'none');
	}

	$('#str').on('click', function () {
		hideAll();
		$('#strd').css('display', 'block');
		$('#str').css('background', 'black').css('color', 'white');
	});
	$('#cle').on('click', function () {
		hideAll();
		$('#cled').css('display', 'block');
		$('#str').css('background', 'white').css('color', 'black');
	});
	$('#tou').on('click', function () {
		hideAll();
		$('#toud').css('display', 'block');
		$('#str').css('background', 'white').css('color', 'black');
	});
	$('#yar').on('click', function () {
		hideAll();
		$('#yard').css('display', 'block');
		$('#str').css('background', 'white').css('color', 'black');
	});
	$('#rel').on('click', function () {
		hideAll();
		$('#reld').css('display', 'block');
		$('#str').css('background', 'white').css('color', 'black');
	});
	$('#sto').on('click', function () {
		hideAll();
		$('#stod').css('display', 'block');
		$('#str').css('background', 'white').css('color', 'black');
	});
	$('#ins').on('click', function () {
		hideAll();
		$('#insd').css('display', 'block');
		$('#str').css('background', 'white').css('color', 'black');
	});
	$('#pho').on('click', function () {
		hideAll();
		$('#phod').css('display', 'block');
		$('#str').css('background', 'white').css('color', 'black');
	});
	$('#str').css('background', 'black').css('color', 'white');
    </script>
</body>
</html>
