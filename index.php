<?php
require_once("tools.php");
require_once("connect.php");
enteteHTML("Accueil", "index"); 
?>

<div id="plgChoix">
	<form method="post" action="traitement.php"> 
		<br>Entrez un lien*
		<input type="url" name="longUrl" size="40"></input>
		<input type="submit" name="raccourcir" value=" Raccourcir ! ">
		<p class="infoEtoile">*Les URLs raccourcies sont publiques</p>
	</form>
</div>
	
<br><br>

<?php
if(isset($_SESSION['newUrl'])){
	$url = $_SESSION['source'];
	echo "<a target=_blank href='" . $url . "'>" . $url . "</a><br><br>";
	echo "Votre url réduite : <a target=_blank href='decode.php?url=".$_SESSION['newUrl']."'>". $_SESSION['newUrl'] ."</a>";
	unset($_SESSION['newUrl']);
}
?>


<?php
finHTML();
?>
