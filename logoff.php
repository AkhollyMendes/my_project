<?php
session_start();

	if((isset ($_SESSION['nome']) == true))
	{
		  unset($_SESSION['nome']);

		  unset($_SESSION['id']);

		  unset($_SESSION['nivel']);

		  header('location: ./');
	 }
	 else
	 {
	 	header('location: ./');
	 }
?>