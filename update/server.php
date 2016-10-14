<?php
 	$result="";

    function opendb(){
        $conn=@mysql_connect("localhost","root","root")  or die(mysql_error());
        @mysql_select_db('test',$conn) or die(mysql_error());   
    }
 
    function closedb(){
        @mysql_close() or die("wrong");
    }
 
    opendb();
 
    if(isset($_POST['send'])=='true'){
        $username = isset($_POST['username'])? $_POST['username'] : '';  
        $filename = time().substr($_FILES['photo']['name'], strrpos($_FILES['photo']['name'],'.'));  
 
        if(move_uploaded_file($_FILES['photo']['tmp_name'], $filename)){  
            $sqlstr = "insert into member(`username`,`photo`) values('".addslashes($username)."','".addslashes($filename)."')";
            @mysql_query($sqlstr) or die(mysql_error());
        }  
    }
 
    echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
 
    $sqlstr = "select * from member";
    $query = mysql_query($sqlstr) or die(mysql_error());
 
    while($thread=mysql_fetch_assoc($query)){
        $result[] = $thread;
    }
 
?>


<!DOCTYPE html>
<style>
.imgStyle {
    width:32%;
}

.imgStyle img{
    width:30px;
}


.checkButtonPlace {

}
</style>
<html>
<head>
    <meta charset="utf-8"> 
    <title>float</title>
    <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<h2>Float test</h2>

<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
    Show picture
</button>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Picture
                </h4>
            </div>
            <div class="modal-body">
                <?php 
                if($result){
                    foreach($result as $val){ ?>
                    <div class="selectPart">
                        <input class="checkButtonPlace" type="checkbox"> <img src="<?php echo $val['photo']?>" ></img></input>
                    </div>
                    <?php 
                    echo $val['username'].' <br>';
                        }
                    }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button type="button" class="btn btn-primary">
                    提交更改
                </button>
            </div>
        </div>
    </div>
</div>
</body>
</html>