<?php
require('lib/fpdf.php');
require_once("tools.php");
require_once("connect.php");

class PDF extends FPDF{


function Header(){
    $this->SetFont('Arial','B',10);
    $this->Cell(80);
    $this->Cell(30,10,'Historique de vos URLs',0,0,'C');
    $this->Ln(20);
}

// pied de page
function Footer(){
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// création du pdf
$pdf=new PDF();
$pdf->AliasNBPages();
$pdf->AddPage();

// requêtes
	$pseudo = $_SESSION['utilisateur'];
	$recupID = $pdo->query("SELECT id FROM membres WHERE pseudo = '$pseudo' ; ");
	$recupID->setFetchMode(PDO::FETCH_OBJ);
	if($recupID->rowCount()){
		$recupID = $recupID->fetchAll(); 
		$recupID = $recupID[0]->id; 
	}
	$recupAll = $pdo->query("SELECT * FROM urls WHERE auteur = $recupID ;");
	$recupAll->setFetchmode(PDO::FETCH_OBJ);

	

 //instanciation de chaque colonne 
    $pdf->Cell(120,7,'Source',1);
	$pdf->Cell(50, 7, 'Raccourcie', 1);
	$pdf->Cell(20, 7, 'Utilisations', 1);
    $pdf->Ln();
	
// on boucle 
	foreach ($recupAll as $f){
		// pour compter les utilisations 
		$idURL = $f->id;
		$req = $pdo->query("SELECT count(*) AS nb FROM utilisations WHERE url = '$idURL' ;");
		$req->setFetchMode(PDO::FETCH_OBJ);
		$result=$req->fetch();
		
		$source = $f->source;
		$courte = $f->courte;
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(60,6,$source,1);
        $pdf->Cell(50,6,$courte,1);
		$pdf->Cell(20,6,$result->nb,1);
        $pdf->Ln();
}
    

$pdf->Output('export_historique.pdf', 'I');




	


