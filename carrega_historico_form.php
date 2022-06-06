
			<form onsubmit="return false;" name="cadastra_fiscal" id="cadastra_fiscal" action="./carrega_historico_sql.php" method="post" autocomplete="off" enctype="multipart/form-data">

						<p class="loginTitle">Carregar histórico</p>

				<div class="campos">
					<p class="labels">Período</p>
					<select name="periodo" required>
						
						<option value="" selected>Escolhe o período</option>

							<?php

								include('./conexao.php');

								$conexao = conexao();


								for($i = 1; $i < 13; $i++)
								{
									switch($i)
									{
										case 1:
										$p = 'I Período';
										break;

										case 2:
										$p = 'II Período';
										break;

										case 3:
										$p = 'III Período';
										break;

										case 4:
										$p = 'IV Período';
										break;

										case 5:
										$p = 'V Período';
										break;

										case 6:
										$p = 'VI Período';
										break;

										case 7:
										$p = 'VII Período';
										break;

										case 8:
										$p = 'VIII Período';
										break;

										case 9:
										$p = 'IX Período';
										break;

										case 10:
										$p = 'X Período';
										break;

										case 11:
										$p = 'XI Período';
										break;

										case 12:
										$p = 'XII Período';
										break;

										default:

										$p = '';

									}

									$peridors = $conexao->prepare("select * from tb_uploads where (aluno = :aluno AND periodo = :periodo) ");

									$peridors->bindParam("aluno", $_SESSION['id']);
									$peridors->bindParam("periodo", $p);

									$peridors->execute();

									if ($peridors->rowcount() == 0)
									{
											echo ('<option value="'.$p.'">'.$p.'</option>');
									}
								}
							?>

						</select>


				</div>

				<div class="campos">
					<p class="labels">Ano letivo - Ex. 2021/1</p>
					<input required type="text" name="anoletivo" maxlength="60" spellcheck="false" autocomplete="false">
				</div>


				<div class="campos">
					
					<p class="labels">Escolha o arquivo</p>
					<div class="input-wrapper">
					  <label for="fileupload">
					    Click para o arquivo
					  </label>
					  <input required id="fileupload" type="file" name="fileupload" onchange="muda();">
					</div>

				</div>

				<div class="campos">
		
					<div id="file-name" class="file-name">Arquivo <strong>pdf</strong>. Max 1mb</div>

				</div>


				<div></div>

						<button class="bt" alt="Click para autenticar" title="Click para autenticar"  id="send_login_">cadastrar</button>


			</form>

						<button class="bt" alt="Click para cancelar" title="Click para cancelar"  id="send_login_"><a href="./painelaluno.php">voltar</a></button>


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

</body>
</html>