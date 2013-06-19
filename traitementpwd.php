<?php
session_start();
require_once("tools.php");
require_once("connect.php");


	//verification du mot de passe d'origine 
	if(isset($_POST['changepwd'])){
		$pseudo = $_SESSION['utilisateur']; 
		$password = trim($_POST['password']);
		$pass_hache = sha1($password); 
		$compare = $pdo->query("SELECT * FROM membres WHERE pseudo = '" . $pseudo . "' AND mdp = '" .$pass_hache . "';");
		
		// si le mot de passe d'origine est correct : 
		if($compare->rowCount()){
				$newPassword = trim($_POST['newPassword']);
				$newPassword2 = trim($_POST['newPassword2']);

				//verification de la concordance du nouveau mot de passe saisi + modification en base
				if(strcmp($newPassword, $newPassword2) == 0){
					$newPassword_hache = sha1($newPassword);
					$remplace = $pdo->query("UPDATE membres SET mdp = '$newPassword_hache' WHERE pseudo = '$pseudo' ;");
					flash("Modification du mot de passe effectuée avec succès ");
					header("Location: espacemembre.php");
					
				// fin verif concordance nouveau mdp
				}else{
					error("Erreur de saisie dans le nouveau mot de passe");
				}
		
		// fin verif mdp original
		}else{
			error("Mauvais mot de passe d'origine");
		}
	}else{
		header("Location:index.php");
	}
	
	
	?>