<?php
require_once("tools.php");
verifUser("admin");
require_once("connect.php");


if(isset($_POST)){
	$i = 0;
	foreach($_POST['choix'] as $check){
		$i++;
        $del = $pdo->query("DELETE FROM membres WHERE id = '$check';");
	}
	if($i == 1)
		$msg = "L'utilisateur a bien été supprimé";
	else
		$msg = "Les ". $i . " utilisateurs ont bien été supprimés";
		
	flash($msg);
	header('Location: liste_membres.php');
}else{
	header('Location: index.php');
}


finHTML();

?>



?>