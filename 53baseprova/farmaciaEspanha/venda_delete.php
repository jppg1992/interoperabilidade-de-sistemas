<?php
	$sql = " delete from venda where id = '" . $_REQUEST['id'] . "' ";
	$conexao = new pdo ('sqlite:banco.sqlite');
	$resultado = $conexao->exec($sql);
	unset($conexao);
	if ( $resultado ) {
?>
		<p>Removido com sucesso.</p>
		<script> setTimeout( function() { window.location.assign('venda_listar.php'); }, 2000); </script>
<?php
	} else {
?>
		<p>Erro ao remover.</p>
		<script> setTimeout( function() { window.history.back(); }, 2000); </script>
<?php
	}
