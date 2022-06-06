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

<div class="centralizaconteudo">
	<section class="content">

		<div class="conteudo" id="conteudo">
			<form onsubmit="return false;" name="cadastra_fiscal" id="cadastra_fiscal" action="./cadastra_funcionario_sql.php" method="post" autocomplete="off" enctype="multipart/form-data">

				<p class="loginTitle">novo funcionario</p>

				<div class="campos">
					<p class="labels">Seu nome</p>
					<input required type="text" name="nome" autofocus maxlength="60" spellcheck="false" autocomplete="no">
				</div>

				<div class="campos">
					<p class="labels">Seu sobrenome</p>
					<input required type="text" name="sobrenome" maxlength="60" spellcheck="false" autocomplete="no">
				</div>

				<div class="campos">
						<p class="labels">Data de nascimento</p>
						<!--<div>Data de nascimento</div>-->

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
					<p class="labels">Sexo</p>
					<select name="sexo" required>
						<option value="" selected>Sexo</option>
						<option value="Feminino">Feminino</option>
						<option value="Masculino">Masculino</option>
					</select>
				</div>

				<div class="campos">
					<p class="labels">Seu e-mail</p>
					<input required type="email" name="email" maxlength="200" spellcheck="false" autocomplete="no">
				</div>

				<div class="campos">
					<p class="labels">Seu telefone - Ex. (xx)xxx-xxxx</p>
					<input required type="fone" name="fone" maxlength="12" spellcheck="false" autocomplete="no" value="(16)333-4444">
				
				</div>

				<div class="campos">
					<p class="labels">Seu endereço</p>
					<input required type="text" name="endereco" maxlength="200" spellcheck="false" autocomplete="no">
				</div>

				<div class="campos">
					<p class="labels">Seu Suco</p>
					<input required type="text" name="cidade" maxlength="200" spellcheck="false" autocomplete="no" placeholder="Sua cidade">
				</div>

				<div class="campos">
					<p class="labels">Seu Município</p>
					<select name="uf" required>
					<option value="" selected>Município</option>
						<?php include('./estados2.php'); ?>
					</select>
				</div>

				<div class="campos">
					<p class="labels">Seu país</p>
					<select name="pais" required>

						<?php include('./paises.php'); ?>
					</select>

				</div>

				<div class="campos">
					<p class="labels">Escolha a imagem para seu perfil</p>
					<div class="input-wrapper">
					  <label for="fileupload">
					    Click aqui para escolher
					  </label>
					  <input id="fileupload" type="file" name="fileupload" onchange="muda();">
					</div>

				</div>

				<div class="campos">
		
					<div required id="file-name" class="file-name">Imagem <strong>jpg</strong> permitido. Max 1mb</div>

				</div>

				<div class="campos">
					<p class="labels">Sua senha - Min 6 / Max 20</p>
					<input required type="password" name="senha" maxlength="20" spellcheck="false" autocomplete="no">
				</div>

				<div class="campos">
					<p class="labels">Repita sua senha</p>
					<input required type="password" name="repitasenha" maxlength="20" spellcheck="false" autocomplete="no" placeholder="">
				</div>

				<div class="campos">
					<p class="labels">Sua ID</p>
					<input required type="text" name="id" maxlength="33" spellcheck="false" autocomplete="no" placeholder="Digite a sua ID">
				</div>

				<div></div>

						<button class="bt" alt="Click para autenticar" title="Click para autenticar"  id="send_login_">cadastrar</button>

			</form>

						<button class="bt" alt="Click para autenticar" title="Click para autenticar"  id="send_login_"><a href="./acesso_funcionario.php">fazer login</a></button>

		</div>
	</section>

			    <div id="rs_login" class="hidden">

					<div class="loader">loading</div>

			        <div class="centralizaconteudo">

				        <p id="rss_log"></p>
			        	
			        </div>

			    </div>

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