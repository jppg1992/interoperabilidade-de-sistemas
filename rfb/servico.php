<?php
    $txt = file_get_contents('php://input');
    $obj = json_decode($txt,true);
    //["cpf":"12345678901"]
$cpf =  $obj['cpf'];
include 'funcoes.php'; 
$obj = ["status"=>valida($cpf)];
$txt = json_encode($obj);
print $txt;
?>