
<?php
    $supplierName = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $supplierName = test_input($_POST["name"]);

    }
?>