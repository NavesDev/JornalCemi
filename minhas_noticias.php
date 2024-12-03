<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Notícias</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="minhasNoticias.css">
    
    
 
</head>

<body>
    <?php include 'header.php'; ?> <!-- Include the existing header -->


    <main>
        <h1>Gerenciar Notícias</h1>

        <!-- Form to Upload News -->
        <section>
            <h2>Adicionar Nova Notícia</h2>
            <form>
                <label for="news_title">Título da Notícia:</label>
                <input type="text" id="news_title" name="news_title" required>

                <label for="news_content">Descrição da Notícia:</label>
                <textarea id="news_content" name="news_content" rows="5" required></textarea>

                <label for="news_image">Thumbnail (opcional):</label>
                <div id="news_dropzone">
                    <img src="sources/uploadIcon.svg" alt="">
                    <div style="display:flex;flex-direction:column;text-align:center;">
                        <p style="margin:0">Arraste sua imagem aqui</p>
                        <p style="margin:0;font-size:25px;">ou...</p>
                    </div>
                </div>
                <input type="file" id="news_image" name="news_image" accept="image/*">

                <button type="submit" id = "sendB" disabled>Próximo passo</button>
            </form>
        </section>

        <!-- Section to Edit Existing News -->
        <section>
            <h2>Notícias Existentes</h2>
           
                        <div class='news-item'>
                            <h3>{$row['title']}</h3>
                            <p>{$row['content']}</p>
                            
                            <form action='delete_news.php' method='POST'>
                                <input type='hidden' name='news_id' value='{$row['id']}'>
                                <button type='submit'>Excluir</button>
                            </form>
                        </div>
              
        </section>
    </main>
    <?php include("popups.php") ?>
    <?php include("footer.php") ?>
    <script src="script.js" type="module"></script>
    <script src="noticeManage.js"></script>
</body>

</html>