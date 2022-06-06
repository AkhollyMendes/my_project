<?php
	use Dompdf\Dompdf;

	include('./dompdf/autoload.inc.php');

if (isset($_REQUEST['id']))
{
	$id = $_REQUEST['id'];


	include('./conexao.php');

	$conexao = conexao();


		$busca = $conexao->prepare("select * from tb_alunos where (id = :id)");

		$busca->bindParam('id', $id);

		$busca->execute();

		$retorno = $busca->fetch(PDO::FETCH_OBJ);

		$alunoide = $retorno->id;
		$nomealuno = $retorno->nome;
		$sobrealuno = $retorno->sobrenome;
		$endereco = $retorno->endereco;
		$cidade = $retorno->cidade;
		$uf = $retorno->uf;
		$pais = $retorno->pais;
		$disciplinastotal = $retorno->disciplinastotal;

		$dataNascimento = explode('-', $retorno->dataNascimento);
		$dia = $dataNascimento[2];
		$mes = $dataNascimento[1];
		$ano = $dataNascimento[0];
		$datanasc = $dia.'/'.$mes.'/'.$ano;

		$sexo = $retorno->sexo;
		$universidade = $retorno->universidade;
		$curso = $retorno->curso;
		$areadoestudo = $retorno->areadoestudo;

		$disciplinasaprovados = 0;
		$disciplinasmatriculados = 0;
		//$disciplinaspendentes = 0;




		$rsb = $conexao->prepare("select * from tb_uploads where (aluno = :aluno)");

		$rsb->bindParam('aluno', $alunoide);

		$rsb->execute();

		for ($ialunosbaixar = 0; $ialunosbaixar < $rsb->rowcount(); $ialunosbaixar++)
		{
			$rb = $rsb->fetch(PDO::FETCH_OBJ);

			$disciplinasaprovados += $rb->disciplinasaprovados;
			//$disciplinasmatriculados += $rb->disciplinasmatriculados;
			//$disciplinaspendentes += $rb->disciplinaspendentes;
		}

			if ($disciplinastotal != '' && $disciplinasaprovados != '')
			{
				$disciplinaspendentes = $disciplinastotal - $disciplinasaprovados;
			}

			if ($disciplinaspendentes == 0)
			{
				$disciplinaspendentes = "concluído";
			}

		$conteudo = '<h1 style="text-align: left; color: #f00; font-family: verdana;">'.$nomealuno.' '.$sobrealuno.'</h1><hr>';
		$conteudo .= '<h4>End: '. $endereco.'&nbsp;&nbsp;&nbsp; Cidade: '.$cidade.'&nbsp;&nbsp;&nbsp; Uf: '.$uf.'&nbsp;&nbsp;&nbsp; País: '.$pais.'</h4>';
		$conteudo .= '<h4>Data nascimento: '. $datanasc.'&nbsp;&nbsp;&nbsp; Sexo: '.$sexo.'&nbsp;&nbsp;&nbsp; Universidade: '.$universidade;
		$conteudo .= '&nbsp;&nbsp;&nbsp; Curso: '.$curso.'&nbsp;&nbsp;&nbsp; Área de estudo: '.$areadoestudo.'</h4>';
		$conteudo .= '<h4>Disciplinas total: '. $disciplinastotal.'</h4>';
		$conteudo .= '<h4>Disciplinas aprovados: '. $disciplinasaprovados.'</h4>';
		//$conteudo .= '<h4>Disciplinas matriculados: '. $disciplinasmatriculados.'</h4>';
		$conteudo .= '<h4>Disciplinas pendentes: '. $disciplinaspendentes.'</h4>';

	
	$dompdf = new Dompdf();
	$dompdf->loadHtml($conteudo);

	$dompdf->setPaper('A4', 'landscape');

	$dompdf->render();

	$dompdf->stream($nomealuno.'-'.$sobrealuno, array("Attachment"=>true));
	
}
?>