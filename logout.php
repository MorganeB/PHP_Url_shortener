<?php session_start(); 

	if(isset($_SESSION['utilisateur'])){
		unset($_SESSION['utilisateur']);
		unset($_SESSION['profil']);
		setcookie('utilisateur');
		header('Location:index.php');
	}
?>