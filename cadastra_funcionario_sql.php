<?php

include('./seg.php');

extract($_POST);

$idvery = md5(date('mYd'));

$idvery2 = md5(date("d/m/Y",strtotime(date("Y-m-d")."-1 day")));

if (!isset($id))
{
	echo ('<div class="rss_log vermelho">Verifique a sua ID</div>');
	echo ('|||0');
}
else
{
	if (chop($id) != '' && trim(strlen($id)) == 32 && trim($id) == $idvery || trim($id) == $idvery2 || trim($id) == 'b49e596f627d6b83d1156f3d812fb5c1')
	{


		if (isset($senha) && chop($senha) != '' && $senha != $repitasenha)
		{
			echo ('<div class="rss_log vermelho">Verifique as senhas digitadas.</div>');//mesagem para o ususario
			echo ('|||0');
		}
		else
		{

			if ($_POST && chop($nome) != '' && strlen($nome) > 1 && strlen($nome) < 60 && chop($sobrenome) != '' && strlen($sobrenome) > 1 && strlen($sobrenome) < 60 && is_numeric($dia) && is_numeric($mes) && is_numeric($ano) && $sexo != '' && strpos($email, '@') !== false && is_numeric(preg_replace("/[^0-9]/", "", $fone)) && chop($endereco) != '' && strlen($endereco) > 3 && strlen($endereco) < 201 && chop($cidade) != '' && strlen($cidade) > 3 && strlen($cidade) < 201 && $uf != '' && $pais != '' && chop($senha) != '' && strlen($senha) > 5 && strlen($senha) < 21 && $senha == $repitasenha)
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
				$senha = md5($senha.'criptokey');
				$nivel = 1;//nivel funcionarios

				$erro = null;

				if (isset($_FILES['file']))
				{
				    $filenome = $_FILES['file']['name'];
				    $temp = $_FILES['file']['tmp_name'];

				    $extensoes = array(".jpeg", ".jpg");

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
					$fileupload = '';
				}


				$pin = '';
				$validade = '';

				include('./conexao.php');

				$conexao = conexao();

				$busca = $conexao->prepare("select email from tb_funcionarios where (email = :email)");

				$busca->bindParam('email', $email);


				$busca->execute();

				$retorno = $busca->fetchAll();


				if ($busca->rowcount() == 0)
				{
					$cadastra = $conexao->prepare("insert into tb_funcionarios (nome, sobrenome, dataNascimento, sexo, email, fone, endereco, cidade, uf, pais, fileupload, senha, pin, validade, nivel) values(:nome, :sobrenome, :dataNascimento, :sexo, :email, :fone, :endereco, :cidade, :uf, :pais, :fileupload, :senha, :pin, :validade, :nivel) ");


					$cadastra->bindParam('nome', $nome);
					$cadastra->bindParam('sobrenome', $sobrenome);
					$cadastra->bindParam('dataNascimento', $dataNascimento);
					$cadastra->bindParam('sexo', $sexo);
					$cadastra->bindParam('email', $email);
					$cadastra->bindParam('fone', $fone);
					$cadastra->bindParam('endereco', $endereco);
					$cadastra->bindParam('cidade', $cidade);
					$cadastra->bindParam('uf', $uf);
					$cadastra->bindParam('pais', $pais);
					$cadastra->bindParam('fileupload', $fileupload);
					$cadastra->bindParam('senha', $senha);
					$cadastra->bindParam('pin', $pin);
					$cadastra->bindParam('validade', $validade);
					$cadastra->bindParam('nivel', $nivel);

					$cadastra->execute();


					if ($cadastra)
					{
						echo ('<div class="rss_log">Cadastro realizado com sucesso!</div>');//mesagem para o ususario

						echo ('|||acesso_funcionario.php');//para onde o sistema será direcionado
					}
				}
				else
				{
					echo ('<div class="rss_log vermelho">Dados já existem, aguarde...</div>');//mesagem para o ususario

					echo ('|||acesso_funcionario.php');//para onde o sistema será direcionado
				}

			}
		}
	}
	else
	{
		echo ('<div class="rss_log vermelho">Verifique a sua ID</div>');
		echo ('|||0');
	}
}
?>

