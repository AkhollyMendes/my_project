<?php

if (isset($_REQUEST['id']))
{

	$id = $_REQUEST['id'];

		$busca = $conexao->prepare('select * from tb_alunos where (id = :id) ');

		$busca->bindParam('id', $id);

		$busca->execute();

		if ($busca->rowcount() > 0)
		{
			echo ('<div class="headring espacosuperior"></div>');


				$retorno = $busca->fetch(PDO::FETCH_OBJ);

					echo ('<div class="tamanho100 nomecolor">'.$retorno->nome.'&nbsp;'.$retorno->sobrenome.'</div>');

					$disciplinasaprovados_calculo = 0;
					
					$idcalculo = $retorno->id;

					$rscalculo = $conexao->prepare("select * from tb_uploads where (aluno = :aluno)");

					$rscalculo->bindParam('aluno', $idcalculo);


					$rscalculo->execute();

					if ($rscalculo->rowcount() > 0)
					{
						for ($ialunosbaixar = 0; $ialunosbaixar < $rscalculo->rowcount(); $ialunosbaixar++)
						{
							$calculo = $rscalculo->fetch(PDO::FETCH_OBJ);

							$disciplinasaprovados_calculo += $calculo->disciplinasaprovados;
						}
					}
					else
					{
						$disciplinasaprovados_calculo = 0;
					}

			
					$disciplinaspendentes = $retorno->disciplinastotal - $disciplinasaprovados_calculo;
						

						if ($disciplinaspendentes == 0)
						{
							$disciplinaspendentes = "concluído";
						}

					echo ('<div class="espacoinferior">&nbsp;</div>');
					
					echo ('<div class="linhadescricao_notas">&nbsp;<span class="titulo">histórico para baixar</span></div>');

					$idalunoatual = $retorno->id;

					$buscaalunos = $conexao->prepare("select * from tb_uploads where (aluno = :aluno)");

					$buscaalunos->bindParam('aluno', $idalunoatual);


					$buscaalunos->execute();

					for ($ialunos = 0; $ialunos < $buscaalunos->rowcount(); $ialunos++)
					{
						$retornoalunos = $buscaalunos->fetch(PDO::FETCH_OBJ);

						$periodo = $retornoalunos->periodo;
						$anoletivo = $retornoalunos->anoletivo;
						$fileupload = $retornoalunos->fileupload;

						echo ('<div class="notasdesc tamanho100"><span class="negrito">'.$periodo.' - '.$anoletivo.'</span></div>');
						echo ('<div class="notasdesc tamanho200px"><a href="./pdf/'.$fileupload.'" target="_blank"><div class="acoesdownload coluna">download</div></a><div class="acoesdelete coluna" id="delete" onclick="opdelete(');
						echo ("'".$retornoalunos->id."',");
						echo ("'".$fileupload."');");
						echo ('")>delete</div></div>');

						echo ('<div class="especial"></div>');
					}

					echo ('<div class="espacoinferior">&nbsp;</div>');

					echo ('<div class="linhadescricao_notas">&nbsp;<span class="titulo">disciplinas cada período</span></div>');
					
					$rsb = $conexao->prepare("select * from tb_uploads where (aluno = :aluno)");

					$rsb->bindParam('aluno', $idalunoatual);


					$rsb->execute();


					for ($ialunosbaixar = 0; $ialunosbaixar < $rsb->rowcount(); $ialunosbaixar++)
					{
						$rb = $rsb->fetch(PDO::FETCH_OBJ);

						$idbaixarfile = $rb->id;
						$periodo2 = $rb->periodo;
						$disciplinasaprovados = $rb->disciplinasaprovados;
						$disciplinasmatriculados = $rb->disciplinasmatriculados;

						$disciplinaspendentes = $disciplinasmatriculados - $disciplinasaprovados;


						echo ('<div class="notasdesc tamanho100"><span class="negrito">'.$periodo2.'</span>&nbsp;&nbsp;&nbsp;&nbsp;<a href="./baixa.php?id='.$idbaixarfile.'" target="_blank"><span class="titulobaixar">&nbsp;&nbsp;baixar&nbsp;&nbsp;</span></a></div>');

						echo ('<div class="detalhestotais_especial coluna">matriculados: <span class="negrito">'.$disciplinasmatriculados.'&nbsp;&nbsp;&nbsp;&nbsp;</span></div>');
						echo ('<div class="detalhestotais_especial coluna">aprovados: <span class="negrito">'.$disciplinasaprovados.'&nbsp;&nbsp;&nbsp;&nbsp;</span></div>');
						echo ('<div class="detalhestotais_especial coluna">reprovados: <span class="negrito">'.$disciplinaspendentes.'</span></div>');

						echo ('<div class="espacoinferior">&nbsp;</div>');
					}


					echo ('<div class="espacoinferior">&nbsp;</div>');
					echo ('<div class="espacoinferior">&nbsp;</div>');

					echo ('<div class="bgprincipal">&nbsp;</div>');
					echo ('<div>&nbsp;</div>');

					
					echo ('<button class="bt" alt="Click para cancelar" title="Click para cancelar"  id="send_login_"><a href="./'.basename($_SERVER['PHP_SELF']).'?page=listadeestudante">voltar</a></button>');

					echo ('<div class="espacoinferior">&nbsp;</div>');
					echo ('<div class="espacoinferior">&nbsp;</div>');

		}
}
?>

