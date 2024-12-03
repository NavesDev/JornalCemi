<?php
$validImgEx = ['jpg','png','jpeg'];
function getBody($id)
{
    global $con;

    $stmt = $con->prepare("SELECT nome,email,birthday,userTag,userIcon,isAdmin,ddc FROM login WHERE userId = ? AND accState=TRUE");
    $stmt->bind_param("i", $id);

    try {
        if ($stmt->execute()) {
            return $stmt->get_result()->fetch_assoc();
        } else {
            return "error";
        }
    } finally {
        $stmt->close();
    }
}

function getUserId()
{
    global $con;
    $stmt1=null;
    try {
        if (isset($_SESSION["userToken"])) {
            $token = $_SESSION["userToken"];
            $stmt1 = $con->prepare("SELECT userId FROM enterlog WHERE token = ? AND tokenState = TRUE");
            $stmt1->bind_param("s", $token);
            if ($stmt1->execute()) {
                $stmt1->bind_result($userId);
                if ($stmt1->fetch()) {
                    $stmt1->close();
                    $stmt1=null;
                    $body = getBody($userId);
                    if ($body && $body != "error") {
                        return [
                            "success" => true,
                            "id" => $userId
                        ];
                    } else {
                        return ["success"=>false, "error"=>"noBody"];
                    }
                } else {
                    unset($_SESSION["userToken"]);
                    return [
                        "success" => false,
                        "error" => "noToken"
                    ];
                }
            } else {
                return [
                    "success" => false,
                    "error" => "conError"
                ];
            }
        } else {
            return [
                "success" => false,
                "error" => "noToken"
            ];
        }
    } finally {
        if(isset($stmt1) && $stmt1 instanceof mysqli_stmt) {
            $stmt1->close();
        }
    }
}

function tokenGenerate($len)
{
    $bytes = random_bytes(ceil($len / 2));
    return base64_encode($bytes);
}

?>