<?php
include('./seg.php');

	extract($_POST);

	if ($_POST && $periodo != '' && is_numeric($disciplinasaprovados) && is_numeric($disciplinasmatriculados) && is_numeric($disciplinaspendentes))
	{
		$disciplinasaprovados = $disciplinasaprovados;
		$disciplinasmatriculados = $disciplinasmatriculados;
		$disciplinaspendentes = $disciplinaspendentes;


		include('./conexao.php');

		$conexao = conexao();

			$atualiza = $conexao->prepare("update tb_uploads set disciplinasaprovados = :disciplinasaprovados, disciplinasmatriculados = :disciplinasmatriculados, disciplinaspendentes = :disciplinaspendentes where (id = :id) ");


			$atualiza->bindParam('id', $periodo);
			$atualiza->bindParam('disciplinasaprovados', $disciplinasaprovados);
			$atualiza->bindParam('disciplinasmatriculados', $disciplinasmatriculados);
			$atualiza->bindParam('disciplinaspendentes', $disciplinaspendentes);

			$atualiza->execute();


			if ($atualiza)
			{
				echo ('<div class="rss_log">Atualização realizada com sucesso!</div>');//mesagem para o ususario

				echo ('|||painelaluno.php');//para onde o sistema será direcionado
			}
	}
	else
	{
		echo ('<div class="rss_log vermelho">Verifique os campos obrigatórios.</div>');//mesagem para o ususario
		echo ('|||0');//para onde o sistema será direcionado
	}?>

