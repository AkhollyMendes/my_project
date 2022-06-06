<?php include('./seg.php'); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="./css/style.css?version=<?php echo rand(324,65454); ?>">
	
	<title>:: Sistemas de Notas ::</title>
</head>
<body>

	<?php include('./header.php'); ?>



<div class="menufuncionariobox">
	<?php include('./menu.php'); ?>
</div>

<div class="container">

	<div class="conteudobox">

		<div class="centralizaconteudo">

		<?php
			if (isset($_REQUEST['page']))
			{
				include('./'.$_REQUEST['page'].'.php');
			}
			else
			{
				include('./bemvindo2.php');
			}
		?>
	</div>
</div>

</div>

</body>
</html>