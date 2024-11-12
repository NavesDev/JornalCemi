<?php 
    $con = new mysqli("localhost","root","","jornalcemic",3307);
    function hasEmail($email){
        global $con;
        $stmt=$con->prepare("SELECT email FROM login WHERE email=?");
        $stmt->bind_param("s",$email);
        if($stmt->execute()){
            $result=$stmt->get_result();
            $stmt->close();
            return $result->num_rows > 0;
        } else {
            $stmt->close();
            return 0;
        }
    }

    function hasName($name){
        global $con;
        $stmt=$con->prepare("SELECT userTag FROM login WHERE userTag=?");
        $stmt->bind_param("s",$name);
        if($stmt->execute()){
            $result=$stmt->get_result();
            $stmt->close();
            return $result->num_rows > 0;
        } else {
            $stmt->close();
            return 0;
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
        
        if(!filter_var($usmail,FILTER_VALIDATE_EMAIL) || $he = hasEmail($usmail) || strlen($usmail)>50){
            if($he){
                $erros[]="emailR";                
            } else {
                $erros[]= "email";
            }
        } 

        if(!preg_match('/^[a-zA-Z0-9!@#$%^&*()_+={}\[\]\',.?\/-]*$/', $uspass) || strlen($uspass) < 8 || strlen($uspass) > 40){
            $erros[]="senha";
        }
        $today=new DateTime();
        $birthdate=new DateTime($usbirth);

        if(!$date || $date->format("Y-m-d")!==$usbirth || $today->format("Y")-13<$birthdate->format("Y") || $today->format("Y")-130>$birthdate->format("Y") ){
            $erros[]="data";
        }

        if(!preg_match('/^[a-zA-Z0-9._-]+$/', $usname) || $usname[0]=="-" || $usname[0]=='_' || $usname[0]=="." ||strlen($usname)<4 || hasName($usname)){
            $erros[]="username";
        }

        if(count($erros)==0){
            $stmt=$con->prepare("INSERT INTO login(email,senha,birthday,userTag) VALUES( ? , ? , ? , ? )");
            $stmt->bind_param("ssss",$usmail,$uspass,$usbirth,$usname);
            if($stmt->execute()){
                echo json_encode([
                    "sucess" => true,
                    "msg" => "Registrado com sucesso!"
                ]);
            } else {
                echo json_encode([
                    "sucess" =>false,
                    "msg"=> "Erro de conexão",
                    "error"=> "connectError"
                ]);
            }
            $stmt ->close();
        } else {
            echo json_encode([
                'sucess'=>false,
                'msg'=> 'Algo deu errado',
                'error'=> $erros
            ]);
        }
    }
?>