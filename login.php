<?php 
    $con = new mysqli("localhost","root","","jornalcemic",3307);
    function hasEmail($email){
        global $con;
        $stmt=$con->prepare("SELECT email FROM login WHERE email=?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows> 0){
            return true;
        } else {
            return false;
        }
    }

    function hasName($name){
        global $con;
        $stmt=$con->prepare("SELECT userTags FROM login WHERE userTag=?");
        $stmt->bind_param("s",$name);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows> 0){
            return true;
        } else {
            return false;
        }
    }

    if(isset($_POST["logtry"])){
        $usemail=$_POST["email"];
        $uspass=$_POST["senha"];
        echo json_encode([
            "sucess"=>true,
            "msg"=>"Seu email e senha foram enviado :".$usemail." e ".$uspass,
            "logged"=>false
        ]);
    } else if (isset($_POST["regtry"]) && isset($_POST["email"]) && isset($_POST["senha"]) && isset($_POST["birthday"]) && isset($_POST["username"]) ){
        $usmail=$_POST["email"];
        $uspass=$_POST["senha"];
        $usbirth=$_POST["birthday"];
        $usname=$_POST["username"];
        $erros=[];
        $date=DateTime::createFromFormat('Y-m-d', $usbirth);

        if(!filter_var($usmail,FILTER_VALIDATE_EMAIL) || hasEmail($usmail)){
            $erros[]="email";
        }

        if(!preg_match('/^[a-zA-Z0-9!@#$%^&*()_+={}\[\]\',.?\/-]*$/', $uspass) || strlen($uspass) < 8){
            $erros[]="senha";
        }

        if(!$date || $date->format("y-m-d")!==$usbirth){
            $erros[]="data";
        }

        if(!preg_match('/^[a-zA-Z0-9._-]+$/', $usname) || $usname[0]=="-" || $usname[0]=='_' || $usname[0]=="." ||strlen($usname)<4){
            $erros[]="username";
        }

        if(count($erros)==0){
            
        }
    }
?>