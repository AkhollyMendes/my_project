<?php

	function conexao()
	{
		try
		{
			$conexao_data = new PDO("mysql:host=localhost;dbname=database",  "root", "");
		}
		catch  (PDOException $e)
		{
			echo ($e->getMessage());
		}

		return($conexao_data);
	}
?>