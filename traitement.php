<?php
require_once("tools.php");
require_once("connect.php");

//traitement des urls 

/* v�rif � faire : 
addslashes() 
*/
function getShortLink($string){
	//on genere une chaine de 10 caracteres al�atoires 
	$string = "";
	$caracteres = array_merge(range('A','Z'), range('a','z'), range('0','9'));	//fusionne plusieurs tableaux en 1 seul 
	$max = count($caracteres);
	for ($i = 0; $i < 10; $i++) {
		$rand = rand(0, $max);	
		$string .= $caracteres[$rand];
	}
	return $string;
}

if(isset($_POST['raccourcir'])){
	// recuperation + insertion en base
	$source = trim($_POST['longUrl']);
	$courte = getShortLink($source);
	
	// on v�rifie que l'url r�duite n'existe pas d�j� en base 
	$verif = $pdo->prepare("SELECT courte FROM urls;");
	while($verif->rowCount()){
		$verif->execute();
	}
	
	//utilisateur membre
	if(isset($_SESSION['utilisateur'])){
		$auteur = $_SESSION['utilisateur'];
		
		// Attention auteur est une cl� �trang�re qui r�f�rence l'id du membre
		$verif = $pdo->query("SELECT * FROM membres WHERE pseudo = '$auteur'");
		$verif->setFetchMode(PDO::FETCH_OBJ);
		if($verif->rowCount()){
			$verif = $verif->fetchAll();	// transforme le r�sultat de PDO en un tableau 
			$id_auteur = $verif[0]->id;		// on r�cup�re l'id
			$req = $pdo->prepare("INSERT INTO urls (source, courte, creation, auteur) 
				VALUES ('$source', '$courte', CURDATE() , $id_auteur);");
			$redirect = "espacemembre.php";
			
		}else{
			echo "utilisateur introuvable";
		}
		
	
	}else{	//utilisateur non membre 
		$req = $pdo->prepare("INSERT INTO urls (source, courte, creation) VALUES ('$source', '$courte', CURDATE());");
		$redirect = "index.php";
	}
	
	// redirection et affichage du resultat sur index.php ou espacemembre.php 
	$req->execute();
	$_SESSION['source'] = $source;
	$_SESSION['newUrl'] = $courte;
	header('Location:' . $redirect);
}else{
	header("Location: index.php");
}
?>

