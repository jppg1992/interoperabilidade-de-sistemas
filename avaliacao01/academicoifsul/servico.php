<?php
    $txt = file_get_contents('php://input');
    $obj = json_decode($txt,true);
    $cpf = $obj['cpf'];
    

    $select = "select  
    a.nome anome, 
    d.nome dnome,
    p.nome pnome, 
    m.conceito  
    from matricula m 
    join aluno a on a.id = m.aluno 
    join disciplina d on d.id = m.disciplina 
    join professor p on p.id = d.professor 
    where a.cpf =  '".$cpf."' 
    order by d.nome";

	$conexao = new pdo ('sqlite:banco.sqlite');
	 
    $resultado = $conexao->query($select)->fetchAll(2);
    $txt = json_encode( $resultado );

   
    print $txt;
?>
