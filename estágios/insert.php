<?php
	if ( !isset($_REQUEST['entidade']) ) {
		print 'Erro.';
		exit;
	}
	$sql = " select * from ".$_REQUEST['entidade']." limit 1; ";
	$conexao = new pdo ('sqlite:database');
	$conexao->exec("pragma foreign_keys = ON;");
	$meta = $conexao->query( $sql );
	$c = $meta->columnCount();
	$columns = [];
	$values = [];

	if (isset($_REQUEST['cpf'])){
		$curl = curl_init('http://localhost:8082/servico.php');
		$obj = ["entrada" => $_REQUEST['cpf']];
		$txt = json_encode($obj);
		curl_setopt($curl,CURLOPT_POSTFIELDS,$txt);
		curl_setopt($curl,CURLOPT_HTTPHEADER, ['Content-type:application/json']);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		$txt = curl_exec($curl);
		$remoto = json_decode($txt,true);
		if ($remoto["status"] != "CPF"){
			print 'Erro: CPF inválido !';
			exit;
		}
	}

	if (isset($_REQUEST['cnpj'])){
		$curl = curl_init('http://localhost:8082/servico.php');
		$obj = ["entrada" => $_REQUEST['cnpj']];
		$txt = json_encode($obj);
		curl_setopt($curl,CURLOPT_POSTFIELDS,$txt);
		curl_setopt($curl,CURLOPT_HTTPHEADER, ['Content-type:application/json']);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		$txt = curl_exec($curl);
		$remoto = json_decode($txt,true);
		if ($remoto["status"] != "CNPJ"){
			print 'Erro: CNPJ inválido';
			exit;
		}
	}

	for ( $i = 0 ; $i < $c ; $i++ ) {
		if ( in_array ($meta->getColumnMeta($i)['name'], ['id'] ) ) {
			continue;
		}
		$columns[] = $meta->getColumnMeta($i)['name'];
		$values[] = $_REQUEST[$meta->getColumnMeta($i)['name']];
	}
	$sql = " insert into ".$_REQUEST['entidade']." (".implode(", ", $columns).") values ('".implode("', '", $values)."'); ";
	$resultado = $conexao->exec($sql);
	if ( $resultado == 0 ) {
		print 'Erro.';
		exit;
	}
	unset($conexao);
	header('Location: lista.php?entidade='.$_REQUEST['entidade'].'&rotulo='.$_REQUEST['rotulo'].(isset($_REQUEST['view']) ? '&view' : ''));