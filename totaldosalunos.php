<?php

		include('./conexao.php');

		$conexao = conexao();

		$busca = $conexao->prepare("select * from tb_alunos");


		$busca->execute();

		$total = $busca->rowcount();

		$totalgraduacao = 0;
		$totalposgraduacao = 0;
		$totaldoutorado = 0;

		$totalmascunlino = 0;
		$totalfeminino = 0;

		for ($i = 0; $i < $busca->rowcount(); $i++)
		{
			$retorno = $busca->fetch(PDO::FETCH_OBJ);

			if ($retorno->curso == 'Graduação')
			{
				$totalgraduacao++;
			}

			if ($retorno->curso == 'Pós-Graduação')
			{
				$totalposgraduacao++;
			}

			if ($retorno->curso == 'Doutorado')
			{
				$totaldoutorado++;
			}

			if ($retorno->sexo == 'Masculino')
			{
				$totalmascunlino++;
			}

			if ($retorno->sexo == 'Feminino')
			{
				$totalfeminino++;
			}
		}
?>

		<div class="titulototalalunos">total de alunos</div>

	<div class="boxtotalalunos">
		<div class="tituloalunos coluna">estudantes</div>
		<div class="totalalunos coluna">total</div>
		<div>&nbsp;</div>
		<div class="tituloalunos coluna">graduação</div>
		<div class="totalalunos coluna"><?php echo ($totalgraduacao); ?></div>
		<div>&nbsp;</div>
		<div class="tituloalunos coluna">pós-graduação</div>
		<div class="totalalunos coluna"><?php echo ($totalposgraduacao); ?></div>
		<div>&nbsp;</div>
		<div class="tituloalunos coluna">doutorado</div>
		<div class="totalalunos coluna"><?php echo ($totaldoutorado); ?></div>
		<div>&nbsp;</div>
		<div class="tituloalunos coluna cortotal">total</div>
		<div class="totalalunos coluna"><?php echo ($total); ?></div>
		<div class="linhainferior">&nbsp;</div>

		<div class="tituloalunos coluna">Masculino</div>
		<div class="totalalunos coluna"><?php echo ($totalmascunlino); ?></div>
		<div>&nbsp;</div>

		<div class="tituloalunos coluna">Feminino</div>
		<div class="totalalunos coluna"><?php echo ($totalfeminino); ?></div>



</div>

<script type="text/javascript" src="./js/sessao.js"></script>