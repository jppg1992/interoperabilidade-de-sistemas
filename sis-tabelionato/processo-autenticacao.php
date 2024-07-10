<?php
//var_dump($_REQUEST);
//var_dump($_FILES);

$select = "select * from assinatura where cpf = '".$_REQUEST['cpf']."';";
$conexao = new pdo("sqlite:banco");
$resultado = $conexao->query($select)->fetchAll(2); 
unset($conexao);
$idAssinatura = $resultado[0]['idAssinatura'];
if ($idAssinatura > 0){
$obj = [ "id"=>$idAssinatura];
$txt = json_encode($obj);	
$curl = curl_init('http://localhost:8082/servico-download.php');
curl_setopt($curl,CURLOPT_POSTFIELDS,$txt);
curl_setopt($curl,CURLOPT_HTTPHEADER, ['Content-type:application/json']);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	 
$txt = curl_exec($curl);
// var_dump($txt);
$obj = json_decode($txt, true);
//var_dump($obj[0]['base64']);
print '<h1>Confirmar Assinatura e Subir Doc</h1>';
print '<form method="post" action="/confirmar-autenticacao.php" enctype="multipart/form-data">';
print 'COPIA:<input type="text" name="nome" value="'.$_REQUEST['nome'].'"/>';
print '<input type="file" name="arquivo"  />';
print '<br/>';
print 'CPF:<input type="text" name="cpf" value="'.$_REQUEST['cpf'].'"/>';
print 'ASSINATURA:<img src="data:image/png;base64,'.$obj[0]['base64'].'" />';

print '<input type="submit" value= "confirmar assinatura" />';
print '</form>';
 



}
else{
    print "Não encontrada assinatura para o cpf ".$_REQUEST['cpf'].""; 
}

 



?>
