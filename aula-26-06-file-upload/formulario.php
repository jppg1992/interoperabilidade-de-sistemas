
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
</head>
<body>
    <h1>Upload e Armazenamento de Arquivos</h1>

    <form method="post" action="/processo.php" enctype="multipart/form-data">
        <input type="text" name="descricao" placeholder="Descreva o arquivo"/>
        <input type="file" name="arquivo" />
        <input type="submit" value="Subir"/>
    </form>
</body>
</html>