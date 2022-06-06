
	<p class="loginTitle">Lançar notas</p>
<div>&nbsp;</div>
<div>&nbsp;</div>

	<div class="historico">
		
		<!--<div class="nomedoarquivo coluna">nome do arquivo</div>
		
		<div class="arquivo coluna">ações</div>
		<div>&nbsp;</div>-->

	<?php

		include('./conexao.php');

		$conexao = conexao();

		$busca = $conexao->prepare("select * from tb_uploads where (periodo != '' AND anoletivo != '' AND fileupload != '' AND aluno = :aluno)");

		$busca->bindParam('aluno', $_SESSION['id']);


		$busca->execute();

		for ($i = 0; $i < $busca->rowcount(); $i++)
		{
			$retorno = $busca->fetch(PDO::FETCH_OBJ);

			$idperidos = $retorno->id;
			$periodo = $retorno->periodo;
			$anoletivo = $retorno->anoletivo;
			$fileupload = $retorno->fileupload;

			echo ('<div class="nomedoarquivo coluna">'.$periodo.' - '.$anoletivo.'</div>');
			echo ('<div class="arquivo coluna">');
			echo ('<a href="?page=lanca_notas_form&id='.$idperidos.'"><div class="acoesdownload coluna">cadastrar</div></a>');
			echo ('<a href="?page=lanca_notas_form&id='.$idperidos.'"><div class="acoesatualiza coluna" id="delete">atualizar</div></a></div>');
			echo ("<div></div><div>&nbsp;</div><div>&nbsp;</div>");
		}

?>

	</div>

		<div>&nbsp;</div>
		<div>&nbsp;</div>

		<button class="bt" alt="Click para cancelar" title="Click para cancelar" id="send_login_"><a href="./painelaluno.php">voltar</a></button>

<script type="text/javascript" src="./js/sessao.js"></script>