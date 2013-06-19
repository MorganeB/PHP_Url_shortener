<?php
session_start();

function enteteHTML($titre, $nomimg)
{
	//Test si utilisateur connecté
	if(!empty($_SESSION['utilisateur'])){
		$headerRight = sprintf('
			<p>Connecté(e) en tant que %s<br/></p>
			<a href="logout.php">Deconnexion</a><br/>
		', $_SESSION['utilisateur']);
		$lienAccueil = 'espacemembre.php';
	}else{
		$headerRight = '
			<a href="connexion.php">Se connecter | </a>
			<a href="inscription.php">S\'inscrire</a>
		';
		$lienAccueil = 'index.php';
	}
	$headerRight .= sprintf('<br><br><a href="%s">Accueil</a>', $lienAccueil);
	
  echo <<< YOP
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
    <link href="style/style.css" media="screen" rel="stylesheet" type="text/css">
    <title>
      $titre
    </title>
  </head>
  <body>
	<div class="headerRight">
		$headerRight
	</div>
	<div id="global">
		<div id="header">
			<img src='style/$nomimg.jpg'>
		</div>
YOP;

	if (isset($_SESSION['info'])) {
		$info = $_SESSION['info'];
		echo <<< MSG
		<div class="msginfo">$info</div>
MSG;
		unset($_SESSION['info']);
	}

	if (isset($_SESSION['error'])) {
		$error = $_SESSION['error'];
		echo <<< MSG
			<div class="msgerreur">$error</div>
MSG;
		unset($_SESSION['error']);
	}
}


function enteteTitreHTML($titre)
{
  enteteHTML($titre);
  echo <<< YOP

    <h1>
      $titre
    </h1></div>
	
YOP;
}

function finHTML()
{
  echo <<< YOP
		
	</div>
  </body>
</html>
YOP;
}

function flash($texte){
  $_SESSION['info'] .= $texte;
}

function error($texte){
  $_SESSION['error'] .= $texte;
}

function verifUser($profil=""){
	// si on l'appelle sans paramètre, la valeur par défaut = le paramètre défini dans la fonction
	if(isset($_SESSION['utilisateur'])){
		$profilUser = $_SESSION['profil'];
		// si on est loggué mais qu'on n'est pas Admin : 
		if($profil != $profilUser && $profilUser != "admin"){
			error("Vous n'avez pas les droits d'accès à cette page. Veuillez vous connecter.");
			header("Location: connexion.php");exit;
		}
	// si on n'est pas loggué du tout 
	}else{
		header("Location: connexion.php");
	}
}
?>