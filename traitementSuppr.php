<?php
session_start();
require_once("tools.php");
require_once("connect.php");


if(isset($_POST['suppression'])){
	$val1 = $_POST['val1'];
	$val2 = $_POST['val2'];
	$pseudo = $_SESSION['utilisateur'];
	
	// si le calcul est juste, on fait la suppression 
	if($val1 + $val2 == $_POST['reponse']){
	
		$recupID = $pdo->query("SELECT id FROM membres WHERE pseudo = '$pseudo' ; ");
		$recupID->setFetchMode(PDO::FETCH_OBJ);
		if($recupID->rowCount()){
			$recupID = $recupID->fetchAll(); 
			$recupID = $recupID[0]->id; 
		}
		$suppressionUrls = $pdo->query("DELETE FROM urls WHERE auteur = '$recupID';");
		$suppressionUser = $pdo->query("DELETE FROM membres where pseudo = '$pseudo';");
		unset($_SESSION['utilisateur']);
		unset($_SESSION['profil']);
		setcookie('utilisateur');
		flash("Votre compte a bien été supprimé"); 
		header("Location:index.php");
	}else{
		header("Location: deleteByMember.php");
		error("Résultat incorrect");
	}


}else{
	header("Location:index.php");

}
finHTML();

?>