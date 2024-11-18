<!DOCTYPE html>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style.css">
    <link rel="stylesheet" href="./configs-style.css">
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
                <input type="text" class="neednome" disabled value="Nenhum">
            </div>
            <div>
                <label>Nome de usuário : </label>
                <input type="text" class="needuserTag" disabled value="- - -">
            </div>
            <div>
                <label>Data de aniversário : </label>
                <input type="date" class="needbirthday" disabled >
            </div>
            <div>
                <label>Foto de perfil : </label>
                <img src="sources/user.png" style="background-color: gray;" class="needuserIcon" alt="">
            </div>
            <button>EDITAR INFORMAÇÕES</button>
        </div>

        <h2>Conta</h2>
        <div class="cont">
            
            <div>
                <label>Email : </label>
                <input type="text" class="needemail" disabled value="- - -">
            </div>
            <div>
                <label>Senha :</label>
                <input type="password" class="" disabled value="- - -">
                <a href="">Alterar a senha</a>
            </div>
            
            
            <div>
                <label>Data de criação de conta : </label>
                <input type="date" class="needddc" disabled >
            </div>
        </div>
        </div>
    </div>

    <?php include ("popups.php") ?>
    <?php include ("footer.php"); ?>

    <script src="script.js" type="module"></script>
   
</body>

<!-- Ta procurando oq aqui em baixo cara :^ -->
<!-- Miiler Dev :D-->
</html>