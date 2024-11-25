<?php
$con = new mysqli("localhost", "root", "", "jornalcemic", 3307);
session_start();


function getUserIP()
{
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }


    $ip = explode(',', $ip)[0];

    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        $ip = false;
    }

    return $ip;
}


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

if (isset($_POST["bodyRequest"])) {
    if (isset($_SESSION["userToken"])) {
        $tok = $_SESSION["userToken"];
        $stmt = $con->prepare("SELECT userId FROM enterlog WHERE token = ? AND tokenState = TRUE");
        $stmt->bind_param("s", $tok);
        if ($stmt->execute()) {
            $stmt->bind_result($userId);
            if ($stmt->fetch()) {
                $stmt->close();
                $body = getBody($userId);
                $body["ddc"] = substr($body["ddc"], 0, 10);
                if ($body && $body != "error") {
                    echo json_encode([
                        "success" => true,
                        "body" => $body
                    ]);
                } else if ($body && $body == "error") {
                    echo json_encode([
                        "success" => false,
                        "error" => "connection",
                        "msg" => "Erro carregando corpo"
                    ]);
                } else {
                    unset($_SESSION["userToken"]);
                    echo json_encode([
                        "success" => false,
                        "msg" => "Conta inativa",
                        "body" => $body
                    ]);
                }
            } else {
                $stmt->close();
                unset($_SESSION["userToken"]);

                echo json_encode([
                    "success" => false,
                    "body" => null
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "error" => "connection",
                "msg" => "Não há nenhuma conexão no sistema"
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "error" => "token",
            "msg" => "Não há nenhuma conexão no sistema"
        ]);
    }
} else if (isset($_POST["enterRequest"])) {
    $gotId = getUserId();
    if ($gotId["success"]) {
        $userId = $gotId["id"];
        try {
            $st = $con->prepare("SELECT dda,userIp,ipLocation FROM enterlog WHERE tokenState = true AND userId = ? ORDER BY dda DESC");
            $st->bind_param("i", $userId);
            if ($st->execute()) {
                $result = $st->get_result();
                $dados = [];
                $el = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $ip =$row["userIp"];
                        $dados["element" . $el] = [
                            "dda" => $row["dda"],
                            "ip" => $ip,
                            "local" => $row["ipLocation"],
                            "thisMachine"=> $ip==getUserIP()
                        ];
                        $el++;
                    }
                    echo json_encode([
                        "success" => true,
                        "got" => $dados
                    ]);
                } else {
                    echo json_encode(["success" => false, "error" => "noResult"]);
                }
                $result->free();
            } else {
                echo json_encode(["success"=> false, "error" => "conError"]);
            }
        } finally {
            if(isset($st)){
                $st->close();
            }
        }
    } else {
        echo json_encode([
            "success"=> false,
            "error"=> "noBody"
        ]);
    }
}

$con->close();
