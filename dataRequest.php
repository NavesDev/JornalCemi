<?php 
    $con = new mysqli("localhost","root","","jornalcemic",3307);
    session_start();

    function getBody($id){
        global $con;
        
        $stmt = $con->prepare("SELECT nome,email,birthday,userTag,userIcon,isAdmin,ddc FROM login WHERE userId = ? AND accState=TRUE");
        $stmt->bind_param("i",$id);

        try{
            if($stmt->execute()){
                return $stmt->get_result()->fetch_assoc();
            } else {
                return "error";
            }
        } finally {
            $stmt->close();
        }
       
    }

    //if(isset($_POST["bodyRequest"])){
        if(isset($_SESSION["userToken"])){
            $tok=$_SESSION["userToken"];
            $stmt=$con->prepare("SELECT userId FROM enterlog WHERE token = ? AND tokenState = TRUE");
            $stmt->bind_param("s",$tok);
            if($stmt->execute()){
                $stmt->bind_result($userId);
                if($stmt->fetch()){
                    $stmt->close();
                    $body = getBody($userId);
                    $body["ddc"]=substr($body["ddc"],0,10);
                    if($body && $body!="error"){
                        echo json_encode([
                            "sucess"=>true,
                            "body"=>$body
                        ]);
                    }else if ($body && $body=="error"){
                        echo json_encode([
                            "sucess"=>false,
                            "error"=>"connection",
                            "msg"=>"Erro carregando corpo"
                        ]);
                    } else {
                        unset($_SESSION["userToken"]);
                        echo json_encode([
                            "sucess"=>false,
                            "msg"=>"Conta inativa",
                            "body"=>$body
                        ]);
                    }
                } else {
                    $stmt->close();
                    unset($_SESSION["userToken"]);

                    echo json_encode([
                        "sucess"=>false,
                        "body"=>null
                    ]);
                }
            } else {
                echo json_encode([
                    "sucess"=>false,
                    "error"=>"connection",
                    "msg"=>"Não há nenhuma conexão no sistema"
                ]);
            }
            
           
        }else {
            echo json_encode([
                "sucess"=>false,
                "error"=>"token",
                "msg"=>"Não há nenhuma conexão no sistema"
            ]);
        }
   // }

    $con->close();
?> 