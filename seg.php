<?PHP
	if (!isset($_SESSION))
	{
		session_start();
	}

		if (!isset($_SESSION['id']) || chop($_SESSION['id']) == "" || !isset($_SESSION['nome']) || chop($_SESSION['nome']) == "" || !isset($_SESSION['nivel']) || chop($_SESSION['nivel']) == "")
		{
			session_destroy();

			echo ('<script language="JavaScript">');
				
				echo ('setTimeout("window.location=');
				echo ("'logoff.php'");
				echo ('",0);');
      			  //return false;
	  		echo ('</script>');
		}

?>