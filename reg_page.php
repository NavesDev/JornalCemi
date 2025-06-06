<?php 
    session_start();
    if(isset($_SESSION["userToken"])){
        header("location: index.php");
    }    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_style.css?v=1.1">
    <title>Login</title>
</head>
<body>
    <div id="page">
        <div id="login">
            <img src="sources/jc-banner.png" class="logos" alt="Jornal Cemic">

            <h1>
                Registre-se na nossa página
            </h1>
            <div class="LoginBox" >
                <input type="email"   maxlength="64" id="usemail" required placeholder="Email"> 
                <img src="sources/email-icon.svg"  width="30px">
            </div>
            <div class="errorspace"id="emerror">
                
            </div>
            <div class="LoginBox">
                <input type="password" maxlength="20" id='uspass'required placeholder="Senha">
                <img src="sources/pass.svg" id="passhides" width="30px">
            </div>
            
            <div id="passerror" class="errorspace">
                
            </div>
            <div class="LoginBox">
                <input type="text" maxlength="20" id='usname'required placeholder="Nome de Usuário">
                <img src="sources/useric.svg"  width="30px">
            </div>
            <div id="nameerror" class="errorspace">
                
            </div>
            <div>
                <label>Data de nascimento</label>
                <input type="date" id="birthday" min="1900-01-01" max = "2024-10-28">
            </div>
            <div id="dateerror" class="errorspace">
                
            </div>
            <div style="display: flex; flex-direction: row; gap:10px; align-self: center;">
                <input  type="checkbox" id="svlog">
                <h3 id="svlogt" style="margin-bottom: 5px;margin-top: 5px;">Salvar informações de login</h3>
            </div>
            
            <input id="logb" type="submit" value="REGISTRAR">
            <div id="logerror" class="errorspace">
                
            </div>
            <div id="logerror" class="errorspace">
                
            </div>
            <h3>Já possui uma conta? <a href="login_page.php">Faça login</a></h3>
            <h4><a href="">Esqueceu sua senha?</a></h4>
        </div>        
    </div>
</body>
<script type="module" src="regscript.js?v=1.1"></script>
</html>