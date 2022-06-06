<?php
include('./seg.php');

	extract($_POST);

if (isset($senha) && chop($senha) != '' && $senha != $repitasenha)
{
	echo ('<div class="rss_log vermelho">Verifique as senhas digitadas.</div>');//mesagem para o ususario
	echo ('|||0');
}
else
{

	if ($_POST && chop($nome) != '' && strlen($nome) > 1 && strlen($nome) < 60 && chop($sobrenome) != '' && strlen($sobrenome) > 1 && strlen($sobrenome) < 60 && is_numeric($dia) && is_numeric($mes) && is_numeric($ano) && $sexo != '' && strpos($email, '@') !== false && is_numeric(preg_replace("/[^0-9]/", "", $fone)) && chop($endereco) != '' && strlen($endereco) > 3 && strlen($endereco) < 201 && chop($cidade) != '' && strlen($cidade) > 3 && strlen($cidade) < 201 && $uf != '' && $pais != '')
	{
		$nome = $nome;
		$sobrenome = $sobrenome;
		$dia = $dia;
		$mes = $mes;
		$ano = $ano;
		$dataNascimento = date($ano.'-'.$mes.'-'.$dia);
		$sexo = $sexo;
		$email = $email;
		$fone = preg_replace("/[^0-9]/", "", $fone);
		$endereco = $endereco;
		$cidade = $cidade;
		$uf = $uf;
		$pais = $pais;

		if (isset($senha) && chop($senha) != '' && strlen($senha) > 5 && strlen($senha) < 21 && $senha == $repitasenha)
		{
			$senha = md5($senha.'criptokey');
		}
		else
		{
			$senha = $record;
		}

			$erro = null;

		if (isset($_FILES['file']))
		{
		    $filenome = $_FILES['file']['name'];
		    $temp = $_FILES['file']['tmp_name'];

		    $extensoes = array(".jpeg", ".jpg", ".png");

		    $caminho = "./img/";

		    if (!in_array(strtolower(strrchr($filenome, ".")), $extensoes))
		    {
				$erro = 1;
				$fileupload = '';
			}

		    if ($erro != 1) 
		    {
		        $nomeAleatorio = md5(uniqid(time())).strrchr($filenome, ".");

		        $fileupload = $nomeAleatorio;

		        if (!move_uploaded_file($temp, $caminho.$nomeAleatorio))
		        {
		            $erro = 2;
		            $fileupload = '';
		        }
		    }
		}
		else
		{
			$fileupload = $fileuploadrecord;
		}


		$pin = '';
		$validade = '';

		include('./conexao.php');

		$conexao = conexao();

		$busca = $conexao->prepare('select id, email, sexo from tb_funcionarios where (email = :email && id != :id)');

		$busca->bindParam('id', $_SESSION['id']);
		$busca->bindParam('email', $email);


		$busca->execute();

		$retorno = $busca->fetch(PDO::FETCH_OBJ);


		if ($busca->rowcount() == 0)
		{
			$atualiza = $conexao->prepare("update tb_funcionarios set nome = :nome, sobrenome = :sobrenome, dataNascimento = :dataNascimento, sexo = :sexo, email = :email, fone = :fone, endereco = :endereco, cidade = :cidade, uf = :uf, pais = :pais, fileupload = :fileupload, senha = :senha where (id = :id) ");



			$atualiza->bindParam('id', $_SESSION['id']);
			$atualiza->bindParam('nome', $nome);
			$atualiza->bindParam('sobrenome', $sobrenome);
			$atualiza->bindParam('dataNascimento', $dataNascimento);
			$atualiza->bindParam('sexo', $sexo);
			$atualiza->bindParam('email', $email);
			$atualiza->bindParam('fone', $fone);
			$atualiza->bindParam('endereco', $endereco);
			$atualiza->bindParam('cidade', $cidade);
			$atualiza->bindParam('uf', $uf);
			$atualiza->bindParam('pais', $pais);
			$atualiza->bindParam('fileupload', $fileupload);
			$atualiza->bindParam('senha', $senha);

			$atualiza->execute();


			if ($atualiza)
			{
				$_SESSION['nome'] = $nome;

				$imgprofile = $conexao->prepare('select fileupload from tb_funcionarios where (id = :id)');

				$imgprofile->bindParam('id', $_SESSION['id']);

				$imgprofile->execute();

				$newimg = $imgprofile->fetch(PDO::FETCH_OBJ);

				if ($newimg->fileupload != '')
				{
					$_SESSION['img'] = './img/'.$newimg->fileupload;
				}
				else
				{
					if ($sexo == "Feminino")
					{
						echo ($sexo);
						$_SESSION['img'] = './layout/634611.png';
					}
					else
					{
						$_SESSION['img'] = './layout/634620.png';
					}
				}


				echo ('<div class="rss_log">Atualização realizada com sucesso!</div>');//mesagem para o ususario

				echo ('|||painelfuncionario.php');//para onde o sistema será direcionado
			}
		}
		else
		{
			echo ('<div class="rss_log vermelho">Dados já existem, aguarde...</div>');//mesagem para o ususario

			echo ('|||painelfuncionario.php');//para onde o sistema será direcionado
		}

	}
}
?>

