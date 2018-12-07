<?php
/**
 * pdferstellen.php
 *
 * Die Rechnungen werden übersichtlich in einem PDF-Format generiert.
 *
 * @category   View, Model
 * @author     Necati (code), (design)
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
        $this->SetFont('Arial', 'B', 15); //Font
        $this->Cell(130,5,'Rechnung',0,0);
        $this->Cell(25,5,'',0,0);
        $this->Cell(34,5,'',0,1);
        $this->Cell(189,3,'',0,1);

        $this->SetFont('Arial', '', 12); //Font   
   }
    
    function useradress($db, $userId){
        $stmt2 = $db->query("select user_firstname from users WHERE user_id = '$userId'");
        $data2 = $stmt2->fetch(PDO::FETCH_OBJ);       
        
        $stmt3 = $db->query("select user_surname from users WHERE user_id = '$userId'");
        $data3 = $stmt3->fetch(PDO::FETCH_OBJ);
        
        $stmt4 = $db->query("select user_streetnumber from users WHERE user_id = '$userId'");
        $data4 = $stmt4->fetch(PDO::FETCH_OBJ);
        
        $this->Cell(30,5,'An: ',0,0);
        $this->Cell(15,5,$data2->user_firstname.' '.$data3->user_surname,0,1);
        $this->Cell(30,5,'',0,0);
        $this->Cell(70,5,$data4->user_streetnumber,0,1);
        $this->Cell(189,15,'',0,1); //empty cell
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
        
    }
    
    function sum($db, $userId){
        
        $stmt4 = $db->query("select sum(betrag) from rechnung WHERE fk_userId = '$userId' AND status = 'offen'");
        $data4 = $stmt4->fetch(PDO::FETCH_OBJ);
        
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(25,7,'',0,0);
        $this->Cell(74,7,'                                           Summe',0,0);
        $this->Cell(11,7,'CHF',0,0);
        //$this->Cell(35,7,$data4->sum(betrag),1,1,'R');
        
    }

   
       //page number
    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','',12);
        $this->Cell(0,10,'Seite '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

//generating PDF

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4',0);
$pdf->useradress($db, $userId);
$pdf->headerTable();
$pdf->viewTable($db, $userId);
$pdf->sum($db, $userId);
$pdf->Output();

?>

