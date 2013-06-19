<?php
session_start();
require_once("tools.php");
require_once("connect.php");
enteteHTML("Espace membre", "membre-img");
?>
	
	<h2>Changement du mot de passe</h2><br>
	<form method="post" action="traitementpwd.php" name="changepwd">
		Mot de passe actuel  <input type="password" name="password"><br>
		Nouveau mot de passe <input type="password" name="newPassword"><br>
		Nouveau mot de passe (confirmation) <input type="password" name="newPassword2"><br><br>
		<input type="submit" value="Changer mon mot de passe" name="changepwd">
	</form>
	
	
<?php
finHTML();
?>