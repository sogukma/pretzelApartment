<?php
/**
 * pdferstellen.php
 *
 * Die Rechnungen werden übersichtlich in einem PDF-Format generiert.
 * Prepared Statements verhindern hier SQL-Injections
 *
 * @category   View, Model
 * @author     Necati (code, design)
 */

include 'sessionHandling.php';
$sh = sessionHandling::Instance();
$sh->open_session(); //vorhandene session übernehmen
$sh->regenerate_session_id();
$sh->isCorrectPape("abwart");

require("fpdf.php");
$db = new PDO('mysql:host=eu-cdbr-west-02.cleardb.net;dbname=heroku_264d8c0ac2b1d8d', 'b46bd03f9f4fdf', 'cb61f804');

$userId = $_GET['fk_user_id'];
define('u',chr(252));

class myPDF extends FPDF {

    //picture
    function pix(){
        $this->Image('pretzelIconsmall.png', 166, 8);
        $this->Cell(189, 3, '', 0, 1); //end of line
    }
    
    //company adress
    function company($db, $userId) {
        //Company Adress
        $this->SetFont('Arial', 'B', 12); //Font
        $this->Cell(130, 5, 'Pretzel Real Estate Inc.', 0, 0);
        $this->Cell(59, 5, '', 0, 1);
        
        $this->SetFont('Arial', '', 12);
        $this->Cell(30, 2, '', 0, 1);
        $this->Cell(130, 5, 'Herbrigstrasse 29', 0, 0);
        $this->Cell(59, 5, '', 0, 1);

        $this->Cell(130, 5, '9011 St. Gallen', 0, 0);
        $this->Cell(25, 5, '', 0, 0);
        $this->Cell(34, 5, '', 0, 1);

        $this->Cell(130, 5, 'Telefon: +41 62 876 90 43', 0, 0);
        $this->Cell(25, 5, '', 0, 0);
        $this->Cell(34, 5, '', 0, 1);

        $this->Cell(130, 5, 'Fax: +41 62 876 90 40', 0, 0);
        $this->Cell(25, 5, '', 0, 0);
        $this->Cell(34, 5, '', 0, 1);

        $this->Cell(130, 5, 'info@pretzelrealestate.ch', 0, 0);
        $this->Cell(25, 5, '', 0, 0);
        $this->Cell(34, 5, '', 0, 1);

        $this->Cell(189, 15, '', 0, 1); //empty cell, vertical
           
    }
    // renter adress
    function useradress($db, $userId) {
        $this->SetFont('Arial', '', 12); //Font
        $stmt2 = $db->prepare("select user_firstname from users WHERE user_id = ?");
        $stmt2->bindParam(1, $userId);
        $stmt2->execute();
        $data2 = $stmt2->fetch(PDO::FETCH_OBJ);

        $stmt3 = $db->prepare("select user_surname from users WHERE user_id = ?");
        $stmt3->bindParam(1, $userId);
        $stmt3->execute();
        $data3 = $stmt3->fetch(PDO::FETCH_OBJ);
        
        $stmt7 = $db->prepare("select user_streetnumber from users WHERE user_id = ?");
        $stmt7->bindParam(1, $userId);
        $stmt7->execute();
        $data7 = $stmt7->fetch(PDO::FETCH_OBJ);
        
        $this->Cell(30, 5, $data2->user_firstname . ' ' . $data3->user_surname, 0, 1);
        $this->Cell(30, 5, 'Bergstrasse ' . $data7->user_streetnumber, 0, 1);
        $this->Cell(30, 5, '4051 Basel', 0, 1);
        $this->Cell(189, 13, '', 0, 1); //empty cell
    }
    
     //"Rechnung"-title
    function adress($db, $userId){
        $stmt7 = $db->prepare("select user_streetnumber from users WHERE user_id = ?");
        $stmt7->bindParam(1, $userId);
        $stmt7->execute();
        $data7 = $stmt7->fetch(PDO::FETCH_OBJ);
        
        $this->SetFont('Arial', '', 12);
        $this->Cell(25, 5, 'St. Gallen, '. date("j.n.Y"), 0, 1);
        $this->Cell(189, 5, '', 0, 1);
        $this->SetFont('Arial', 'B', 15); //Font
        $this->Cell(130, 5, 'Offene Rechnungen', 0, 1);
        $this->SetFont('Arial', '', 12);
        $this->Cell(189, 5, '', 0, 1);
        $this->Cell(189, 5, 'Sehr geehrte Damen und Herren', 0, 1);
        $this->Cell(189, 5, 'F'.u.'r Ihre Wohnung an der Bergstrasse '.$data7->user_streetnumber.' erhalten Sie die zu begleichenden Rechnungen.', 0, 1);
        $this->Cell(189, 5, 'Diese sind zahlbar innert zwei Arbeitswochen.', 0, 1);
        $this->Cell(189, 8, '', 0, 1); //empty cell vertical
    }

    //head (titel) of the table
    function tableHead() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(25, 7, 'ID', 1, 0);
        $this->Cell(50, 7, 'Rechnungstyp', 1, 0);
        $this->Cell(35, 7, 'Gestellt am', 1, 0);
        $this->Cell(35, 7, 'Betrag', 1, 1); //end of line
    }

    //Body of the table
    function tableBody($db, $userId) {
        $this->SetFont('Arial', '', 12);
        $stmt = $db->prepare("select * from rechnung WHERE fk_userId = ? AND status = 'offen'");
        $stmt->bindParam(1, $userId);
        $stmt->execute();

        while ($data = $stmt->fetch(PDO::FETCH_OBJ)) {

            $this->SetFont('Arial', '', 12);
            $this->Cell(25, 7, $data->id, 1, 0);
            $this->Cell(50, 7, $data->rechnungstyp, 1, 0);
            $this->Cell(35, 7, $data->gestellt_am, 1, 0);
            $this->Cell(35, 7, $data->betrag, 1, 1, 'R');
        }
    }

    //total cost of bills
    function sum($db, $userId) {
        $stmt4 = $db->prepare("select sum(betrag) as sumbetrag from rechnung WHERE fk_userId = ? AND status = 'offen'");
        $stmt4->bindParam(1, $userId);
        $stmt4->execute();

        $data4 = $stmt4->fetch(PDO::FETCH_OBJ);

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(25, 7, '', 0, 0);
        $this->Cell(85, 7, 'Summe ', 0, 0, 'R');
        $this->Cell(11, 7, 'CHF', 1, 0);
        $this->Cell(24, 7, $data4->sumbetrag, 1, 1, 'R');
    }
    
    //page number and greetings
    function footer() {
        $this->SetFont('Arial', '', 12);
        $this->Cell(25, 10, '', 0, 1);
        $this->Cell(11, 5, 'Bei Fragen und Unklarheiten stehen wir Ihnen gerne zu Verf'.u.'gung.', 0, 1);
        $this->Cell(11, 13, '', 0, 1);
        $this->Cell(11, 5, 'Mit freundlichen Gr'.u.'ssen', 0, 1);
        $this->Cell(11, 5, '', 0, 1);
        $this->Cell(11, 5, 'Alain Ernst', 0, 1);
        $this->Cell(11, 5, 'Verwalter Mietobjekte, Region Basel', 0, 1);
        $this->SetY(-15);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, 'Seite ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

//generating PDF
$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P', 'A4', 0);
$pdf->pix();
$pdf->company($db, $userId);
$pdf->useradress($db, $userId);
$pdf->adress($db, $userId);
$pdf->tableHead();
$pdf->tableBody($db, $userId);
$pdf->sum($db, $userId);
$pdf->Output();
?>

