<?php
session_start();
require_once("tools.php");
verifUser();
require_once("connect.php");


if(isset($_POST['suppression'])){

	//récupération des données
	$choixSuppr = trim($_POST['choixSuppr']);
	$choixSuppr = addslashes($choixSuppr);
	
	$recupID = $pdo->query("SELECT id FROM membres WHERE pseudo = '$choixSuppr' OR mail = '$choixSuppr'; ");
	$recupID->setFetchMode(PDO::FETCH_OBJ);
	
	//si on trouve l'utilisateur 
	if($recupID->rowCount()){
	$recupID = $recupID->fetchAll(); 
	$recupID = $recupID[0]->id; 
	
	$suppressionUrls = $pdo->query("DELETE FROM urls WHERE auteur = '$recupID';");
	$suppressionUser = $pdo->query("DELETE FROM membres where pseudo = '$choixSuppr' OR mail = '$choixSuppr';"); 
	$verif = $pdo->query("SELECT * FROM membres WHERE pseudo = '$choixSuppr' OR mail = '$choixSuppr';");
		if($verif->rowCount()){ 
			die("Erreur de suppression. Veuillez réessayer ultérieurement");
		}else{
		flash("L'utilisateur $choixSuppr a bien été supprimé"); 
		header("Location:espacemembre.php");
		}
	
	// si on ne trouve pas l'utilisateur	
	}else{	
		header("Location:deleteByAdmin.php");
		error("Membre introuvable");
	}


}else{
	header("Location:index.php");

}
finHTML();

?>