<?php
	
	use Dompdf\Dompdf;
	include('./dompdf/autoload.inc.php');

if (isset($_REQUEST['id']))
{
	$id = $_REQUEST['id'];


	include('./conexao.php');

	$conexao = conexao();

	$buscaalunos = $conexao->prepare("select * from tb_uploads where (id = :id)");

	$buscaalunos->bindParam('id', $id);


	$buscaalunos->execute();

	$retornoalunos = $buscaalunos->fetch(PDO::FETCH_OBJ);

	$alunoid = $retornoalunos->aluno;
	$periodo = $retornoalunos->periodo;
	//$disciplinastotal = $retornoalunos->disciplinastotal;
	$disciplinasaprovados = $retornoalunos->disciplinasaprovados;
	$disciplinasmatriculados = $retornoalunos->disciplinasmatriculados;
	$disciplinaspendentes = $retornoalunos->disciplinaspendentes;


		$busca = $conexao->prepare("select * from tb_alunos where (id = :id)");

		$busca->bindParam('id', $alunoid);

		$busca->execute();

		$retorno = $busca->fetch(PDO::FETCH_OBJ);

		$alunoide = $retorno->id;
		$nomealuno = trim($retorno->nome);
		$sobrealuno = trim($retorno->sobrenome);

		$disciplinaspendentes = $disciplinasmatriculados - $disciplinasaprovados;



		$conteudo = '<h1 style="text-align: left; color: #f00; font-family: verdana;">'.$nomealuno.' '.$sobrealuno.'</h1><br>';
		$conteudo .= '<h2>Período: '. $periodo.'</h2><br>';
		//$conteudo .= '<h2>Disciplinas total: '. $disciplinastotal.'</h2><br>';
		$conteudo .= '<h2>Disciplinas matriculados: '. $disciplinasmatriculados.'</h2><br>';
		$conteudo .= '<h2>Disciplinas aprovados: '. $disciplinasaprovados.'</h2><br>';
		$conteudo .= '<h2>Disciplinas reprovados: '. $disciplinaspendentes.'</h2>';

	
	$dompdf = new Dompdf();
	$dompdf->loadHtml($conteudo);

	$dompdf->setPaper('A4', 'landscape');

	$dompdf->render();

	$dompdf->stream($nomealuno.'-'.$sobrealuno, array("Attachment"=>true));
	
}


?>