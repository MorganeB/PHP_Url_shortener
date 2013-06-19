<?php
session_start();
require_once("tools.php");
require_once("connect.php");
enteteHTML("Connexion", "connexion");
?>


<form method="post" action="connexion.php">
	<label for="pseudo">Pseudo :</label>
	<?php
	if(isset($_COOKIE['utilisateur'])){
		echo '<input type="text" name="pseudo" value=" ' . $_COOKIE['utilisateur'] . '"/>';
	}else{
		echo '<input type="text" name="pseudo">';
	}
	?>
	<label for="password">Mot de passe :</label>
	<input type="password" name="password">
	
	<input type="submit" value="Connexion" name="login">
 </form>
			 

<?php

	if(isset($_POST['login'])){	// attention 

		unset($_SESSION['utilisateur']);
		unset($_SESSION['profil']);
		$pseudo = trim($_POST['pseudo']);
		$password = trim($_POST['password']);
		$pass_hache = sha1($password); 
		$compare = $pdo->query("SELECT * FROM membres WHERE pseudo = '" . $pseudo . "' AND mdp = '" .$pass_hache . "';");
		if($compare->rowCount()){
			// récupération du profil
			$user = $compare->fetchAll();
			$_SESSION['utilisateur'] = $pseudo;
			$_SESSION['profil'] = $user[0]["profil"];
			setcookie('utilisateur', $_SESSION['utilisateur'], time() + 3600 * 24 * 365 * 10);
			header('Location: espacemembre.php');exit();
		}else{
			error("Mauvais pseudo ou mauvais mot de passe");
			header('Location: connexion.php');
		}
	}

finHTML();
?>

