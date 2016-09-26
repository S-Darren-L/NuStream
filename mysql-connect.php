<?php
    $con = mysql_connect("localhost", "nustream", "");
    if (!$con) {
        die("Can not connect: " . mysql_error());
    }



    mysql_close($con);
?>