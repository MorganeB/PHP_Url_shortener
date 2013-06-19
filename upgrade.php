<?php
session_start();
require_once("tools.php");
verifUser();
require_once("connect.php");
enteteHTML("Grade", "admin");

?>

<h2>De quel utilisateur voulez-vous modifier les droits ?</h2>
	(pseudo ou e-mail)<br><br>
	
	
	<form method="post" action="traitementGrade.php" name="grade">
		<input type="text" name="choixGrade">
		<input type="submit" value="Grader" name="upgrade"><input type="submit" value="Rétrograder" name="downgrade">
	</form>

	
<?php
finHTML();

?>