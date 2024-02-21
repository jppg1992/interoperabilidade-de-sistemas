<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Procurado</title>
</head>
<body>
    <h1>Cadastro de Procurados</h1>
    <form>
        <label for="cpf">CPF <input type="text" name='cpf'></label>
        <label for="nome">NOME <input type="text" name='nome'></label>
        <label>
             <button type='submit' formaction='procurado_insert.php' formmethod='post'> SALVAR</button>
        </label>
    </form>
</body>
</html>