<?php
require_once("tools.php");
verifUser("admin");
require_once("connect.php");
enteteHTML("Listes des membres", "admin");
?>
<form method="post" action="deleteByAdmin2.php" name="leformulaire">
	<table class="liste" >
		<th>Supprimer</th>   
		<th>Pseudo</th> 
		<th>Mail</th> 
		<th>Profil</th> 
	<?php    

	$i = 0;

	$res = $pdo->query("SELECT * FROM membres;");
	$res->setFetchMode(PDO::FETCH_OBJ);

	foreach ($res as $m) {		
		$tr = sprintf('<tr style="background-color:#%s">
							<td class="checkbox"><input type="checkbox" class="toCheck" name="choix[]" value=%s/></td>
							<td class="liste">%s</td>
							<td class="liste">%s</td>
							<td class="liste">%s</td>
						</tr>', 
						(($i++ % 2) ? "FFFFFF" : "F5F5DC") ,$m->id,
						$m->pseudo, $m->mail, $m->profil
						); 
					echo $tr;
	}      
	echo "</table>";
	echo "<img src='style/fleche.jpg' title='fleche'><input type='submit' name ='leformulaire' id ='leformulaire' value ='Supprimer'>";
echo "</form>";
finHTML();
?>
