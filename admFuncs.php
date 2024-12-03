
<?php
$con = new mysqli("localhost", "root", "", "jornalcemic", 3307);
header('Content-Type: application/json'); // Garante resposta JSON
session_start();
$baseFuncs = require_once("geralFuncs.php");

function validateTitle($thisTitle)
{
    return (strlen($thisTitle) >= 20 && strlen($thisTitle) <= 100);
}
function validateDesc($thisDesc)
{
    return (strlen($thisDesc) >= 30 && strlen($thisDesc) <= 300);
}

function validateThumb($thisThumb)
{
    if (isset($thisThumb) && $thisThumb['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $thisThumb['tmp_name'];
        $fileName = $thisThumb['name'];
        $fileSize = $thisThumb['size'];


        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExtension, $allowedExtensions)) {
            // Validar se o arquivo é uma imagem legítima
            $check = getimagesize($fileTmpPath);
            if ($check !== false) {
                $maxFileSize = 1 * 1024 * 1024;
                if ($fileSize <= $maxFileSize) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}
if (isset($_POST["newPub"]) && isset($_POST["pTitle"]) && isset($_POST["pDesc"]) && $_FILES["pThumb"] && isset($_POST["pType"])) {
    $usId = getUserId();
    $body = getBody($usId);
    if ($body && $body["isAdmin"]) {
        $pTit = $_POST["pTitle"];
        $pDesc = $_POST["pDesc"];
        $pThumb = $_FILES["pThumb"];
        $pType = $_POST["pType"];
        if (validateTitle($pTit) && validateDesc($pDesc) && validateThumb($pThumb)) {
            $uploadDir = 'uploads/thumbs/';
            $destination = $uploadDir . tokenGenerate(10) . ".jpg";

            while (file_exists($destination)){
                $destination =$uploadDir . tokenGenerate(10);
            }

            if(move_uploaded_file($pThumb['tmp_name'],$destination)){
                $stmt = $con->prepare("INSERT INTO pub(userId,pubName,thumb,pubType,pubDesc) VALUES( ? , ? , ? , ? , ?)");
                $stmt->bind_param("issss",$usId,$pTit,$pThumb,$pType,$pDesc);
                if($stmt->execute()){
                    echo json_encode([
                        "success"=>true,
                        "pubId"=>$con->insert_id
                    ]);
                } else{
                    unlink($destination);
                    echo json_encode([
                        "success"=>false,
                        "error"=>"conError"
                    ]);
                }
                $stmt->close();
            } else {
                echo json_encode([
                    "success"=>false,
                    "error"=>"uploadError"
                ]);
            }

        } else {
            echo json_encode([
                "success"=>false,
                "error"=>"invalidData"
            ]);
        }
    } else {
        echo json_encode([
            "success"=>false,
            "error"=>"someInvalid"
        ]);
    }
}
$con->close();
?>