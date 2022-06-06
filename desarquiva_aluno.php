<?php
include('./seg.php');

	if (isset($_GET))
	{
		include('./conexao.php');

		$conexao = conexao();

		$id = $_GET['id'];

			//$del = $conexao->prepare("delete from tb_alunos where (id = :id) ");
			$del = $conexao->prepare("update tb_alunos set pin = '' where (id = :id) ");

			$del->bindParam('id', $id);

			$del->execute();

		echo ('Aluno desarquivado!');
		echo ('|||0');//para onde o sistema será direcionado
	}
?>