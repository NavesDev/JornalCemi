<?php
$con = new mysqli("localhost", "root", "", "jornalcemic", 3307);
session_start();


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
                            "sucess" => true,
                            "id" => $userId
                        ];
                    } else {
                        return ["sucess"=>false, "error"=>"noBody"];
                    }
                } else {
                    unset($_SESSION["userToken"]);
                    return [
                        "sucess" => false,
                        "error" => "noToken"
                    ];
                }
            } else {
                return [
                    "sucess" => false,
                    "error" => "conError"
                ];
            }
        } else {
            return [
                "sucess" => false,
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
                        "sucess" => true,
                        "body" => $body
                    ]);
                } else if ($body && $body == "error") {
                    echo json_encode([
                        "sucess" => false,
                        "error" => "connection",
                        "msg" => "Erro carregando corpo"
                    ]);
                } else {
                    unset($_SESSION["userToken"]);
                    echo json_encode([
                        "sucess" => false,
                        "msg" => "Conta inativa",
                        "body" => $body
                    ]);
                }
            } else {
                $stmt->close();
                unset($_SESSION["userToken"]);

                echo json_encode([
                    "sucess" => false,
                    "body" => null
                ]);
            }
        } else {
            echo json_encode([
                "sucess" => false,
                "error" => "connection",
                "msg" => "Não há nenhuma conexão no sistema"
            ]);
        }
    } else {
        echo json_encode([
            "sucess" => false,
            "error" => "token",
            "msg" => "Não há nenhuma conexão no sistema"
        ]);
    }
} else if (isset($_POST["enterRequest"])) {
    $gotId = getUserId();
    if ($gotId["sucess"]) {
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
                        $dados["element" . $el] = [
                            "dda" => $row["dda"],
                            "ip" => $row["userIp"],
                            "local" => $row["ipLocation"]
                        ];
                        $el++;
                    }
                    echo json_encode([
                        "sucess" => true,
                        "got" => $dados
                    ]);
                } else {
                    echo json_encode(["sucess" => false, "error" => "noResult"]);
                }
                $result->free();
            } else {
                echo json_encode(["sucess"=> false, "error" => "conError"]);
            }
        } finally {
            if(isset($st)){
                $st->close();
            }
        }
    } else {
        echo json_encode([
            "sucess"=> false,
            "error"=> "noBody"
        ]);
    }
}

$con->close();
