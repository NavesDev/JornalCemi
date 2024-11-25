<?php 

if(isset($_POST["needDate"])){
    $date=new DateTime();
    echo json_encode([
        "success"=>true,
        "result"=>$date->format("Y-m-d H:i:s")
    ]);
}
?>