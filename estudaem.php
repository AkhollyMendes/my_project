<div class="titulototalalunos">estuda em</div>

<div class="headring espacoinferior bgprincipal">
	<div class="id coluna">&nbsp;id</div>
	<div class="nome coluna">&nbsp;nome</div>
	<div class="sobrenome coluna">&nbsp;sobrenome</div>
	<div class="email coluna">&nbsp;email</div>
	<div class="fone coluna">&nbsp;telefone</div>
	<div class="opcoes coluna">&nbsp;+ opções</div>
</div>
<?php

		include('./conexao.php');

		$conexao = conexao();

		$busca = $conexao->prepare("select * from tb_alunos order by id desc");


		$busca->execute();


		for ($i = 0; $i < $busca->rowcount(); $i++)
		{
			$retorno = $busca->fetch(PDO::FETCH_OBJ);

			echo ('<div class="headring espacosuperior">');

				echo ('<div class="coluna id">&nbsp;'.$retorno->id.'</div>&nbsp;');
				echo ('<div class="coluna nome">&nbsp;'.$retorno->nome.'</div>&nbsp;');
				echo ('<div class="coluna sobrenome">&nbsp;'.$retorno->sobrenome.'</div>&nbsp;');
				echo ('<div class="coluna email">&nbsp;'.$retorno->email.'</div>&nbsp;');
				echo ('<div class="coluna fone">&nbsp;'.$retorno->fone.'</div>&nbsp;');
				echo ('<div class="coluna opcoes vizualizar" id="'.$retorno->id.'" onclick="clickvizualizar(this.id);">&nbsp;vizualizar</div>');

			echo ('</div>');

			echo ('<span id="id'.$retorno->id.'" class="hidden">');

				echo ('<div class="linhadescricao">&nbsp;<span class="titulo">endereço</span>: '.$retorno->endereco.'</div>');
				echo ('<div class="linhadescricao">&nbsp;<span class="titulo">cidade</span>: '.$retorno->cidade.'</div>');
				echo ('<div class="linhadescricao">&nbsp;<span class="titulo">uf</span>: '.$retorno->uf.'</div>');
				echo ('<div class="linhadescricao">&nbsp;<span class="titulo">país</span>: '.$retorno->pais.'</div>');
				echo ('<div class="linhadescricao">&nbsp;<span class="titulo">universidade</span>: '.$retorno->universidade.'</div>');
				echo ('<div class="linhadescricao">&nbsp;<span class="titulo">curso</span>: '.$retorno->curso.'</div>');
				echo ('<div class="linhadescricao">&nbsp;<span class="titulo">área do estudo</span>: '.$retorno->areadoestudo.'</div>');
				echo ('<div class="linhadescricao">&nbsp;<span class="titulo">ano de início</span>: '.$retorno->anodeinicio.'</div>');
				echo ('<div class="linhadescricao">&nbsp;<span class="titulo">notas</span>: edit/delete</div>');

				echo ('<div class="espacoinferior">&nbsp;</div>');

			echo ('</span>');
		}

?>

<script type="text/javascript">
	
	function clickvizualizar(idrec)
	{
		if (document.getElementById('id'+idrec).classList != 'hidden')
		{
			document.getElementById('id'+idrec).classList.add('hidden');
		}
		else
		{
			document.getElementById('id'+idrec).classList.remove('hidden');
		}
	}
</script>