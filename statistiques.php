<?php
session_start();
require_once("tools.php");
verifUser(); 
require_once("connect.php");
enteteHTML("Statistiques", "statistiques");
?>

<h2>Vos statistiques d'utilisation</h2>

<?php
	// 1. On récupère l'id 
	$pseudo = $_SESSION['utilisateur'];
	$recupID = $pdo->query("SELECT id FROM membres WHERE pseudo = '$pseudo' ; ");
	$recupID->setFetchMode(PDO::FETCH_OBJ);
		if($recupID->rowCount()){
			$recupID = $recupID->fetchAll(); 
			$recupID = $recupID[0]->id; 
		}
		
	// 2. On compte le nombre de requête faites pour chaque jour 
	$req = $pdo->query("SELECT dayname(creation) AS day, count(*) AS nbDays FROM urls WHERE auteur = $recupID GROUP BY dayname(creation);");
	//$req->setFetchMode(PDO::FETCH_OBJ);
	$tabStats = $req->fetchAll();

	
	// 3. Données pour les nombres de clics 
	$recupAll = $pdo->query("SELECT ur.id AS idUrl, ur.courte AS url, COUNT(*) AS nb FROM utilisations ut, urls ur WHERE ut.url = ur.id AND ur.auteur = $recupID GROUP BY ur.id, ur.courte;");
	$statsClics = $recupAll->fetchAll();

		
	// calcul du total 
	$calcul = $pdo->query("SELECT count(*) as nb FROM urls WHERE auteur = '$recupID' ;");
	$calcul->setFetchMode(PDO::FETCH_OBJ);
	$result=$calcul->fetch();
	$total = $result->nb ;
	

?>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Jour', 'nombres d\'urls crées'],
          <?php foreach($tabStats as $stats) { ?>
		  ['<?php echo $stats['day']; ?>', <?php echo $stats['nbDays']; ?>],
		  <?php } ?>
		  
		
        ]);

        var options = {
          title: 'Jours de création de vos urls',
          hAxis: {title: 'Jours', titleTextStyle: {color: 'grey'}, minTextSpacing: 80},
		  bar: {groupWidth: '30%'},
		  vAxis: {format:'#'} 
        };
		  var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
	}
	</script>
	

	<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Url', 'nombres de clics'],
          <?php foreach($statsClics as $stats) { ?>
		  ['<?php echo $stats['url']; ?>', <?php echo $stats['nb']; ?>],
		  <?php } ?>
        ])

        var options = {
          title: 'Utilisations de mes urls réduites.'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
	</script>
	<div id="chart_div"></div>
	<div id="chart_div2"></div>



<?php
finHTML();
?>