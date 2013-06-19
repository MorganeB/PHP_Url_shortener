<?php
session_start();
require_once("tools.php");
require_once("connect.php");
enteteHTML("Espace membre", "membre-img");
?>
	
	<h2>Suppression de compte</h2><br>
	Etes-vous sûr(e) de vouloir supprimer définitivement votre compte ? <br>
	Cela entraînera la perte de votre historique d'urls et de vos statistiques. <br><br><br>
	
	
	<form method="post" action="traitementSuppr.php" name="suppression">
		<input type="radio" name="choix"checked="checked"/>
			<label>Oui</label><br>
		
			<div id="captcha">
				
				<?php
				$val1 = rand(1, 10);
				$val2 = rand(50, 880);
				echo "Calculez : $val1 + $val2 = ";
				?>
				
				<input type="hidden" value="<?php echo $val1; ?>" name="val1">
				<input type="hidden" value="<?php echo $val2; ?>" name="val2">
				<input type="text" size="3" name="reponse"><br><br>

			<input type="submit" value="Supprimer mon compte" name="suppression"><br><br>
	
			</div>	
		
			<input type="radio" name="choix" onclick="location.href='espacemembre.php'"/>
				<label>Non, je veux retourner sur la page d'accueil</label><br>
		
		</form>
<?php
finHTML();
?>