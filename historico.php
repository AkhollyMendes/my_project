
	<p class="loginTitle">histórico</p>


	<div class="historico">

		<!--<div class="nomedoarquivo coluna">nome do arquivo</div>

		<div class="arquivo coluna">ações</div>-->

		<div>&nbsp;</div>

	<?php

		include('./conexao.php');

		$conexao = conexao();

		$busca = $conexao->prepare("select * from tb_uploads where (periodo != '' AND anoletivo != '' AND fileupload != '' AND aluno = :aluno)");

		$busca->bindParam('aluno', $_SESSION['id']);


		$busca->execute();

		for ($i = 0; $i < $busca->rowcount(); $i++)
		{
			$retorno = $busca->fetch(PDO::FETCH_OBJ);

			$periodo = $retorno->periodo;
			$anoletivo = $retorno->anoletivo;
			$fileupload = $retorno->fileupload;

			echo ('<div class="nomedoarquivo coluna">'.$periodo.' - '.$anoletivo.'</div>');
			echo ('<div class="arquivo coluna"><a href="./pdf/'.$fileupload.'" target="_blank"><div class="acoesdownload coluna">download</div></a><div class="acoesdelete coluna" id="delete" onclick="opdelete(');
				echo ("'".$retorno->id."',");
				echo ("'".$fileupload."');");
				echo ('")>delete</div></div>');
				echo ("<div></div><div>&nbsp;</div><div>&nbsp;</div>");
		}

?>


	</div>

		<div>&nbsp;</div>
		<div>&nbsp;</div>

		<button class="bt" alt="Click para cancelar" title="Click para cancelar"  id="send_login_"><a href="./painelaluno.php">voltar</a></button>


			    <div id="rs_login" class="hidden">

					<div class="loader">loading</div>

					<div class="centralizaconteudo">
						<div id="rss_log" class="rss_log"></div>
					</div>

			    </div>

			    <div id="rs_delete" class="hidden">

					<div class="loader"></div>

					<div class="centralizaconteudo">
						<div class="rss_del rss_delconfirm" data="" dataimg="" id="confirmadeletar">deletar?</div>
						<div class="rss_del rss_delcancela" onclick="cancela();">cancelar</div>
					</div>

			    </div>


<script type="text/javascript">

	function cancela()
	{
    	document.getElementById('rs_delete').classList.add('hidden');
	}

	function opdelete(rsid, rsimg)
    {
    	document.getElementById('rs_delete').classList.remove('hidden');

    	var divdel = document.getElementById('confirmadeletar');

    	divdel.setAttribute("data", rsid);
    	divdel.setAttribute("dataimg", rsimg);
    }

</script>

<script type="text/javascript">
	

var del = document.getElementById('confirmadeletar');


del.addEventListener('click', function(e)
{
	  e.preventDefault();

	  document.getElementById('rs_delete').classList.add('hidden');

	  var url_checker = 'delete_historico.php?id=' + this.getAttribute("data") + '&rsimg=' + this.getAttribute("dataimg");
	 	 	
	  var ajax = new XMLHttpRequest();

	  ajax.open("GET", url_checker, true);

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
			else
			{
				window.location.reload();
			}
	    }
	    else
	    {
	      div.innerHTML = "Error. Contact System Administrator.";
	    }
	  };

  ajax.send();

});

</script>
<script type="text/javascript" src="./js/sessao.js"></script>