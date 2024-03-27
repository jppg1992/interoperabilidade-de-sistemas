<?php
	{/**this is 8087 espanha
		8088 osório 
		8089 tupy */}

	$conexao = new pdo ('sqlite:banco.sqlite');
 	$sql = " select anvisa from produto where id = '". $_REQUEST['produto']."'";
	$anvisa = $conexao->query($sql)->fetchAll()[0][0];

	$sql = " select cpf from cliente where id = '". $_REQUEST['cliente']."'";
	$cpf = $conexao->query($sql)->fetchAll()[0][0];

	
	$curl = curl_init('http://localhost:8089/servico.php');
	
	$obj = ['cpf' => $cpf, 'anvisa' => $anvisa];

	$txt = json_encode($obj);	
	curl_setopt($curl,CURLOPT_POSTFIELDS,$txt);
	curl_setopt($curl,CURLOPT_HTTPHEADER, ['Content-type:application/json']);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	$txt = curl_exec($curl);
	$remoto1 = json_decode($txt,true);
	
	$obj = ['cpf' => $cpf, 'anvisa' => $anvisa];
	error_log(print_r($obj, TRUE)); 
	$txt = json_encode($obj);	
	$curl = curl_init('http://localhost:8088/servico.php');
	curl_setopt($curl,CURLOPT_POSTFIELDS,$txt);
	curl_setopt($curl,CURLOPT_HTTPHEADER, ['Content-type:application/json']);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	$txt = curl_exec($curl);
	$remoto2 = json_decode($txt,true);


	$desconto1= $remoto1['status'];
	$desconto2= $remoto2['status'];


	error_log(print_r($remoto1, TRUE));
	error_log(print_r($remoto2, TRUE));
	if ($desconto1 == 1 || $desconto2 == 1){
		
		$desconto = 0.10;
	} else {
		$desconto = 0.0;
	}
		
	 
	
	$sql = " insert into venda values (null, '" . $_REQUEST['produto'] . "', '" . $_REQUEST['cliente'] . "', datetime('now'), ( select (valor - (valor * $desconto)) from produto where id = '" . $_REQUEST['produto'] . "') ); ";
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$resultado = $conexao->exec($sql);
	unset($conexao);
	if ( $resultado ) {
		print_r($desconto,true);
?>
		<p>Inserido com sucesso.</p>
		<script> setTimeout( function() { window.location.assign('venda_listar.php'); }, 2000); </script>
<?php
	} else {
?>
		<p>Erro ao inserir.</p>
		<script> setTimeout( function() { window.history.back(); }, 2000); </script>
<?php
	}
