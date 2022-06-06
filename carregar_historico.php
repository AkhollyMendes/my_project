<div class="centralizaconteudo">
				<div class="campos">
					<p class="loginTitle">histórico</p>
				</div>

				<div class="historico">
					<div class="nomedoarquivo coluna">nome do arquivo</div>
					<div class="arquivo coluna">ações</div>

	<?php

		include('./conexao.php');

		$conexao = conexao();

		$busca = $conexao->prepare("select * from tb_uploads where (aluno = :aluno)");

		$busca->bindParam('aluno', $_SESSION['id']);


		$busca->execute();

		for ($i = 0; $i < $busca->rowcount(); $i++)
		{
			$retorno = $busca->fetch(PDO::FETCH_OBJ);

			$periodo = $retorno->periodo;
			$anoletivo = $retorno->anoletivo;
			$fileupload = $retorno->fileupload;

			echo ('<div class="nomedoarquivo coluna">'.$periodo.' - '.$anoletivo.'</div>');
			echo ('<div class="arquivo coluna"><div class="acoesdelete coluna"><a href="./pdf/'.$fileupload.'" target="_blank">download</a></div><div class="acoesdownload coluna" id="delete" onclick="muda('.$retorno->id.');">delete</div></div>');
		}

?>


				</div>


			<div class="centralizaconteudo">
				<p class="criarConta" alt="Click para retornar" title="Click para retornar"><a href="./painelaluno.php">cancelar</a></p>
			</div>


			    <div id="rs_login" class="hidden">

					<div class="loader">loading</div>

					<div class="centralizaconteudo">
						<div id="rss_log"></div>
					</div>

			    </div>

			    <div id="rs_delete" class="hidden">

					<div class="loader"></div>

					<div class="centralizaconteudo">
						<div class="rss_del" data="" id="confirmadeletar">deletar?</div>
						<div class="rss_del" onclick="cancela();">cancelar</div>
					</div>

			    </div>
</div>

<script type="text/javascript">

	function cancela()
	{
    	document.getElementById('rs_delete').classList.add('hidden');
	}

	function muda(rsid)
    {
    	document.getElementById('rs_delete').classList.remove('hidden');

    	var divdel = document.getElementById('confirmadeletar');

    	divdel.setAttribute("data", rsid);
    }

</script>

<script type="text/javascript">
	

var del = document.getElementById('confirmadeletar');


del.addEventListener('click', function(e)
{
	  e.preventDefault();

	  document.getElementById('rs_delete').classList.add('hidden');

	  var url_checker = 'delete.php?id=' + this.getAttribute("data");
	 	 	
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
					window.location.href = resultado[1];

				}, 4900);
				
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
