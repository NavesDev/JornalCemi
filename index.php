<!DOCTYPE html>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style.css">
    <title>Jornal Cemic</title>
    <link rel="shortcut icon" href="sources/logo11.png">
</head>
<body name="GERAIS">
    <?php include("header.php") ?>
    

    <div class="page" id="GERAIS">
        
     <div class="read">
            <img  class="banner" src="sources/Banner1.png" alt="Banner1">
            <div class="bdesc">
                <h1 class="bdesc_title">CONHEÇA O CEMI INVEST!</h1>
                <p class="bdesc_p">Fundado por um grupo de estudantes do CEMIC em 2024, o Cemi Invest foi feito visando concientizar
                    os alunos da escola sobre atuais novidades de investimento tanto escolar quanto do atual grêmio e de vendas.
                </p>
                <button class="bleia" id="bleia"><strong>LER MAIS</strong></button>
            </div>
     </div>
    
    <h1 class="ptit">MAIS RECENTES</h1>
    <div class="thumb_layout">
        <div class="thumbp">
            <img class="thumb" src="sources/img_thumb.png" alt="thumb" height="173px" width="257px">
            <div>
                <h1 class="tthumb">Conteúdo não carregado</h1>
                <p class="pthumb">------------------------------</p>
                <button class="leia">LER MAIS</button>
            </div>
        </div>

        <div class="thumbp">
            <img class="thumb" src="sources/img_thumb.png" alt="thumb" height="173px" width="257px">
            <div>
                <h1 class="tthumb">Conteúdo não carregado</h1>
                <p class="pthumb">------------------------------</p>
                <button class="leia">LER MAIS</button>
            </div>
        </div>
        
        <div class="thumbp">
            <img class="thumb" src="sources/img_thumb.png" alt="thumb" height="173px" width="257px">
            <div>
                <h1 class="tthumb">Conteúdo não carregado</h1>
                <p class="pthumb">------------------------------</p>
                <button class="leia">LER MAIS</button>
            </div>
        </div>

        <div class="thumbp">
            <img class="thumb" src="sources/img_thumb.png" alt="thumb" height="173px" width="257px">
            <div>
                <h1 class="tthumb">Conteúdo não carregado</h1>
                <p class="pthumb">------------------------------</p>
                <button class="leia">LER MAIS</button>
            </div>
        </div>

    </div>    
    </div>

    <div id="popups">

        <div id="popup_sugest">
            <img src="sources/X-vetor.png" id="x-vetor">
            <h1 style="margin: 0;">Deixe sua sugestão aqui!</h1>
            <p id="sgtexto">Seu texto vai aparecer aqui.</p>
            <input id="sugt" type="text" placeholder=" Digite... (max. 255 caracteres)" maxlength="255">
            <button id="send">ENVIAR</button>  
        </div>
    </div>

    <?php include ("footer.php"); ?>

    <script src="script.js"></script>
    <script type="module" src="reqs.js"></script>
</body>

<!-- Ta procurando oq aqui em baixo cara :^ -->
<!-- Miiler Dev :D-->
</html>