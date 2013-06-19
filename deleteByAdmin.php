<?php
session_start();
require_once("tools.php");
verifUser(); 
require_once("connect.php");
enteteHTML("Suppression membre", "admin");


?>
	
	<h2>Quel utilisateur voulez-vous supprimer de la base ?</h2>
	(pseudo ou e-mail)<br><br>
	
	
	<form method="post" action="traitementSuppr2.php" name="suppression">
		<input type="text" name="choixSuppr">
		<input type="submit" value="Supprimer définitivement" name="suppression">
	</form>
	
	
<?php
finHTML();

?>