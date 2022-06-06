<?php
	include('./seg.php');

if (isset($_SESSION['nome']))
{
	echo ('<div class="menu_mobile" id="menumobile" onclick="init2();">menu</div>');
	echo ('<div class="menumobile" id="menumobile" onclick="init();">menu</div>');

		echo ('<ul class="menufuncionarioboxlist hidering" id="menufuncionarioboxlist">');


			if ($_SESSION['nivel'] == 1)//menu funcionarios
			{

				echo ('<li class="menufuncionariolist"><img class="icones" src="./layout/cadastra.png">&nbsp;<a href="?page=cadastra_aluno_form">Novo aluno</a></li>');
				
				echo ('<li class="menufuncionariolist"><img class="icones" src="./layout/accounts.png">&nbsp;<a href="?page=listadeestudante">Lista estudante</a></li>');
				
				echo ('<li class="menufuncionariolist"><img class="icones" src="./layout/laptop.png">&nbsp;<a href="?page=altera_funcionario_form">Meus dados</a></li>');
				
				echo ('<li class="menufuncionariolist"><img class="icones" src="./layout/grafico.png">&nbsp;<a href="?page=totaldosalunos">Total dos alunos</a></li>');
				
				echo ('<li class="menufuncionariolist"><a href="?page=detalhes"><img class="icones" src="./layout/archive.png">&nbsp;Arquivados</a></li>');
				
				echo ('<li class="menufuncionariolist"><a href="?page=sobrefuncionarios"><img class="icones" src="./layout/about.png">&nbsp;Sobre o sistema</a></li>');

					if ($_SESSION['id'] == 1)
					{
						echo ('<li class="menufuncionariolist"><img class="icones" src="./layout/chave.png">&nbsp;<a href="?page=chave">Gerar ID</a></li>');
					}
				
				echo ('<li class="menufuncionariolist"><img class="icones" src="./layout/sair.png">&nbsp;<a href="./logoff.php">Sair</a></li>');

			}
			
			if ($_SESSION['nivel'] == 5)//menu alunos
			{

				echo ('<li class="menufuncionariolist"><img class="icones" src="./layout/submit.png">&nbsp;<a href="?page=carrega_historico_form">Carregar histórico</a></li>');
				echo ('<li class="menufuncionariolist"><img class="icones" src="./layout/cadastranotas.png">&nbsp;<a href="?page=lanca_notas">Lançar notas</a></li>');
				echo ('<li class="menufuncionariolist"><a href="?page=altera_aluno_form"><img class="icones" src="./layout/laptop.png">&nbsp;Meus dados</a></li>');
				echo ('<li class="menufuncionariolist"><a href="?page=historico"><img class="icones" src="./layout/meuhistorico.png">&nbsp; Meu Histórico</a></li>');

				
				echo ('<li class="menufuncionariolist"><a href="?page=sobrealunos"><img class="icones" src="./layout/about.png">&nbsp;Sobre o sistema</a></li>');

				echo ('<li class="menufuncionariolist"><img class="icones" src="./layout/sair.png">&nbsp;<a href="./logoff.php">Sair</a></li>');
			}

		echo ('</ul>');

}
?>

<script type="text/javascript">

	
function init()
{
	document.getElementById('menufuncionarioboxlist').classList.remove('hidden');
	document.getElementById('menufuncionarioboxlist').classList.toggle('hidering');
}

	
function init2()
{
	document.getElementById('menufuncionarioboxlist').classList.remove('hidering');
	document.getElementById('menufuncionarioboxlist').classList.toggle('hidden');
}

function touchHandler()
{
  document.getElementById('menufuncionarioboxlist').classList.toggle('hidden');
}

</script>