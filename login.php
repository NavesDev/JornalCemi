<?php 
    $con = new mysqli("localhost","root","","jornalcemic",3307);

    session_start();
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

    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) <= 50;
    }
    
    function validatePassword($password) {
        return preg_match('/^[a-zA-Z0-9!@#$%^&*()_+={}\[\]\',.?\/-]*$/', $password) && strlen($password) >= 8 && strlen($password) <= 40;
    }
    
    function validateDateOfBirth($dob) {
        $date = DateTime::createFromFormat('Y-m-d', $dob);
        $today = new DateTime();
        $birthdate = new DateTime($dob);
        return $date && $date->format("Y-m-d") === $dob && ($today->format("Y") - 13) >= $birthdate->format("Y") && ($today->format("Y") - 130) <= $birthdate->format("Y");
    }
    
    function validateUsername($username) {
        return preg_match('/^[a-zA-Z0-9._-]+$/', $username) && strlen($username) >= 4 && !hasName($username) && strlen($username)<=20;
    }

    
    function getUserIP() {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        

        $ip = explode(',', string: $ip)[0];
        
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            $ip = false; 
        }

        return $ip;
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
    function tokenGenerate($len){
        $bytes=random_bytes(ceil($len/2));
        return base64_encode($bytes);
    }

    function makeLogin($userId,$userIp){
        global $con;
        $token="";
        $atry = 0;
    
        while ($atry<10) {
            $token=tokenGenerate(random_int(50,98));
            $stmt = $con->prepare("SELECT token FROM enterlog WHERE token=?");
            $stmt->bind_param('s',$token);
            if($stmt->execute()){
                $r=$stmt->get_result();
                if($r->num_rows > 0){
                    $atry++;
                    $stmt->close();
                } else {
                    $stmt->close();
                    break;
                }
            } else {
                $stmt->close();
                return false;
            }
            
            if($atry>=10){
                return false;
            }
        }
        
        $ch = curl_init("http://ip-api.com/json/2001:4860:7:703::72");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $local=null;
        $response = curl_exec($ch);
        
        if(!curl_errno($ch)){
            $data = json_decode($response,true);
            if($data && $data["status"]==="success"){

                $local = ($data['country_name'] ?? "Páis não encontrado").", ". ($data['city']??"cidade não encontrada");
            }
        }

        $stmt= $con->prepare('INSERT INTO enterlog(userIp,userId,token,ipLocation) VALUES(? , ? , ?, ?)');
        $stmt->bind_param('siss',$userIp,$userId, $token,$local);
        
        if($stmt->execute()){
            $stmt->close();
            
            $_SESSION['userToken']=$token;
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    if(isset($_POST["logtry"])){
        $usemail=strtolower($_POST["email"]);
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
      
        
        if(!validateEmail($usmail)){           
            $erros[]= "email";
        } else if(hasEmail($usmail)){
            $erros[]="emailR";    
        }


        if(!validatePassword( $uspass )){
            $erros[]="senha";
        }
        

        if(!validateDateOfBirth($usbirth)){
            $erros[]="data";
        }

        if(!validateUsername($usname)){
            $erros[]="username";
        }

        if(count($erros)==0){
            $password=password_hash($uspass,PASSWORD_DEFAULT);
            $stmt=$con->prepare("INSERT INTO login(email,senha,birthday,userTag) VALUES( ? , ? , ? , ? )");
            $stmt->bind_param("ssss",$usmail,$password,$usbirth,$usname);
            if($stmt->execute()){
                $usid = $con->insert_id;
                $stmt ->close();
                $login = makeLogin($usid, getUserIP());
                echo json_encode([
                    "sucess" => true,
                    "msg" => "Registrado com sucesso!",
                    "login" => $login
                ]);
                
            } else {
                echo json_encode([
                    "sucess" =>false,
                    "msg"=> "Erro de conexão",
                    "error"=> "connectError"
                ]);
            }

        } else {
            echo json_encode([
                'sucess'=>false,
                'msg'=> 'Algo deu errado',
                'error'=> $erros
            ]);
        }
    }
    $con->close();
?>