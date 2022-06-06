<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="./css/style.css?version=<?php echo rand(324,65454); ?>">
	
	<title>:: Sistemas de Notas ::</title>
</head>
<body>

	<?php include('./header.php'); ?>

	<div class="container">

	<section class="content">

		<div class="conteudo" id="conteudo">
			<form onsubmit="return false;" name="cadastra_fiscal" id="cadastra_fiscal" action="./cadastra_funcionario_sql.php" method="post" autocomplete="off" enctype="multipart/form-data">

				<div class="campos">
					<p class="loginTitle">cadastro funcionarios</p>
				</div>

				<div class="campos">
					<input required type="text" name="nome" autofocus maxlength="60" spellcheck="false" autocomplete="no" placeholder="Seu nome">
				</div>

				<div class="campos">
					<input required type="text" name="sobrenome" autofocus maxlength="60" spellcheck="false" autocomplete="no" placeholder="Seu sobrenome">
				</div>

				<div class="datanascimento">
					<div>Data de nascimento</div>

					<div class="datanascimentobg">

						<div class="dia">

							<select name="dia" required>
								<option value="" selected>dia</option>

								<?php
									for($i = 1; $i < 32; $i++)
									{
										if ($i < 10)
										{
											echo ('<option value="'.$i.'">0'.$i.'</option>');
										}
										else
										{
											echo ('<option value="'.$i.'">'.$i.'</option>');
										}
									}

								?>
							</select>

						</div>

						<div class="mes">

							<select name="mes" required>
								<option value="" selected>mês</option>
								<?php
									for($i = 1; $i < 13; $i++)
									{
										$dateObj   = DateTime::createFromFormat('m', $i);
										$dateObj->setTimezone(new DateTimeZone('America/Sao_Paulo'));
										$monthName = $dateObj->format('F');

										echo ('<option value="'.$i.'">'.substr($monthName, 0, 3).'</option>');
									}

								?>
							</select>

						</div>

						<div class="ano">

							<select name="ano" required>
								<option value="" selected>ano</option>

								<?php
									for($i = date('Y'); $i > (date('Y')-100); $i--)
									{
										echo ('<option value="'.$i.'">'.$i.'</option>');
									}
								?>
							</select>

						</div>
					</div>

				</div>

				<div class="campos">
					<select name="sexo" required>
						<option value="" selected>Sexo</option>
						<option value="Feminino">Feminino</option>
						<option value="Masculino">Masculino</option>
						<option value="Outro">Outro</option>
					</select>
				</div>

				<div class="campos">
					<input required type="email" name="email" maxlength="200" spellcheck="false" autocomplete="no" placeholder="Seu e-mail">
				</div>

				<div class="campos">

					<input required type="fone" name="fone" maxlength="12" spellcheck="false" autocomplete="no" placeholder="Seu telefone - formato: (xx)xxx-xxxx" value="(16)333-4444">
				
				</div>

				<div class="campos">

					<input required type="endereco" name="endereco" maxlength="200" spellcheck="false" autocomplete="no" placeholder="Seu endereço">
				</div>

				<div class="campos">

					<input required type="cidade" name="cidade" maxlength="200" spellcheck="false" autocomplete="no" placeholder="Sua cidade">
				</div>

				<div class="campos">
					<select name="uf" required>
					<option value="" selected>Estado</option>
						<?php include('./estados.php'); ?>
					</select>
				</div>

				<div class="campos">
					<select name="pais" required>

						<?php include('./paises.php'); ?>
					</select>

				</div>

				<div class="campos">
		
					<div class="input-wrapper">
					  <label for="fileupload">
					    Imagem do perfil
					  </label>
					  <input id="fileupload" type="file" name="fileupload" onchange="muda();">
					</div>

				</div>

				<div class="campos">
		
					<div id="file-name" class="file-name">Escolha uma imagem <strong>jpg</strong> para seu perfil.<br>Max. 1mb</div>

				</div>

				<div class="campos">

					<input required type="password" name="senha" maxlength="20" spellcheck="false" autocomplete="no" placeholder="Sua senha - Min 6 / Max 20">
				</div>

				<div class="campos">

					<input required type="password" name="repitasenha" maxlength="20" spellcheck="false" autocomplete="no" placeholder="Repita sua senha">
				</div>

				<div class="campos">
					<button class="btCadastro" alt="Click para cadastrar" title="Click para cadastrar">cadastrar</button>
				</div>

			</form>

			<p class="criarConta" alt="Click para retornar a tela de login" title="Click para retornar a tela de login"><a href="./acesso_funcionario.php">fazer login</a></p>

		</div>
	</section>

			    <div id="rs_login" class="hidden">

					<div class="loader">loading</div>

					<div id="rss_log"></div>

			    </div>

</div>

<script type="text/javascript">

	function muda()
    {
        var recebe = document.getElementById('fileupload'),
        fl = document.getElementById('file-name');
        document.getElementById('file-name').innerHTML = document.getElementById('fileupload').value;
    };

</script>

<script type="text/javascript">
	

var form = document.getElementById('cadastra_fiscal');


form.addEventListener('submit', function(e)
{
	  e.preventDefault();

	  var url_checker = this.action;
	 
	  var formData = new FormData(this);
	  formData.append('file', fileupload.files[0]);
	 	

	  var ajax = new XMLHttpRequest();

	  ajax.open("POST", url_checker, true);

	  ajax.onload = function() 
	  {
		var i = 1;

		function msg_log(ii_l)
		{
			var div = document.getElementById('rss_log');

			setTimeout(function()
			{
					div.innerHTML = ii_l;

				setTimeout(function()
				{
					document.getElementById('rs_login').classList.add('hidden');
					div.innerHTML = '';

				}, 5000)

			}, 2000)

		}


	    if (ajax.status == 200)
	    {
	    	document.getElementById('rs_login').classList.remove('hidden');

	    	var resultado = ajax.responseText.split("|||");

			msg_log(resultado[0]);

			if (resultado[1] != 0)
			{
				setTimeout(function()
				{
					window.location.href = resultado[1];

				}, 4900);
				
			}
	    }
	    else
	    {
	      div.innerHTML = "Error. Contact System Administrator.";
	    }
	  };

  ajax.send(formData);

});

</script>

</body>
</html>