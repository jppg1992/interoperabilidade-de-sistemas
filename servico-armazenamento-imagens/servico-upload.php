<?php
    $txt = file_get_contents('php://input');
    $obj = json_decode($txt,true);
    $image = $obj['base64'];
    $idImage = $obj['idImage'];
    $descr = $obj['descricao'];
    
    $sql = "insert into image values (null,'".$idImage."','".$descr."','".$image."');";

	$conexao = new pdo ('sqlite:banco');
	 
    $resultado = $conexao->exec($sql);

    if ($resultado){
        $obj = ["status"=>"Sucesso"];
        $txt = json_encode($obj);
        print $txt;
    } else {
        $obj = ["status"=>"Falha"] ;
        $txt = json_encode($obj);
        print $txt;
    }
   
    print $txt;
?>