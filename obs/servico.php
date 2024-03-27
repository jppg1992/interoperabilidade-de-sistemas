<?php
    $txt = file_get_contents('php://input');
    $obj = json_decode($txt,true);
    $unidade = $obj['unidade'];
    $insert = "insert into covidcases values (NULL,'$unidade',date('now'));";
    $conexao = new pdo('sqlite:bancodedados.dat');
    $resultado = $conexao->exec($insert);
    print $resultado;
    if ($resultado > 0){
        $obj = ['status'=> 'Inserido' ];
    }else{
        $obj = ['status'=> 'erro'];
    }
    $txt = json_encode($obj);
    print $txt;
?>
