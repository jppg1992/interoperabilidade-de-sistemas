
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticar Documento</title>
</head>
<body>
    <h1>Buscar Assinatura</h1>


    <form method="post" action="/processo-autenticacao.php" enctype="multipart/form-data">
    <input type="text" name="cpf" placeholder="CPF Assinante"/>    
    <input type="text" name="nome" placeholder="nome"/>
    <input type="submit" value="Subir"/>
    </form>
</body>
</html>