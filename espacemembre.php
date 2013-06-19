<?php
session_start();
require_once("tools.php");
verifUser(); 
require_once("connect.php");
enteteHTML("Espace membre", "membre-img");
?>


	<div id="plgChoix">
	<form method="post" action="traitement.php"> 
		<br>Entrez un lien*
		<input type="url" name="longUrl" size="40"></input>
		<input type="submit" name="raccourcir" value=" Raccourcir ! ">
		<p class="infoEtoile">*Les URLs raccourcies sont publiques</p>
	</form>
	</div>
	
	<br><br><br>
	<?php

	// affichage de l'url réduite 
	if(isset($_SESSION['newUrl'])){
		$newUrl = $_SESSION['newUrl'];
		echo "Votre url réduite : ";
		echo "<a target=_blank href='decode.php?url=".$_SESSION['newUrl']."'>". $_SESSION['newUrl'] ."</a>";
		unset($_SESSION['newUrl']);
	}

	echo "<br><br><br>";
	if(isset($_SESSION['msginfo'])){
		echo $_SESSION['msginfo'];
		unset($_SESSION['msginfo']);
	}
	?>
	
	<table class="menu">
		<td><a href="espacemembre.php">Historique urls</a></td>
		<td><a href="exportPDF.php">Export PDF </a></td>
		<td><a href="statistiques.php">Statistiques</a></td>
		<td><a href="choixUser.php">Mon compte</a></td>
	</table>
	
	<?php
	/* *************************** LIENS POUR ADMIN UNIQUEMENT **********************************************
	******************************************************************************************************* */
	if(isset($_SESSION['profil']) && $_SESSION['profil'] == 'admin'){
		echo "<table class='menu'>";
		echo "<td><a href='liste_membres.php'>Liste des membres</a></td>";
		echo "<td><a href='deleteByAdmin.php'>Supprimer un membre</a></td>";
		echo "<td><a href='upgrade.php'>Gestion des droits d'utilisateur</a></td>";
		echo "</table>";
	} 
	
	/* ********************************* FIN DES LIENS D'ADMIN ******************************************** */
	
	
	
	/* récupération de chaque url pour affichage dans l'historique personnel 
	*	1. On récupère l'id selon le pseudo
	*	2. On affiche les urls crées correspondant à cet id 
	*/
	$pseudo = $_SESSION['utilisateur'];
	$recupID = $pdo->query("SELECT id FROM membres WHERE pseudo = '$pseudo' ; ");
	$recupID->setFetchMode(PDO::FETCH_OBJ);
	if($recupID->rowCount()){
	$recupID = $recupID->fetchAll();
	$recupID = $recupID[0]->id; 
	}
	/*
	$res = $recupID->fetchAll();
	$id = $res[0]['id']
	*/ 
	
	$recupAll = $pdo->query("SELECT * FROM urls WHERE auteur = $recupID ;");
	$recupAll->setFetchmode(PDO::FETCH_OBJ);
	?>
	
	
	<form method="post" action="deleteUrls.php" name="leformulaire" id="leformulaire">
	<!--- début du tableau d'historique  ---->
	<table class="historique">
		<th class="cases"><input type="checkbox" id="checkAll" name="choix" title="Tout cocher"/></th>
		<th class="sources">Url source</th>
		<th class="historique">Url réduite</th>
		<th class="dates">Date de création</th>
		<th class="vues">Vues<th>
	

		
		
		<?php
		foreach ($recupAll as $f){
		
			$idURL = $f->id;
			$req = $pdo->query("SELECT count(*) AS nb FROM utilisations WHERE url = '$idURL' ;");
			$req->setFetchMode(PDO::FETCH_OBJ);
			$result=$req->fetch();
			
			$tr = sprintf('<tr style="background-color:#%s">
								<td> <input type="checkbox" class="toCheck" name="choix[]" value=%s/> </td>
								<td class="historique"><a target=_blank  href=%s>%s</a></td>
								<td class="historique"><a target=_blank  href=decode.php?url=%s>%s</a></td>
								<td class="dates">%s</td>
								<td class="vues">%d</td>
							</tr>', 
							(($i++ % 2) ? "FFFFFF" : "F5F5DC") ,
							$idURL,
							$f->source, $f->source, 
							$f->courte, $f->courte, 
							date('d/m/Y', strtotime($f->creation)), 
							$result->nb
							); 
						echo $tr;
		}
		echo"</table>";
		
	
	// calcul du total 
	$calcul = $pdo->query("SELECT count(*) as count FROM urls WHERE auteur = '$recupID' ;");
	$calcul->setFetchMode(PDO::FETCH_OBJ);
	$result=$calcul->fetch();
	echo "<p><img src='style/fleche.jpg' title='fleche'><input type='submit' name ='leformulaire' id ='leformulaire' value ='Supprimer'></p>";
	echo "<p class='infoEtoile'>" . $result->count . " urls au total </p>";
	echo "</form>";
?>

<script src="js/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#checkAll').click(function() {
			if($('#checkAll').is(':checked')){
				$('.toCheck').prop('checked', 'checked'); // attr : 1param = valeur ; 2 param = valeur + affectation 
			}else{
				$('.toCheck').removeAttr('checked');
			}
		});
	});

	function deleteAll(){
		if(confirm("Etes-vous sûr de vouloir supprimer ces urls ?"))
			document.getElementById("leformulaire").submit();
			document.location.href='deleteUrls.php';	
	}
	
</script>


<?php	
finHTML();
?>