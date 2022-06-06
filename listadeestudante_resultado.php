<?php

include('./conexao.php');

$conexao = conexao();

if ($_POST && chop($_REQUEST['busca']) != '' && strlen($_REQUEST['busca']) > 0)
{

	$nome = '%'.$_REQUEST['busca'].'%';


		$busca = $conexao->prepare('select * from tb_alunos where ((nome like :nome || sobrenome like :nome || email like :nome || fone like :nome) && pin = "") order by id desc');

		$busca->bindParam('nome', $nome, PDO::PARAM_STR);
}
else
{
		$busca = $conexao->prepare('select * from tb_alunos where (pin = "") order by id desc');
}
		$busca->execute();

		if ($busca->rowcount() > 0)
		{
			/*echo ('<div class="headring espacosuperior">');
				echo ('<div class="coluna nome pretocolor">&nbsp;nome</div>&nbsp;');
				echo ('<div class="coluna sobrenome pretocolor">&nbsp;sobrenome</div>&nbsp;');
				echo ('<div class="coluna email pretocolor">&nbsp;email</div>&nbsp;');
			echo ('</div>');*/
			

			for ($i = 0; $i < $busca->rowcount(); $i++)
			{
				$retorno = $busca->fetch(PDO::FETCH_OBJ);

				

				echo ('<div class="headring espacosuperior">');

				echo ('<div class="coluna nome_arquivdados nomecolor">&nbsp;nome:&nbsp;&nbsp;'.$retorno->nome.'&nbsp;&nbsp;'.$retorno->sobrenome);
				echo ('</div>&nbsp;');

					//echo ('<div class="coluna nome nomecolor">&nbsp;'.$retorno->nome.'</div>&nbsp;');
					//echo ('<div class="coluna sobrenome nomecolor">&nbsp;'.$retorno->sobrenome.'</div>&nbsp;');
					//echo ('<div class="coluna email nomecolor">&nbsp;'.$retorno->email.'</div>&nbsp;');

				echo ('</div>');


				echo ('<div class="headring espacosuperior">');

					echo ('<div class="coluna opcoes vizualizar" id="'.$retorno->id.'" onclick="clickvizualizar(this.id);">&nbsp;detalhes</div>');

					echo ('<a href="?page=detalhes&id='.$retorno->id.'">&nbsp;<div class="coluna opcoes titulonotas">notas</div></a>');

					echo ('<a href="?page=altera_aluno_form_funcionario&id='.$retorno->id.'">&nbsp;<div class="coluna opcoes tituloeditar">editar</div></a>&nbsp;');
					//echo ('<div class="" id="'.$retorno->id.'" onclick="clickvizualizar(this.id);"></div>');

					echo ('<div class="coluna opcoes acoesdeleteop" id="excluir" onclick="opdeletealuno(');
					echo ("'".$retorno->id."');");
					echo ('">arquivar</div>');


				echo ('</div>');

				echo ('<div>&nbsp;</div>');

				echo ('<span id="id'.$retorno->id.'" class="hidden">');

					echo ('<div class="linhadescricao">&nbsp;<span class="titulo">e-mail</span>: '.$retorno->email.'</div>');

					echo ('<div class="linhadescricao">&nbsp;<span class="titulo">endereço</span>: '.$retorno->endereco.'</div>');
					echo ('<div class="linhadescricao"><span class="titulo">cidade</span>: '.$retorno->cidade.'</div>');
					echo ('<div class="linhadescricao"><span class="titulo">uf</span>: '.$retorno->uf.'</div>');
					echo ('<div class="linhadescricao"><span class="titulo">país</span>: '.$retorno->pais.'</div>');
					echo ('<div class="espacoinferior">&nbsp;</div>');
					echo ('<div class="linhadescricao"><span class="titulo">universidade</span>: '.$retorno->universidade.'</div>');
					echo ('<div class="linhadescricao"><span class="titulo">curso</span>: '.$retorno->curso.'</div>');
					echo ('<div class="linhadescricao"><span class="titulo">área do estudo</span>: '.$retorno->areadoestudo.'</div>');
					echo ('<div class="linhadescricao"><span class="titulo">ano de início</span>: '.$retorno->anodeinicio.'</div>');
					echo ('&nbsp;<div class="linhadescricao"><span class="titulo">disciplinas total</span>: '.$retorno->disciplinastotal.'</div>');

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

						echo ('<div class="linhadescricao"><span class="titulo">aprovadas</span>: '.$disciplinasaprovados_calculo.'</div>');

						echo ('<div class="linhadescricao"><span class="titulo">pendentes</span>: '.$disciplinaspendentes.'</div>');
/*
					echo ('<div class="espacoinferior">&nbsp;</div>');
					
					//a partir daqui....
					echo ('<div class="linhadescricao">&nbsp;<span class="titulo">notas</span></div>');
					echo ('<div class="notasdesc largura1">nome do arquivo</div><div class="notasdesc largura2">arquivo</div>');

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

						echo ('<div class="notasdesc largura1">'.$periodo.' - '.$anoletivo.'</div>');
						echo ('<div class="notasdesc largura2"><a href="./pdf/'.$fileupload.'" target="_blank"><div class="acoesdownload coluna">download</div></a><div class="acoesdelete coluna" id="delete" onclick="opdelete(');
						echo ("'".$retornoalunos->id."',");
						echo ("'".$fileupload."');");
						echo ('")>delete</div></div>');
					}

					echo ('<div class="espacoinferior">&nbsp;</div>');

					echo ('<div class="linhadescricao">&nbsp;<span class="titulo">detealhes</span></div>');

					echo ('<div class="notasdesc largura3 transparente"></div><div class="notasdesc largura4 transparente">disciplinas</div>');

					echo ('<div class="notasdesc largura3">período</div>');
					echo ('<div class="notasdesc largura4 transparente">');
					//echo ('<div class="coluna detalhestotais">total</div>');
					echo ('<div class="coluna detalhestotais">matriculados</div>');
					echo ('<div class="coluna detalhestotais">aprovados</div>');
					echo ('<div class="coluna detalhestotais">reprovados</div>');
					echo ('<div class="coluna detalhestotais">ação</div></div>');

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
						//$disciplinaspendentes = $rb->disciplinaspendentes;

						$disciplinaspendentes = $disciplinasmatriculados - $disciplinasaprovados;

						echo ('<div class="notasdesc largura3">'.$periodo2.'</div>');
						echo ('<div class="notasdesc largura4 transparente">');
						//echo ('<div class="coluna detalhestotais">'.$disciplinastotal.'</div>');
						echo ('<div class="coluna detalhestotais">'.$disciplinasmatriculados.'</div>');
						echo ('<div class="coluna detalhestotais">'.$disciplinasaprovados.'</div>');
						echo ('<div class="coluna detalhestotais">'.$disciplinaspendentes.'</div>');
						echo ('<a href="./baixa.php?id='.$idbaixarfile.'" target="_blank"><div class="coluna titulobaixar">baixar</div></a></div>');
					}*/


					echo ('<div class="espacoinferior">&nbsp;</div>');
					echo ('<div class="espacoinferior">&nbsp;</div>');

					echo ('<div class="bgprincipal">&nbsp;</div>');
					echo ('<div>&nbsp;</div>');

				echo ('</span>');

			}
?>


			    <div id="rs_login" class="hidden">

					<div class="loader">loading</div>

					<div class="centralizaconteudo">
						<div id="rss_log" class="rss_log"></div>
					</div>

			    </div>


<?php
		}
		else
		{
			echo ('<div class="nome nomecolor centralizaconteudo">&nbsp;Nenhum resultado para sua pesquisa.</div>&nbsp;');
		}
?>

