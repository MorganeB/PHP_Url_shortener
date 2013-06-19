<?php

require_once("tools.php");
require_once("connect.php");
enteteHTML("Inscription", "inscription");

function genereFormulaireInscriptionMembre($message_erreur = "", $nom = "", $prenom = "",
					   $pseudo = "", $mail = ""){
?>
	 <script src="scripts/verifMDP.js" type="text/javascript"></script>
<?php
  if ($message_erreur != "") {
    echo <<< MSG

      <div class="msgerreur">
        $message_erreur
      </div>
MSG;
  }

  echo "<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\">";

  echo <<< YOP

    <table>
      <tr>
        <td>Nom :</td>
        <td><input type="text" name="nom" value="$nom"></td>
      </tr>
      <tr>
        <td>Prénom :</td>
        <td><input type="text" name="prenom" value="$prenom"></td>
      </tr>
      <tr>
        <td>Pseudo :</td>
        <td><input type="text" name="pseudo" value="$pseudo"></td>
      </tr>
      <tr>
        <td>Adresse mail :</td>
        <td><input type="mail" name="mail" value="$mail"></td>
      </tr>
      <tr>
        <td>Mot de passe :</td>
        <td><input type="password" id="password" name="password1" onkeyup="javascript:NiveauSecurite();"></td>
		<td><img src="scripts/images/NiveauZero.jpg" alt="niveau du mot de passe" id="imgNiveauSecurite"/><br /></td>
      </tr>
      <tr>
        <td>Mot de passe (confirmation) :</td>
        <td><input type="password" name="password2"></td>
      </tr>
    </table>
    <input class="medskip" type="submit" value="Je crée mon compte !">
    <input type="hidden" name="fromform" value="true">
  </form>
YOP;
}

function traiteFormulaire(){
  global $pdo;
  $nom = trim($_POST["nom"]);
  $nom = addslashes($nom);
  $prenom = trim($_POST["prenom"]);
  $prenom = addslashes($prenom);
  $pseudo = trim($_POST["pseudo"]);
  $mail = trim($_POST["mail"]);;
  $password1 = trim($_POST["password1"]);
  $password2 = trim($_POST["password2"]);
  
  /////////////////
  // Vérifications
  ////////////////
  
  $message_erreur = "";
  $erreur = false;
  
  // Champs vides ?
	if ($nom == "") {
		$message_erreur .= "Le nom ne peut être vide.<br>";
		$erreur = true;
	}
  
	if ($prenom == "") {
		$message_erreur .= "Le prénom ne peut être vide.<br>";
		$erreur = true;
	}
  
	
	if ($pseudo == "") {
		$message_erreur .= "Le pseudo ne peut être vide.<br>";
		$erreur = true;
	}
	
	$apostrophe = "'";
	$guillemet = '"';
	$virgule = ',';
	if(substr_count($pseudo, $apostrophe) > 0 || substr_count($pseudo, $guillemet) > 0 || substr_count($pseudo, $virgule) > 0){
		$message_erreur .= "Le pseudo ne peut pas contenir de caractères spéciaux<br>";
		$erreur = true;
	}
	

	$regex = "/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/";
	if ($mail == "") {
		$message_erreur .= "L'adresse mail ne peut être vide.<br>";
		$erreur = true;
	}
  
	if ($password1 == "") {
		$message_erreur .= "Le mot de passe ne peut être vide.<br>";
		$erreur = true;
	}
  
	if ($password2 == "") {
		$message_erreur .= "La vérification du mot de passe ne peut être vide.<br>";
		$erreur = true;
	}
  
  // Pseudo incorrect ? (avec des guillemets) 
  $faux = "#[\'\"]#";
  if(preg_match("#'#", $pseudo, $res)){
	$message_erreur .= "Votre mot de passe ne peut pas contenir de guillemets. <br>";
	$erreur = true;
  }
  
  // Pseudo existant ?	
	if ($pseudo != "") {
		$res = $pdo->query("SELECT pseudo FROM membres WHERE pseudo='$pseudo';");
		if ($res->rowCount()) {
		$message_erreur .= "Ce pseudo est déjà pris<br>";
		$erreur = true;
		}
	}
  

  // mail existant ? 
  $resMail = $pdo->query("SELECT mail FROM membres WHERE mail = '$mail';");
	if($resMail->rowCount()){
		$message_erreur .= "Un compte rattaché à cette adresse mail existe déjà";
		$erreur = true; 
	}
  
  // Mots de passe identiques ?
  
	if ($password1 != $password2) {
		$message_erreur .= "Les mots de passe ne correspondent pas<br>";
		$erreur = true;
	}
  
	// Traitement
	if ($erreur) {
		genereFormulaireInscriptionMembre($message_erreur, $nom, $prenom, $pseudo, $mail);
		finHTML();
	}else{
		// Pour que le 1er membre crée soit un admin 
		$existUsers = $pdo->query("SELECT count(*) as nombre FROM membres");
		$nb = $existUsers->fetchAll(); 
		if($nb[0]["nombre"] == 0){
			$profil = "admin";
		}else{
			$profil = null;
		}
		$pass_hache = sha1($password2);
		$req = "INSERT INTO membres (nom, prenom, pseudo, mail, mdp, profil) " .
           "VALUES ('$nom', '$prenom', '$pseudo', '$mail', '$pass_hache', '$profil');";
		$res = $pdo->exec($req);
		if ($res) {
		  flash("Utilisateur $pseudo ajouté !");
		  header("Location: connexion.php");
		}else {
			error("Un problème est survenu. Merci de réessayer dans quelques minutes.");
			header("Location: inscription.php");
		}
	}
}

// Programme principal

if (isset($_POST['fromform'])) {
  traiteFormulaire();
}
else {
  genereFormulaireInscriptionMembre();
}
finHTML();




?>
