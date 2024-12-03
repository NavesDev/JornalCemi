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
    <link rel="stylesheet" href="login_style.css">
    <title>Login</title>
</head>
<body>
    <div id="page">
        <div id="login">
            <div>
                <img src="sources/jc-banner.png" class="logos" alt="Jornal Cemic">
            </div>
            <h1>
                Faça login e receba benefícios!
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
            <div style="display: flex; flex-direction: row; gap:10px; align-self: center;">
                <input  type="checkbox" id="svlog">
                <h3 id="svlogt" style="margin-bottom: 5px;margin-top: 5px;">Salvar informações de login</h3>
            </div>
            <input id="logb" type="submit" value="LOGIN">
            <div id="logerror" class="errorspace">
                
            </div>
            <h3>Não tem uma conta ainda? <a href="reg_page.php">Registre-se</a></h3>
            <h4><a href="">Esqueceu sua senha?</a></h4>
        </div>        
    </div>
</body>
<script type="module" src="loginscript.js"></script>

</html>