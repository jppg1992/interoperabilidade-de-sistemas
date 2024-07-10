<?php
    $txt = file_get_contents('php://input');
    $obj = json_decode($txt,true);
    $image = $obj['base64'];
    $idImage = $obj['idImage'];
    $descr = $obj['descricao'];
    
    $sql = "insert into image values (null,'".$idImage."','".$descr."','".$image."') returning id;";

	$conexao = new pdo ('sqlite:banco');
	 
    $resultado = $conexao->query($sql)->fetchAll(2);

    $id = $resultado[0]['id'];

    if ($id){
        $obj = ["status"=>"Sucesso","id"=>$id];
        $txt = json_encode($obj);
        print $txt;
    } else {
        $obj = ["status"=>"Falha"] ;
        $txt = json_encode($obj);
        print $txt;
    }
   
     
?>
