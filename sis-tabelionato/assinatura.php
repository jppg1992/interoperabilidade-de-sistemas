
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Assinatura</title>
</head>
<body>
    <h1>Armazenar Assinatura</h1>

    <form method="post" action="/processo.php" enctype="multipart/form-data">
        <input type="text" name="nome" placeholder="Nome"/>
        <input type="text" name="cpf" placeholder="CPF"/>
        <input type="file" name="arquivo" />
        <input type="submit" value="Subir"/>
    </form>
</body>
</html>