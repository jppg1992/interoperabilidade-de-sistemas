<?php
  
$conexao = new pdo("sqlite:banco");
$sql = "select * from image;";
$resultado = $conexao->query($sql)->fetchAll(2) ;
 
unset($conexao);

foreach ($resultado as $imagem){
    print '<img src="data:image/png;base64,'.$imagem['conteudo'].'" />';
}

 print "<script>  </script>";
?>
