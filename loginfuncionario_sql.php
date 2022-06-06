<?php

	extract($_POST);

	if ($_POST && chop($login) != '' && strlen($login) > 3 && strlen($login) < 61 && strpos($login, '@') != false && chop($senha) != '' && strlen($senha) > 5 && strlen($senha) < 21)
	{
		$senha = md5($senha.'criptokey');

		include('./conexao.php');

		$conexao = conexao();

		$busca = $conexao->prepare("select id, nome, email, senha, nivel, fileupload, sexo from tb_funcionarios where (email = :email && senha = :senha) limit 1");

		$busca->bindParam('email', $login);
		$busca->bindParam('senha', $senha);

		$busca->execute();

		$retorno = $busca->fetch(PDO::FETCH_OBJ);


		if ($busca->rowcount() == 1)
		{
			session_start();
			
			$_SESSION['id'] = $retorno->id;
			$_SESSION['nome'] = $retorno->nome;
			$_SESSION['nivel'] = $retorno->nivel;

			if ($retorno->fileupload != '')
			{
				$_SESSION['img'] = './img/'.$retorno->fileupload;
			}
			else
			{
				if ($retorno->sexo == "Feminino")
				{
						$_SESSION['img'] = './layout/634611.png';
				}
				else
				{
					$_SESSION['img'] = './layout/634620.png';
				}
			}


			echo ('|||painelfuncionario.php');
		}
		else
		{
			echo ('<div class="rss_log vermelho">Verifique os dados!</div>');//mesagem para o ususario
			echo ('|||0');
		}
	}
	else
	{
		echo ('<div class="rss_log vermelho">Verifique os dados!</div>');//mesagem para o ususario
		echo ('|||0');
	}


?>