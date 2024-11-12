<?php 
    $con = new mysqli("localhost","root","","jornalcemic",3307);
    
    if(isset($_POST["logtry"])){
        $usemail=$_POST["email"];
        $uspass=$_POST["senha"];
        echo json_encode([
            "sucess"=>true,
            "msg"=>"Seu email e senha foram enviado :".$usemail." e ".$uspass,
            "logged"=>false
        ]);
    } else if (isset($_POST["regtry"])){
        $usemail=$_POST["email"];
        $uspass=$_POST["senha"];
    }
?>