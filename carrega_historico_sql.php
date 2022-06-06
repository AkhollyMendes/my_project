<?php
include('./seg.php');
	extract($_POST);

	if ($_POST && $periodo != '' && chop($anoletivo) != '' && strlen($anoletivo) > 1 && strlen($anoletivo) < 20 && isset($_FILES['file']))
	{
		$periodo = $periodo;
		$anoletivo = $anoletivo;


		$erro = null;

		if (isset($_FILES['file']))
		{
		    $filenome = $_FILES['file']['name'];
		    $temp = $_FILES['file']['tmp_name'];

		    $extensoes = array(".pdf");

		    $caminho = "./pdf/";

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


		if ($fileupload != '')
		{
			$aluno = $_SESSION['id'];

			include('./conexao.php');

			$conexao = conexao();

			$disciplinasaprovados = 0;
			$disciplinasmatriculados = 0;
			$disciplinaspendentes = 0;


			$cadastra = $conexao->prepare("insert into tb_uploads (aluno, periodo, anoletivo, fileupload, disciplinasaprovados, disciplinasmatriculados, disciplinaspendentes) values(:aluno, :periodo, :anoletivo, :fileupload, :disciplinasaprovados, :disciplinasmatriculados, :disciplinaspendentes) ");


			$cadastra->bindParam('aluno', $aluno);
			$cadastra->bindParam('periodo', $periodo);
			$cadastra->bindParam('anoletivo', $anoletivo);
			$cadastra->bindParam('fileupload', $fileupload);
			$cadastra->bindParam('disciplinasaprovados', $disciplinasaprovados);
			$cadastra->bindParam('disciplinasmatriculados', $disciplinasmatriculados);
			$cadastra->bindParam('disciplinaspendentes', $disciplinaspendentes);

			$cadastra->execute();


			if ($cadastra)
			{
				echo ('<div class="rss_log">Seu histórico enviado com sucesso!</div>');//mesagem para o ususario

				echo ('|||painelaluno.php');//para onde o sistema será direcionado
			}
		}
		else
		{
			echo ('<div class="rss_log vermelho">Verifique os dados. Todos os campos são obrigatório.</div>');//mesagem para o ususario

			echo ('|||0');//para onde o sistema será direcionado
		}

	}
	else
	{
		echo ('<div class="rss_log vermelho">Verifique os dados. Todos os campos são obrigatório.</div>');//mesagem para o ususario
		echo ('|||0');//para onde o sistema será direcionado
	}
?>

