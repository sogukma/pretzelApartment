<?php
 include 'sessionHandling.php';
    $sh = sessionHandling::Instance();
        $sh->open_session(); //vorhandene session übernehmen
        $sh->regenerate_session_id();
        $sh->isCorrectPape("abwart");


require("fpdf.php");
$db = new PDO('mysql:host=eu-cdbr-west-02.cleardb.net;dbname=heroku_264d8c0ac2b1d8d','b46bd03f9f4fdf','cb61f804');
$userId = $_GET['fk_user_id'];



class myPDF extends FPDF{
    function header(){
        
        $this->SetFont('Arial', 'B', 14); //Font
        $this->Image('pretzelIconsmall.png',10,5);
        $this->Cell(189,30,'',0,1);//end of line
        $this->Cell(130,5,'Pretzel Real Estate jdjddkdkkdkd.',0,0); //Head
        $this->Cell(59,5,'',0,1);//end of line


        $this->SetFont('Arial','', 12);
        $this->Cell(30,2,'',0,1);
        $this->Cell(130,5,'Musterstrasse 24',0,0); //Head
        $this->Cell(59,5,'',0,1);//end of line

        $this->Cell(130,5,'5000 Aarau',0,0); //Head
        $this->Cell(25,5,'Datum',0,0);
        $this->Cell(34,5,''.date("j.n.Y"),0,1);//end of line

        $this->Cell(130,5,'Telefon: +41 62 876 90 43',0,0); //Head
        $this->Cell(25,5,'Kunden-ID:',0,0);
        $this->Cell(34,5,''.$_GET['fk_user_id'],0,1);//end of line

        $this->Cell(130,5,'Fax: +41 62 876 90 40',0,0); //Head
        $this->Cell(25,5,'',0,0);
        $this->Cell(34,5,'',0,1);//end of line
        
        $this->Cell(130,5,'info@pretzelrealestate.ch',0,0); //Head
        $this->Cell(25,5,'',0,0);
        $this->Cell(34,5,'',0,1);//end of line

        //dummy empty cell, vertical
        $this->Cell(189,15,'',0,1);//end of line

        //billing adress
        
        $this->Cell(100,5,'Rechnung an: ',0,1);//end of line

        //ad dummy cell at beginning of each line
        $this->Cell(30,5,'',0,0);
        $this->Cell(70,5,'Vorname Name',0,1); //aus DB holen
        
        $this->Cell(30,5,'',0,0);
        $this->Cell(70,5,'Strasse',0,1); //aus DB holen
        

        //dummy empty cell, vertical
        $this->Cell(189,15,'',0,1);//end of line
    }
    
    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','',8);
        $this->Cell(0,10,'Seite '.$this->PageNo().'/{nb}',0,0,'C');
    }
    
    function headerTable(){
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(25,7,'ID',1,0);
        $this->Cell(65,7,'Rechnungstyp',1,0);
        $this->Cell(35,7,'Betrag',1,1); //end of line
        
    }
    
    function viewTable($db, $userId){
        $this->SetFont('Arial','',12);
        $stmt = $db->query("select * from rechnung WHERE fk_userId = '$userId' AND status = 'offen'");
        while($data = $stmt->fetch(PDO::FETCH_OBJ)){
                                  
            $this->SetFont('Arial', '', 12);
            $this->Cell(25,7,$data->id,1,0);
            $this->Cell(65,7,$data->rechnungstyp,1,0);
            $this->Cell(35,7,$data->betrag,1,1,'R'); 
        }
        //$sum= mysql_query("select sum(betrag) from rechnung WHERE status = 'offen'");
        //$row = mysql_fetch_array($sum);
        
        //$sum = $db->query("select sum(betrag) from rechnung WHERE status = 'offen'");
        //$data2 = $sum->fetch(PDO::FETCH_OBJ);
        
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(25,7,'',0,0);
        $this->Cell(65,7,'                                       Summe',0,0);
        $this->Cell(11,7,CHF,0,0);
        $this->Cell(24,7,'2500',1,1); //end of line
   }
}



$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4',0);
$pdf->headerTable();
$pdf->viewTable($db, $userId);
$pdf->Output();

?>

