	<?php

		include('./conexao.php');

		$conexao = conexao();

		$busca = $conexao->prepare("select * from tb_alunos where (id = :id) limit 1");

		$busca->bindParam('id', $_SESSION['id']);


		$busca->execute();

		$retorno = $busca->fetch(PDO::FETCH_OBJ);

		$id = $retorno->id;
		$nome = $retorno->nome;
		$sobrenome = $retorno->sobrenome;
		$dataNascimento = explode('-', $retorno->dataNascimento);
		$dia = $dataNascimento[2];
		$mes = $dataNascimento[1];
		$ano = $dataNascimento[0];
		$sexo = $retorno->sexo;
		$universidade = $retorno->universidade;
		$curso = $retorno->curso;
		$areadoestudo = $retorno->areadoestudo;

?>
			<form onsubmit="return false;" name="cadastra_fiscal" id="cadastra_fiscal" action="./lanca_notas_sql.php" method="post" autocomplete="off" enctype="multipart/form-data">

					<p class="loginTitle">lançar notas</p>

				<div class="campos">
					<p class="labels">Seu nome</p>
					<input readonly="readonly" value="<?php echo ($nome); ?>" required type="text" name="nome" maxlength="60" spellcheck="false" autocomplete="no">
				</div>

				<div class="campos">
					<p class="labels">Seu sobrenome</p>
					<input readonly="readonly" value="<?php echo ($sobrenome); ?>" required type="text" name="sobrenome" maxlength="60" spellcheck="false" autocomplete="no">
				</div>

					<div class="campos">
						<p class="labels">Data de nascimento</p>
						<!--<div></div>-->

						<div class="datanascimentobg">

							<div class="dia">


							<select name="dia" required>

								<?php
											if ($dia < 10)
											{
												echo ('<option value="'.$dia.'" selected>0'.$dia.'</option>');
											}
											else
											{
												echo ('<option value="'.$dia.'" selected>'.$dia.'</option>');
											}
								?>
							</select>

						</div>

						<div class="mes">

							<select name="mes" required>

								<?php

									$dateObj   = DateTime::createFromFormat('m', $mes);
									$dateObj->setTimezone(new DateTimeZone('America/Sao_Paulo'));
									$monthName = $dateObj->format('F');

									echo ('<option value="'.$mes.'" selected>'.substr($monthName, 0, 3).'</option>');
								?>
							</select>

						</div>

						<div class="ano">

							<select name="ano" required>
								<?php
									echo ('<option value="'.$ano.'" selected>'.$ano.'</option>');
								?>
							</select>

						</div>
					</div>

				</div>

				<div class="campos">
					<p class="labels">Sexo</p>
					<select name="sexo" required>
						<option value="<?php echo ($sexo); ?>" selected><?php echo ($sexo); ?></option>
					</select>
				</div>

				<div class="campos">
					<p class="labels">Nome da universidade - Ex. USP</p>
					<input readonly="readonly" value="<?php echo ($universidade); ?>" required type="text" name="universidade" maxlength="60" spellcheck="false" autocomplete="no">
				</div>

				<div class="campos esquerdaalinha">
					<p class="labels">Curso</p>
					<select name="curso">
						<?php echo ('<option value="'.$curso.'" selected>'.$curso.'</option>'); ?>
					</select>

				</div>

				<div class="campos">
					<p class="labels">Área do estudo - Ex. Direito</p>
					<input readonly="readonly" value="<?php echo ($areadoestudo); ?>" required type="text" name="areadoestudo" maxlength="60" spellcheck="false" autocomplete="no">
				</div>

				<div class="campos esquerdaalinha">
					<p class="labels">Período</p>
					<select name="periodo" required>
					<?php

						$identificaperiodo = $_REQUEST['id'];

						$busca = $conexao->prepare("select * from tb_uploads where (id = :id)");

						$busca->bindParam('id', $identificaperiodo);


						$busca->execute();

						$retorno = $busca->fetch(PDO::FETCH_OBJ);

							$idperiodo = $retorno->id;
							$periodo = $retorno->periodo;
							//$disciplinastotal = $retorno->disciplinastotal;
							$disciplinasmatriculados = $retorno->disciplinasmatriculados;
							$disciplinasaprovados = $retorno->disciplinasaprovados;

							if ($disciplinasaprovados != '' && $disciplinasmatriculados != '')
							{
								$disciplinaspendentes = $disciplinasmatriculados - $disciplinasaprovados;
							}
							else
							{
								$disciplinaspendentes = $retorno->disciplinaspendentes;
							}



							echo ('<option value="'.$idperiodo.'" selected>'.$periodo.'</option>');
					?>
					</select>
				</div>


				<div class="campos">
					<p class="labels">Disciplinas matriculados</p>
					<input value="<?php echo ($disciplinasmatriculados);?>" required type="text" name="disciplinasmatriculados" maxlength="60" spellcheck="false" autocomplete="no" autofocus>
				</div>

				<div class="campos">
					<p class="labels">Disciplinas aprovados</p>
					<input value="<?php echo ($disciplinasaprovados);?>" required type="text" name="disciplinasaprovados" maxlength="60" spellcheck="false" autocomplete="no">
				</div>

				<div class="campos">
					<p class="labels">Disciplinas pendentes</p>
					<input value="<?php echo ($disciplinaspendentes);?>" required type="text" name="disciplinaspendentes" maxlength="60" spellcheck="false" autocomplete="no" readonly="readonly">
				</div>

				<div></div>

						<button class="bt" alt="Click para autenticar" title="Click para autenticar"  id="send_login_">cadastrar</button>

			</form>

						<button class="bt" alt="Click para cancelar" title="Click para cancelar"  id="send_login_"><a href="./painelaluno.php?page=lanca_notas">voltar</a></button>


			    <div id="rs_login" class="hidden">

					<div class="loader">loading</div>

				<div class="centralizaconteudo">
					<div id="rss_log"></div>
				</div>

			    </div>


<script type="text/javascript">
	

var form = document.getElementById('cadastra_fiscal');


form.addEventListener('submit', function(e)
{
	  e.preventDefault();

	  var url_checker = this.action;
	 
	  var formData = new FormData(this);
	 	

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
