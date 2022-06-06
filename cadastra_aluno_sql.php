<?php

	extract($_POST);

if (isset($senha) && chop($senha) != '' && $senha != $repitasenha)
{
	echo ('<div class="rss_log vermelho">Verifique as senhas digitadas.</div>');//mesagem para o ususario
	echo ('|||0');
}
else
{

	if ($_POST && chop($nome) != '' && strlen($nome) > 1 && strlen($nome) < 60 && chop($sobrenome) != '' && strlen($sobrenome) > 1 && strlen($sobrenome) < 60 && is_numeric($dia) && is_numeric($mes) && is_numeric($ano) && $sexo != '' && strpos($email, '@') !== false && is_numeric(preg_replace("/[^0-9]/", "", $fone)) && chop($endereco) != '' && strlen($endereco) > 3 && strlen($endereco) < 201 && chop($cidade) != '' && strlen($cidade) > 3 && strlen($cidade) < 201 && $uf != '' && $pais != '' && chop($universidade) != '' && strlen($universidade) > 2 && strlen($universidade) < 201 && chop($curso) != '' && strlen($curso) > 3 && strlen($curso) < 21 && chop($areadoestudo) != '' && strlen($areadoestudo) > 2 && strlen($areadoestudo) < 201 && chop($anodeinicio) != '' && strlen($anodeinicio) > 3 && strlen($anodeinicio) < 6 && chop($senha) != '' && strlen($senha) > 5 && strlen($senha) < 21 && $senha == $repitasenha)
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
		$universidade = $universidade;
		$curso = $curso;
		$areadoestudo = $areadoestudo;
		$anodeinicio = $anodeinicio;

		if (chop($disciplinastotal) == '')
		{
			$disciplinastotal = 0;
		}

		if (!is_numeric($disciplinastotal))
		{
			$disciplinastotal = 0;
		}

		$senha = md5($senha.'criptokey');
		$nivel = 5;//nivel alunos


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

		$busca = $conexao->prepare("select email from tb_alunos where (email = :email)");

		$busca->bindParam('email', $email);


		$busca->execute();

		$retorno = $busca->fetchAll();


		if ($busca->rowcount() == 0)
		{
			$cadastra = $conexao->prepare("insert into tb_alunos (nome, sobrenome, dataNascimento, sexo, email, fone, endereco, cidade, uf, pais, universidade, curso, areadoestudo, anodeinicio, disciplinastotal, fileupload, senha, pin, validade, nivel) values(:nome, :sobrenome, :dataNascimento, :sexo, :email, :fone, :endereco, :cidade, :uf, :pais, :universidade, :curso, :areadoestudo, :anodeinicio, :disciplinastotal, :fileupload, :senha, :pin, :validade, :nivel) ");


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
			$cadastra->bindParam('universidade', $universidade);
			$cadastra->bindParam('curso', $curso);
			$cadastra->bindParam('areadoestudo', $areadoestudo);
			$cadastra->bindParam('anodeinicio', $anodeinicio);
			$cadastra->bindParam('disciplinastotal', $disciplinastotal);
			$cadastra->bindParam('fileupload', $fileupload);
			$cadastra->bindParam('senha', $senha);
			$cadastra->bindParam('pin', $pin);
			$cadastra->bindParam('validade', $validade);
			$cadastra->bindParam('nivel', $nivel);

			$cadastra->execute();


			if ($cadastra)
			{
				echo ('<div class="rss_log">Cadastro realizado com sucesso!</div>');//mesagem para o ususario

				echo ('|||painelfuncionario.php');//para onde o sistema será direcionado
			}
		}
		else
		{
			echo ('<div class="rss_log vermelho">Dados já existem, aguarde...</div>');//mesagem para o ususario

			echo ('|||painelfuncionario.php');//para onde o sistema será direcionado
		}

	}
	else
	{
		echo ('<div class="rss_log vermelho">Verifique os dados. Todos os campos são obrigatório.</div>');//mesagem para o ususario
		echo ('|||0');//para onde o sistema será direcionado
	}
}
?>

