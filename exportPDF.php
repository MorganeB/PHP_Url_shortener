<?php
require('lib/fpdf.php');
require_once("tools.php");
require_once("connect.php");

class PDF extends FPDF{

var $widths;
var $aligns;

function SetWidths($w)
{
    //Tableau des largeurs de colonnes
    $this->widths=$w;
}

function SetAligns($a)
{
    //Tableau des alignements de colonnes
    $this->aligns=$a;
}

function NbLines($w,$txt)
{
    //Calcule le nombre de lignes qu'occupe un MultiCell de largeur w
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
function Row($data)
{
    //Calcule la hauteur de la ligne
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Dessine les cellules
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Sauve la position courante
        $x=$this->GetX();
        $y=$this->GetY();
        //Dessine le cadre
        $this->Rect($x,$y,$w,$h);
        //Imprime le texte
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Repositionne à droite
        $this->SetXY($x+$w,$y);
    }
    //Va à la ligne
    $this->Ln($h);
}

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
    $pdf->Cell(110,7,'Source',1);
	$pdf->Cell(50, 7, 'Raccourcie', 1);
	$pdf->Cell(30, 7, 'Utilisations', 1);
    $pdf->Ln();
	
// on boucle 
$pdf->SetWidths(array(110, 50, 30));
	foreach ($recupAll as $f){
		// pour compter les utilisations 
		$idURL = $f->id;
		$req = $pdo->query("SELECT count(*) AS nb FROM utilisations WHERE url = '$idURL' ;");
		$req->setFetchMode(PDO::FETCH_OBJ);
		$result=$req->fetch();
		
		$source = $f->source;
		$courte = $f->courte;
		$pdf->SetFont('Arial','',6);
		$pdf->Row(array($source, $courte, $result->nb));
      
}
    

$pdf->Output('export_historique.pdf', 'I');




	


