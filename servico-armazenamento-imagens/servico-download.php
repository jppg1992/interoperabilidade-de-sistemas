<?php
    $txt = file_get_contents('php://input');
    $obj = json_decode($txt,true); 
    $idImage = $obj['id']; 
    
    $sql = "select * from image where id_img = '".$idImage."';";

	$conexao = new pdo ('sqlite:banco');
	 
    $resultado = $conexao->query($sql)->fetchAll(2);

    
    $txt =  json_encode($resultado);
    print $txt;
?>