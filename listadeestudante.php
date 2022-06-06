<div class="titulototalalunos">lista de estudante</div>



<div class="linha">
			<form onsubmit="return false;" name="buscador" id="buscaalunos" action="./listadeestudante_resultado.php" method="post" autocomplete="off" enctype="multipart/form-data">
				<div class="buscafiltro">
					<p class="labels">Busca</p>
					<input type="text" name="busca" autofocus spellcheck="false" maxlength="60" autocomplete="off">
				</div>

				<div class="buscabt"><button onclick="btbusca();">buscar</button></div>
			</form>
</div>


			    <div id="rs_busca" class="">

					<div id="rs_resposta">
						<?php include('./listadeestudante_resultado.php'); ?>

					</div>

			    </div>

			    <div id="rs_delete" class="hidden">

					<div class="loader"></div>

					<div class="centralizaconteudo">
						<div class="rss_del rss_delconfirm" data="" dataimg="" id="confirmadeletar">arquivar?</div>
						<div class="rss_del rss_delcancela" onclick="cancela();">cancelar</div>
					</div>

			    </div>


			    <div id="rs_deletealuno" class="hidden">

					<div class="loader"></div>

					<div class="centralizaconteudo">
						<div class="rss_del rss_delconfirm" data="" id="confirmadeletaraluno">arquivar?</div>
						<div class="rss_del rss_delcancela" onclick="cancela();">cancelar</div>
					</div>

			    </div>


<script type="text/javascript">
	

function btbusca()
{

	var form = document.getElementById('buscaalunos');


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
				var div = document.getElementById('rs_resposta');

				div.innerHTML = ii_l;

			}


		    if (ajax.status == 200)
		    {
		    	document.getElementById('rs_busca').classList.remove('hidden');

		    	var resultado = ajax.responseText.split("|||");

				msg_log(resultado[0]);

				if (resultado[1] != 0)
				{
				}
		    }
		    else
		    {
		      div.innerHTML = "Error. Contact System Administrator.";
		    }
		  };

	  ajax.send(formData);

	});
}
</script>

<script type="text/javascript">

	function cancela()
	{
    	document.getElementById('rs_delete').classList.add('hidden');
    	document.getElementById('rs_deletealuno').classList.add('hidden');
	}

	function opdelete(rsid, rsimg)
    {
    	document.getElementById('rs_delete').classList.remove('hidden');

    	var divdel = document.getElementById('confirmadeletar');

    	divdel.setAttribute("data", rsid);
    	divdel.setAttribute("dataimg", rsimg);
    }


	function opdeletealuno(rsidaluno)
    {

    	document.getElementById('rs_deletealuno').classList.remove('hidden');

    	var divdelaluno = document.getElementById('confirmadeletaraluno');

    	divdelaluno.setAttribute("data", rsidaluno);
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


<script type="text/javascript">
	

var del = document.getElementById('confirmadeletaraluno');


del.addEventListener('click', function(e)
{
	  e.preventDefault();

	  document.getElementById('rs_delete').classList.add('hidden');

	  var url_checker = 'delete_aluno.php?id=' + this.getAttribute("data");
	 	 	
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