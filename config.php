<?php 

if(isset($_POST["needDate"])){
    $date=new DateTime();
    echo json_encode([
        "sucess"=>true,
        "result"=>$date->format("Y-m-d H:i:s")
    ]);
}
?>