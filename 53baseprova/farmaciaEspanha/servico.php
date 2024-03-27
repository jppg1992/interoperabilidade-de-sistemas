<?php
    $txt = file_get_contents('php://input');
    $obj = json_decode($txt,true);
    $cpf = $obj['cpf'];
    $anvisa = $obj['anvisa'];

    $sql = " select p.anvisa as anvisa 
    from venda v 
    join cliente c on c.id = v.cliente 
    join produto p on p.id = v.produto 
    where c.cpf = '".$cpf."' 
    order by v.datahora desc LIMIT 3;";
	$conexao = new pdo ('sqlite:banco.sqlite');
	$resultado = $conexao->query($sql)->fetchAll(2);
	unset($conexao);

    
    $obj= ['status' => false] ;

    if (count($resultado) > 0){
    foreach ( $resultado as $tupla ) {

        error_log( print_r($tupla,true));
       if( $tupla['anvisa'] == $anvisa ){
        $obj= ['status' => true] ;
       }
    }
}
     $txt = json_encode($obj);
    print $txt;
?>