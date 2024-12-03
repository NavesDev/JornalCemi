<!DOCTYPE html>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style.css">
    <link rel="stylesheet" type="text/css" href="./editStyle.css">
    <title>Jornal Cemic</title>
    <link rel="shortcut icon" href="sources/logo11.png">
</head>

<body name="GERAIS">
    <?php include("header.php") ?>


    <div class="page" id="GERAIS">

        <h1>Título da notícia</h1>
        <p>A tecnologia está mudando rapidamente a forma como nos conectamos, trabalhamos e vivemos. Inovações em áreas como comunicação e saúde trazem benefícios, mas também desafios relacionados à privacidade, segurança e o impacto da automação no mercado de trabalho.</p>
        <div class="notHeader">
            <img src="sources/user.png" alt="">
            <label class="needuserTag">Autor</label>
        </div>
        <div class="content" id="editing">
            <div id="pubI-contTemplate" class="pub_input needOrder">
                <div class="floatingMenu">
                    <div>
                        <label>Tipo:</label>
                        <select name="sectypes" id="sectypes">
                            <option value="1">Título</option>
                            <option value="2">Subtítulo</option>
                            <option value="3">Parágrafo</option>
                        </select>
                    </div>
                    <img src="sources/secup.svg" id="secUp" alt="">
                    <img src="sources/secdown.svg" id="secDown" alt="">
                    <img src="sources/lixeira.svg" id="secDestroy" alt="">
                </div>
                <div id="obj-content">

                </div>
            </div>


        </div>
        <div id="addButton"class="addButton">
            <img src="sources/add-but.svg" alt="">
        </div>
        <div id = "publishdiv">
            <button >PUBLICAR</button>
        </div>
        
    </div>

    <?php include("popups.php") ?>

    <?php include("footer.php"); ?>

    <script src="script.js" type="module"></script>
    <script src="editScript.js"></script>
</body>

<!-- Ta procurando oq aqui em baixo cara :^ -->
<!-- Miiler Dev :D-->

</html>