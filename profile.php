<?php include("needLogin.php") ?>

<!DOCTYPE html>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style.css">
    <link rel="stylesheet" href="./configs-style.css?v=1.1">
    <title>Jornal Cemic</title>
    <link rel="shortcut icon" href="sources/logo11.png">
</head>
<body name="GERAIS">
    <?php include("header.php") ?>
    

    <div class="page" id="GERAIS">
        <h1>Configurações</h1>
        <div style="margin-left:30px;">
        <h2>Perfil</h2> 
        <div class="cont">
        
            <div>
                <label>Nome : </label>
                <input type="text" class="neednomefuser" disabled value="Nenhum">
            </div>
            <div>
                <label>Nome de usuário : </label>
                <input type="text" class="needuserTagfuser" disabled value="- - -">
            </div>
            <div>
                <label>Data de aniversário : </label>
                <input type="date" class="needbirthdayfuser" disabled >
            </div>
            <div>
                <label>Foto de perfil : </label>
                <img src="sources/user.png" style="background-color: gray;" class="needuserIconfuser" alt="">
            </div>
            <button>EDITAR INFORMAÇÕES</button>
        </div>

        <h2>Conta</h2>
        <div class="cont">
            
            <div>
                <label>Email : </label>
                <input type="text" class="needemailfuser" disabled value="- - -">
            </div>
            <div>
                <label>Senha :</label>
                <input type="password" class="" disabled value="- - -">
                <a href="">Alterar a senha</a>
            </div>
            
            
            <div>
                <label>Data de criação de conta : </label>
                <input type="date" class="needddcfuser" disabled >
            </div>
        </div>
        <h2>Seções</h2>
        <div class="cont">
            <div class="sec">
                <div style="display:flex;flex-direction:row; gap:20px;">
                    <h3 class="needuserIp">192.168.1</h3>
                    <button>Encerrar sessão</button>
                </div>
                <div style="display:flex;flex-direction:row;">
                    <p>Última entrada : </p>
                    <p class="">12/05/2006</p>
                </div>
            </div>
        </div>
        </div>
    </div>

    <?php include ("popups.php") ?>
    <?php include ("footer.php"); ?>

    <script src="script.js" type="module"></script>
   <script src="config-script.js" type="module"></script>
</body>

<!-- Ta procurando oq aqui em baixo cara :^ -->
<!-- Miiler Dev :D-->
</html>