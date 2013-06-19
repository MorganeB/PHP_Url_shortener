<?php
session_start();
require_once("tools.php");
verifUser(); 
require_once("connect.php");



if(isset($_POST)){
	$i = 0;
	foreach($_POST['choix'] as $check){
		$i++;
        $del = $pdo->query("DELETE FROM urls WHERE id = '$check';");
	}
	if($i == 1)
		$msg = "L'url a bien été supprimée";
	else
		$msg = "Les ". $i . " urls ont bien été supprimées";
		
	flash($msg);
	header('Location: espacemembre.php');
}else{
	header('Location: index.php');
}


finHTML();

?>


