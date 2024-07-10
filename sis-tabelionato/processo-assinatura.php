<?php
//var_dump($_REQUEST);
//var_dump($_FILES);
$caminho = $_FILES['arquivo']['tmp_name'];

$conteudo = file_get_contents($caminho);

$codificado = base64_encode($conteudo);

//print $codificado;
 
// upload da imagem para o serviço
$obj = ["base64"=>$codificado,"idImage"=>$_REQUEST['cpf'],"descricao"=>$_REQUEST['nome']];
$txt = json_encode($obj);	
$curl = curl_init('http://localhost:8082/servico-upload.php');
curl_setopt($curl,CURLOPT_POSTFIELDS,$txt);
curl_setopt($curl,CURLOPT_HTTPHEADER, ['Content-type:application/json']);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	 
$txt = curl_exec($curl);
//var_dump($txt);
$obj = json_decode($txt, true);
//var_dump($obj);
//inserir dados do assinante no banco local
if ($obj['id']>0){
$conexao = new pdo("sqlite:banco");
$sql = "insert into assinatura values (null,'".$_REQUEST['cpf']."','".$_REQUEST['nome']."','".$obj['id']."');";
$resultado = $conexao->exec($sql);
unset($conexao);
print('Assinatura salva com sucesso!');
}
else{
    print('Falha ao salvar assinatura');
}




 



?>
