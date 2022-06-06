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
				<form onsubmit="return false;" action="./loginfuncionario_sql.php" method="post" autocomplete="off" name="formulario_login_" id="formulario_login">


						<div class="cadiadologin"><img src="./layout/icone.jpg"></div>
						<p class="loginTitle">login fiscal</p>

					<div class="campoemail">
						<p class="labels">Seu login</p>
						<input id="login" type="text" name="login" autofocus maxlength="200" spellcheck="false" autocomplete="false" required>
					</div>

					<div></div>

					<div class="campoemail">
						<p class="labels">Sua senha</p>
						<input type="password" name="senha" maxlength="60" spellcheck="false" autocomplete="false" required>
					</div>

					<div></div>
					
						<button class="bt" alt="Click para autenticar" title="Click para autenticar"  id="send_login_">entrar</button>

				</form>

						<button class="bt" alt="Click para autenticar" title="Click para autenticar"  id="send_login_"><a href="./cadastra_funcionario_form.php">sou novo</a></button>

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

	var login_ = document.getElementById("login");
	var btnEnvia = document.getElementById("send_login_");

	var desabilita_enviar = function (event)
	{
	  btnEnvia.disabled = !event.target.value;
	}

	login_.addEventListener("input", desabilita_enviar);
	login_.dispatchEvent(new Event('input'));
	

	var form = document.getElementById('formulario_login');


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
					window.location.href = resultado[1];

				}, 2500);
				
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