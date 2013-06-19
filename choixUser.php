<?php
session_start();
require_once("tools.php");
require_once("connect.php");
enteteHTML("Gestion compte", "membre-img");

if(isset($_SESSION['utilisateur'])){
?>


	<h2>Que voulez-vous faire ? </h2>
	<div class="choixAction">
		<ul>
			<li><a href="changepwd.php">Modifier mon mot de passe</a></li>
			<li><a href="deleteByMember.php">Supprimer mon compte</a></li>
		</ul>

	</div>
<?php

}else{
	header("Location: index.php");
}
finHTML();

?>