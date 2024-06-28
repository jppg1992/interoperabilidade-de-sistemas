<?php
//var_dump($_REQUEST);
//var_dump($_FILES);
$caminho = $_FILES['arquivo']['tmp_name'];

$conteudo = file_get_contents($caminho);

$codificado = base64_encode($conteudo);

//print $codificado;


$conexao = new pdo("sqlite:banco");
$sql = "insert into image values (null,'".$_REQUEST['descricao']."','".$codificado."') returning id;";
$resultado = $conexao->query($sql)->fetchAll(2);
unset($conexao);


if($resultado) {

$obj = ["base64"=>$codificado,"idImage"=>$resultado[0]['id'],"descricao"=>$_REQUEST['descricao']];
$txt = json_encode($obj);	
$curl = curl_init('http://localhost:8083/servico-upload.php');
curl_setopt($curl,CURLOPT_POSTFIELDS,$txt);
curl_setopt($curl,CURLOPT_HTTPHEADER, ['Content-type:application/json']);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	 
$txt = curl_exec($curl);
print $txt;
print $resultado[0]['id'];    
print "Inserido com sucesso.";

$obj = json_decode($txt, true);

}else{
print "Erro ao inserir";
}



?>
