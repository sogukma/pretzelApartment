<?php
/**
 * pdferstellen.php
 *
 *Hier werden die offenen Rechnungen als ein PDF-Datei generiert.
 *
     
 */
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
        //Company Adress
        $this->SetFont('Arial', 'B', 12); //Font
        $this->Image('pretzelIconsmall.png',10,5);
        $this->Cell(189,30,'',0,1);//end of line
        $this->Cell(130,5,'Pretzel Real Estate Inc.',0,0);
        $this->Cell(59,5,'',0,1);//end of line


        $this->SetFont('Arial','', 12);
        $this->Cell(30,2,'',0,1);
        $this->Cell(130,5,'Musterstrasse 24',0,0);
        $this->Cell(59,5,'',0,1);

        $this->Cell(130,5,'4001 Basel',0,0);
        $this->Cell(25,5,'Datum:',0,0);
        $this->Cell(34,5,''.date("j.n.Y"),0,1);

        $this->Cell(130,5,'Telefon: +41 62 876 90 43',0,0);
        $this->Cell(25,5,'Kunden-ID:',0,0);
        $this->Cell(34,5,''.$_GET['fk_user_id'],0,1);

        $this->Cell(130,5,'Fax: +41 62 876 90 40',0,0);
        $this->Cell(25,5,'',0,0);
        $this->Cell(34,5,'',0,1);//end of line
        
        $this->Cell(130,5,'info@pretzelrealestate.ch',0,0);
        $this->Cell(25,5,'',0,0);
        $this->Cell(34,5,'',0,1);//end of line

        //dummy empty cell, vertical
        $this->Cell(189,15,'',0,1);
        
        //billing adress
        $this->SetFont('Arial', 'B', 14); //Font
        $this->Cell(130,5,'Rechnung',0,0);
        $this->Cell(25,5,'',0,0);
        $this->Cell(34,5,'',0,1);
        $this->Cell(189,3,'',0,1);

        $this->SetFont('Arial', '', 12); //Font
        
        //Individual adress (doesnt work)
        function viewTable2($db, $userId){
        $stmt2 = $db->query("select user_streetnumber from users WHERE user_id = '$userId'");
        $data = $stmt2->fetch(PDO::FETCH_OBJ);
     
        //$this->Cell(30,5,'',0,0);
        //$this->Cell(70,5,$data->user_streetnumber,1,1);
   }
                
        $this->Cell(30,5,'An:',0,0);
        $this->Cell(70,5,'Vorname Name',0,1); //<----------------------------
        
        $this->Cell(30,5,'',0,0);
        $this->Cell(70,5,'Strasse',0,1); //<----------------------------------
        

        //dummy empty cell, vertical
        $this->Cell(189,15,'',0,1);//end of line
    }
    
    //page number
    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','',10);
        $this->Cell(0,10,'Seite '.$this->PageNo().'/{nb}',0,0,'C');
    }
    
    function headerTable(){
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(25,7,'ID',1,0);
        $this->Cell(50,7,'Rechnungstyp',1,0);
        $this->Cell(35,7,'Gestellt am',1,0);
        $this->Cell(35,7,'Betrag',1,1); //end of line
        
    }
    
    function viewTable($db, $userId){
        $this->SetFont('Arial','',12);
        $stmt = $db->query("select * from rechnung WHERE fk_userId = '$userId' AND status = 'offen'");
        while($data = $stmt->fetch(PDO::FETCH_OBJ)){
                                  
            $this->SetFont('Arial', '', 12);
            $this->Cell(25,7,$data->id,1,0);
            $this->Cell(50,7,$data->rechnungstyp,1,0);
            $this->Cell(35,7,$data->gestellt_am,1,0);
            $this->Cell(35,7,$data->betrag,1,1,'R'); 
        }
        //Betrag sum (doenst work)
        
        //$sum= mysql_query("select sum(betrag) from rechnung WHERE status = 'offen'");
        //$row = mysql_fetch_array($sum);
                        
        //$sum = $db->query("select sum(betrag) from rechnung WHERE status = 'offen'");
        //$data2 = $sum->fetch(PDO::FETCH_OBJ);
        
        //$query = "select sum(betrag) from rechnung WHERE status = 'offen'";  
        //$result = mysql_query($query); 
        //$row = mysql_fetch_array($result);
        
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(25,7,'',0,0);
        $this->Cell(74,7,'                                           Summe',0,0);
        $this->Cell(11,7,'CHF',0,0);
        $this->Cell(35,7,'PREIS',1,1,'R'); //<---------------------------
   }
   
   
}

//generating PDF

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4',0);
$pdf->headerTable();
$pdf->viewTable($db, $userId);
//$pdf->viewTable2($db, $userId);
$pdf->Output();

?>

