<?php

include('./conexao.php');

$conexao = conexao();

if (!isset($_REQUEST['id']))
{

	if ($_POST && chop($_REQUEST['busca']) != '' && strlen($_REQUEST['busca']) > 0)
	{

		$nome = '%'.$_REQUEST['busca'].'%';


			$busca = $conexao->prepare('select * from tb_alunos where ((nome like :nome || sobrenome like :nome || email like :nome || fone like :nome) && pin != "") order by id desc');

			$busca->bindParam('nome', $nome, PDO::PARAM_STR);
	}
	else
	{
			$busca = $conexao->prepare('select * from tb_alunos where (pin != "") order by id desc');
	}
			$busca->execute();

			if ($busca->rowcount() > 0)
			{		
				for ($i = 0; $i < $busca->rowcount(); $i++)
				{
					$retorno = $busca->fetch(PDO::FETCH_OBJ);


					$idlocal = $retorno->id;
					$disciplinastotal = $retorno->disciplinastotal;

						$disciplinasaprovados = 0;
						$disciplinasmatriculados = 0;
						$disciplinaspendentes = 0;


					$rsb = $conexao->prepare("select * from tb_uploads where (aluno = :aluno)");

					$rsb->bindParam('aluno', $idlocal);

					$rsb->execute();

					for ($ialunosbaixar = 0; $ialunosbaixar < $rsb->rowcount(); $ialunosbaixar++)
					{
						$rb = $rsb->fetch(PDO::FETCH_OBJ);

						$disciplinasaprovados += $rb->disciplinasaprovados;
						$disciplinasmatriculados += $rb->disciplinasmatriculados;
					}

						$disciplinaspendentes = $disciplinastotal - $disciplinasaprovados;

					if ($disciplinaspendentes == 0)
					{
						$disciplinaspendentes = "concluído";
					}


					echo ('<div class="headring espacosuperior">');

						echo ('<div class="coluna nome_arquivdados nomecolor">&nbsp;nome:&nbsp;&nbsp;'.$retorno->nome.'&nbsp;&nbsp;'.$retorno->sobrenome);

						echo ('<div class="coluna opcoes_arquivdados vizualizar" id="'.$retorno->id.'" onclick="clickvizualizar(this.id);">&nbsp;vizualizar</div>');

						echo ('</div>&nbsp;');
						

					echo ('</div>');



					echo ('<div>&nbsp;</div>');

					echo ('<span id="id'.$retorno->id.'" class="hidden">');

					if ($retorno->pin != "")
					{
						echo ('<div class="linhadescricao" id="excluir" onclick="opdesarquivar(');
						echo ("'".$retorno->id."');");
						echo ('">&nbsp;<span class="desarquivar">desarquivar</span></div>');
					}


						echo ('<div class="linhadescricao coluna">&nbsp;<span class="titulo">endereço</span>: '.$retorno->endereco.'</div>');
						echo ('<div class="linhadescricao coluna">&nbsp;<span class="titulo">cidade</span>: '.$retorno->cidade.'</div>');
						echo ('<div class="linhadescricao coluna">&nbsp;<span class="titulo">uf</span>: '.$retorno->uf.'</div>');
						echo ('<div class="linhadescricao coluna">&nbsp;<span class="titulo">país</span>: '.$retorno->pais.'</div>');
			echo ('<div class="headring espacosuperior"></div>');
						echo ('<div class="linhadescricao coluna">&nbsp;<span class="titulo">universidade</span>: '.$retorno->universidade.'</div>');
						echo ('<div class="linhadescricao coluna">&nbsp;<span class="titulo">curso</span>: '.$retorno->curso.'</div>');
						echo ('<div class="linhadescricao coluna">&nbsp;<span class="titulo">área do estudo</span>: '.$retorno->areadoestudo.'</div>');
						echo ('<div class="linhadescricao coluna">&nbsp;<span class="titulo">ano de início</span>: '.$retorno->anodeinicio.'</div>');
			echo ('<div class="headring espacosuperior"></div>');
						echo ('<div class="linhadescricao coluna">&nbsp;<span class="titulo">disciplinas total</span>: '.$disciplinastotal.'</div>');
						echo ('<div class="linhadescricao coluna">&nbsp;<span class="titulo">disciplinas aprovadas</span>: '.$disciplinasaprovados.'</div>');
						echo ('<div class="linhadescricao coluna">&nbsp;<span class="titulo">disciplinas pendentes</span>: '.$disciplinaspendentes.'</div>');
						echo ('<a href="./baixadetalhes.php?id='.$idlocal.'" target="_blank"><div class="linhadescricao coluna">&nbsp;&nbsp;<span class="titulobaixar">&nbsp;&nbsp;baixar&nbsp;&nbsp;</span></div></a>');


						echo ('<div class="espacoinferior">&nbsp;</div>');

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
					
					echo ('<div class="linhadescricao_notas">&nbsp;<span class="titulo">notas</span></div>');

					echo ("<div></div>");

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

					echo ('<div class="linhadescricao_notas">&nbsp;<span class="titulo">detealhes</span></div>');

					
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

						echo ('<div class="detalhestotais_especial coluna">matriculados: <span class="negrito">'.$disciplinasmatriculados.'</span>&nbsp;&nbsp;&nbsp;&nbsp;</div>');
						echo ('<div class="detalhestotais_especial coluna">aprovados: <span class="negrito">'.$disciplinasaprovados.'</span>&nbsp;&nbsp;&nbsp;&nbsp;</div>');
						echo ('<div class="detalhestotais_especial coluna">reprovados: <span class="negrito">'.$disciplinaspendentes.'</span></div>');


						echo ('<div class="espacoinferior">&nbsp;</div>');
					}


					echo ('<div class="espacoinferior">&nbsp;</div>');
					echo ('<div class="espacoinferior">&nbsp;</div>');

					echo ('<div class="bgprincipal">&nbsp;</div>');
					echo ('<div>&nbsp;</div>');

						echo ('<div class="bgprincipal">&nbsp;</div>');
						echo ('<div>&nbsp;</div>');


					echo ('</span>');
				}
			}
			else
			{
				echo ('<div class="nome nomecolor centralizaconteudo">&nbsp;Nenhum resultado para sua pesquisa.</div>&nbsp;');
			}
}
else
{
	include('./listadeestudante_notas.php');
}

?>