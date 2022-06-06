	<?php

		include('./conexao.php');

		$conexao = conexao();

		$busca = $conexao->prepare("select * from tb_alunos where (id = :id) limit 1");

		$busca->bindParam('id', $_REQUEST['id']);


		$busca->execute();

		$retorno = $busca->fetch(PDO::FETCH_OBJ);

		$nome = $retorno->nome;
		$sobrenome = $retorno->sobrenome;
		$dataNascimento = explode('-', $retorno->dataNascimento);
		$dia = $dataNascimento[2];
		$mes = $dataNascimento[1];
		$ano = $dataNascimento[0];
		$sexo = $retorno->sexo;
		$email = $retorno->email;
		$fone = $retorno->fone;
		$endereco = $retorno->endereco;
		$cidade = $retorno->cidade;
		$uf = $retorno->uf;
		$pais = $retorno->pais;
		$universidade = $retorno->universidade;
		$curso = $retorno->curso;
		$areadoestudo = $retorno->areadoestudo;
		$anodeinicio = $retorno->anodeinicio;
		$disciplinastotal = $retorno->disciplinastotal;
		$fileupload = $retorno->fileupload;
		$senha = $retorno->senha;

?>

			<form onsubmit="return false;" name="cadastra_fiscal" id="cadastra_fiscal" action="./altera_aluno_sql_funcionario.php" method="post" autocomplete="off" enctype="multipart/form-data">

					<input value="<?php echo ($_REQUEST['id']); ?>" type="hidden" name="id">
					<input value="<?php echo ($senha); ?>" type="hidden" name="record">
					<input value="<?php echo ($fileupload); ?>" type="hidden" name="fileuploadrecord">

					<p class="loginTitle">altera cadastro aluno</p>

				<div class="campos">
					<p class="labels">Seu nome</p>
					<input value="<?php echo ($nome); ?>" required type="text" name="nome" autofocus maxlength="60" spellcheck="false" autocomplete="no">
				</div>

				<div class="campos">
					<p class="labels">Seu sobrenome</p>
					<input value="<?php echo ($sobrenome); ?>" required type="text" name="sobrenome" autofocus maxlength="60" spellcheck="false" autocomplete="no">
				</div>

					<div class="campos">
						<p class="labels">Data de nascimento</p>
						<!--<div></div>-->

						<div class="datanascimentobg">

							<div class="dia">
							<select name="dia" required>

								<?php
									for($i = 1; $i < 32; $i++)
									{
										if ($i == $dia)
										{
											if ($i < 10)
											{
												echo ('<option value="'.$i.'" selected>0'.$i.'</option>');
											}
											else
											{
												echo ('<option value="'.$i.'" selected>'.$i.'</option>');
											}
										}
										else
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

									}

								?>
							</select>

						</div>

						<div class="mes">

							<select name="mes" required>

								<?php
									for($i = 1; $i < 13; $i++)
									{
										$dateObj   = DateTime::createFromFormat('m', $i);
										$dateObj->setTimezone(new DateTimeZone('America/Sao_Paulo'));
										$monthName = $dateObj->format('F');

										if ($i == $mes)
										{
											echo ('<option value="'.$i.'" selected>'.substr($monthName, 0, 3).'</option>');
										}
										else
										{
											echo ('<option value="'.$i.'">'.substr($monthName, 0, 3).'</option>');
										}

									}

								?>
							</select>

						</div>

						<div class="ano">

							<select name="ano" required>
								<?php
									for($i = date('Y'); $i > (date('Y')-100); $i--)
									{
										if ($i == $ano)
										{
											echo ('<option value="'.$i.'" selected>'.$i.'</option>');
										}
										else
										{
											echo ('<option value="'.$i.'">'.$i.'</option>');
										}
									}
								?>
							</select>

						</div>
					</div>

				</div>

				<div class="campos">
					<p class="labels">Sexo</p>
					<select name="sexo" required>
						<option value="<?php echo ($sexo); ?>" selected><?php echo ($sexo); ?></option>
						<option value="Feminino">Feminino</option>
						<option value="Masculino">Masculino</option>
					</select>
				</div>

				<div class="campos">
					<p class="labels">Seu e-mail</p>
					<input value="<?php echo ($email); ?>" required type="email" name="email" maxlength="200" spellcheck="false" autocomplete="no">
				</div>

				<div class="campos">
					<p class="labels">Seu telefone - formato: (xx)xxx-xxxx</p>
					<input value="<?php echo ($fone); ?>" required type="fone" name="fone" maxlength="12" spellcheck="false" autocomplete="no" value="(16)333-4444">
				
				</div>

				<div class="campos">
					<p class="labels">Seu endereço</p>
					<input value="<?php echo ($endereco); ?>" required type="endereco" name="endereco" maxlength="200" spellcheck="false" autocomplete="no">
				</div>

				<div class="campos">
					<p class="labels">Sua cidade</p>
					<input value="<?php echo ($cidade); ?>" required type="cidade" name="cidade" maxlength="200" spellcheck="false" autocomplete="no">
				</div>

				<div class="campos">
					<p class="labels">Estado</p>
					<select name="uf" required>
						<?php echo ('<option value="'.$uf.'" selected>'.$uf.'</option>'); ?>
						<?php include('./estados.php'); ?>
					</select>
				</div>

				<div class="campos">
					<p class="labels">País</p>
					<select name="pais" required>
						<?php
							include('./paises.php');

							if (isset($pais) && $pais != '')
							{
								echo ('<option value="'.$pais.'" selected="selecte">'.$pais.'</option>');
							}

						?>


						
					</select>

				</div>

				<div class="campos">
					<p class="labels">Nome da universidade - Ex. USP</p>
					<input value="<?php echo ($universidade); ?>" required type="text" name="universidade" autofocus maxlength="60" spellcheck="false" autocomplete="no">
				</div>

				<div class="campos">
					<p class="labels">Curso</p>
					<select name="curso" required>
						<?php echo ('<option value="'.$curso.'" selected>'.$curso.'</option>'); ?>
						<option value="Graduação">Graduação</option>
						<option value="Pós-Graduação">Pós-Graduação</option>
						<option value="Doutorado">Doutorado</option>
					</select>

				</div>

				<div class="campos">
					<p class="labels">Área do estudo - Ex. Direito</p>
					<input value="<?php echo ($areadoestudo); ?>" required type="text" name="areadoestudo" autofocus maxlength="60" spellcheck="false" autocomplete="no">
				</div>

				<div class="campos">
					<p class="labels">Ano de início</p>
					<select name="anodeinicio" required>
						
						<?php echo ('<option value="'.$anodeinicio.'" selected>'.$anodeinicio.'</option>'); ?>

							<?php
								
								for($i = date('Y'); $i > (date('Y')-100); $i--)
								{
									echo ('<option value="'.$i.'">'.$i.'</option>');
								}
							?>

						</select>


				</div>


				<div class="campos">
					<p class="labels">Disciplinas total</p>
					<input value="<?php echo ($disciplinastotal); ?>" required type="text" name="disciplinastotal" maxlength="60" spellcheck="false" autocomplete="no">
				</div>


				<div class="campos">
					<p class="labels">Nova senha - Min 6 / Max 20</p>
					<input type="password" name="senha" maxlength="20" spellcheck="false" autocomplete="no" placeholder="Nova senha - Min 6 / Max 20">
				</div>

				<div class="campos">
					<p class="labels">Repita sua senha</p>
					<input type="password" name="repitasenha" maxlength="20" spellcheck="false" autocomplete="no" placeholder="Repita sua senha">
				</div>

				<div></div>

						<button class="bt" alt="Click para autenticar" title="Click para autenticar"  id="send_login_">atualizar</button>
				

			</form>

						<button class="bt" alt="Click para autenticar" title="Click para autenticar"  id="send_login_"><a href="./painelaluno.php?page=listadeestudante">voltar</a></button>


			    <div id="rs_login" class="hidden">

					<div class="loader">loading</div>

				<div class="centralizaconteudo">
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
	  //formData.append('file', fileupload.files[0]);
	 	

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
					//window.location.href = resultado[1];
					window.location.reload();

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
<script type="text/javascript" src="./js/sessao.js"></script>