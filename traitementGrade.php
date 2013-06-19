<?php
session_start();
require_once("tools.php");
verifUser();
require_once("connect.php");


// upgrade
if(isset($_POST['upgrade'])){
	$nom = trim($_POST['choixGrade']);
	$nom = addslashes($nom);
	$rech = $pdo->query("SELECT * FROM membres WHERE pseudo = '$nom' OR mail = '$nom' ;");

	if($rech->rowCount()){
	$rech = $rech->fetchAll();
	$req = $pdo->query("UPDATE membres SET profil = 'admin' WHERE pseudo = '$nom' OR mail = '$nom' ;");
	flash("L'utilisateur '$nom' est maintenant administrateur");
	header("Location:espacemembre.php");
	
	}else if($rech->count == 0){	// si l'utilisateur n'existe pas 
		error("Utilisateur '$nom' introuvable");
		header("Location:upgrade.php");
	}


//downgrade
}else if (isset($_POST['downgrade'])){  
	$nom = trim($_POST['choixGrade']);
	$rech = $pdo->query("SELECT * FROM membres WHERE pseudo = '$nom' OR mail = '$nom' ;");
	
	if($rech->rowCount()){
	$rech = $rech->fetchAll();
	$req = $pdo->query("UPDATE membres SET profil = null WHERE pseudo = '$nom' OR mail = '$nom' ;");
	flash("L'utilisateur '$nom' n'est plus administrateur");
	header("Location:espacemembre.php");
	
	}else if($rech->count == 0){	// si l'utilisateur n'existe pas 
		error("Utilisateur '$nom' introuvable");
		header("Location:upgrade.php");
	}
}

finHTML();
?>