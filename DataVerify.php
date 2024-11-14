<?php 
    $con = new mysqli("localhost","root","","jornalcemic",3307);

    if(isset($_POST["data"]) && isset($_POST["DT"])){
        $data = $_POST["data"];
        $dataType = $_POST["DT"];
        if($dataType == "username"){
            $stmt= $con->prepare("SELECT userTag FROM login WHERE userTag = ? ");
            $stmt->bind_param("s", $data);
            $stmt->execute();
            $result= $stmt->get_result();
            if(!$stmt->error){
                if($result->num_rows > 0) {
                    echo json_encode([
                        "sucess"=>true,
                        "result"=>$result->num_rows
                    ]);
                } else { 
                    echo json_encode([
                        "sucess"=>true,
                        "result"=>false
                    ]);
                }
            } else {
                echo json_encode([
                    "sucess"=>false,
                    "result"=>false
                ]);
            }
            $stmt->close();
        }
    }
    $con->close();
?>