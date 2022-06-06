	<div class="header">
		

<?php
	if (!isset($_SESSION))
	{
		session_start();
	}

	if (!isset($_SESSION['nivel']))
{
?>
		<a href="./"><div class="logo"><img src="./layout/logo.png"></div></a>

		<div class="entrarcomo">
			<div class="entrarcomotitulo">
				<p>acessar como</p>
				<div class="menuhover">
					<a href="./acessoaluno.php"><div class="entrarcomo">aluno</div></a>
					<a href="./acesso_funcionario.php"><div class="entrarcomo">fiscal</div></a>
				</div>
			</div>
		</div>

<?php
}

if (isset($_SESSION['nivel']))
{
	echo ('<div class="usernamelog">Olá, '.$_SESSION['nome'].'</div>');

	if ($_SESSION['nivel'] == 5)
	{
		echo ('<a href="./'.basename($_SERVER['PHP_SELF']).'?page=altera_aluno_form"><div class="usernameimg"><img src="'.$_SESSION['img'].'"></div></a>');

		echo ('<a href="./painelaluno.php"><div class="logo"><img src="./layout/logo.png"></div></a>');
	}

	if ($_SESSION['nivel'] == 1)
	{
		echo ('<a href="./'.basename($_SERVER['PHP_SELF']).'?page=altera_funcionario_form"><div class="usernameimg"><img src="'.$_SESSION['img'].'"></div></a>');

		echo ('<a href="./painelfuncionario.php"><div class="logo"><img src="./layout/logo.png"></div></a>');
	}

//	echo ('<div class="menumobile" id="menumobile" onclick="init()">menu</div>');
}

?>
	</div>
