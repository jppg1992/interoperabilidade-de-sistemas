<?php
	$conexao = new pdo('sqlite:bancodedados.data');
	$diagnostico = $_REQUEST['diagnostico'];
	$insert = "insert into atendimento values (null, '".$_REQUEST['triagem']."', '".$_REQUEST['diagnostico']."', '".$_REQUEST['medicamento']."', '".$_REQUEST['encaminhamento']."', datetime('now') );";
	$resultado = $conexao->exec($insert);
	unset($conexao);
	if ( $resultado > 0 ) {
		PRINT (strpos($diagnostico,'COVID')>=0);
		 
		if ((strpos($diagnostico,'COVID')>=0) || (strpos($diagnostico,'Corona')>=0)){
			PRINT (strpos($diagnostico,'COVID')>=0);
			$curl = curl_init('http://localhost:8087/servico.php');
			$obj = ["unidade" => "PA Remoto"];
			$txt = json_encode($obj);
			curl_setopt($curl,CURLOPT_POSTFIELDS,$txt);
			curl_setopt($curl,CURLOPT_HTTPHEADER, ['Content-type:application/json']);
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
			$txt = curl_exec($curl);
			$remoto = json_decode($txt,true);
			print $remoto;
		}
		print 'Inserido com sucesso.';
		print '<script>window.setTimeout(function(){window.location=\'/atendimento_lista.php\';}, 2000);</script>';
	} else {
		print 'Erro na inserção.';
	}
?>