<?php
    $txt = file_get_contents('php://input');
    $obj = json_decode($txt,true);
    //["cpf":"12345678901"]
$entrada =  $obj['entrada'];
include 'funcoes.php'; 
$obj = ["status"=>"INVALIDO"];

if (validaCpf($entrada)){
    $obj = ["status"=>"CPF"];
}
elseif (validaCnpj($entrada)){
    $obj = ["status"=>"CNPJ"];
}

$txt = json_encode($obj);
print $txt;
?>