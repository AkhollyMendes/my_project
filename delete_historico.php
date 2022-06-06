<?php
include('./seg.php');

	if (isset($_GET))
	{
		include('./conexao.php');

		$conexao = conexao();

		$id = $_GET['id'];
		$rsimg = $_GET['rsimg'];

			$del = $conexao->prepare("delete from tb_uploads where (id = :id) ");

			$del->bindParam('id', $id);
			unlink('./pdf/'.$rsimg);

			$del->execute();

		echo ('Delete realizado com sucesso!');
		echo ('|||0');//para onde o sistema será direcionado
	}
?>