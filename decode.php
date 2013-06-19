<?php
require_once("tools.php");
require_once("connect.php");

// verif match en base 
	if(isset($_GET['url'])){
		$courte = $_GET['url'];
		$recherche = $pdo->query("SELECT * FROM urls WHERE courte = '$courte'");
		
		$recherche->setFetchMode(PDO::FETCH_OBJ);
		if($recherche->rowCount()){
			$recherche = $recherche->fetchAll();	// transforme le résultat de PDO en un tableau 
			$url = $recherche[0]->source;
			$id = $recherche[0]->id;
			
			//insertion dans la table "utilisations" 
			$req = "INSERT INTO utilisations(url, date) VALUES($id, CURDATE());";
			$res = $pdo->exec($req);
			$_SESSION['source'] = $url;
			header('Location: ' . $url);
		}else{
			$msg = "L'url raccourcie est introuvable ";
			erreur($msg);
		}
		
		
	}else{
		header('Location: index.php');
	}
?>