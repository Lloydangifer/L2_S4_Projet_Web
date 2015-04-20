<?php include('bibli_24sur7.php');
	session_start();
	if(empty($_SESSION['id'])){
		header('location:./php/identification.php');
		exit();
	}else{
		header('location:./php/agenda.php');
		exit();
	}
?>