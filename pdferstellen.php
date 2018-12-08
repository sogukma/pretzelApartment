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

class myPDF extends FPDF {

    function header1($db, $userId) {
        //Company Adress
        $this->SetFont('Arial', 'B', 12); //Font
        $this->Image('pretzelIconsmall.png', 10, 5);
        $this->Cell(189, 30, '', 0, 1); //end of line
        $this->Cell(130, 5, 'Pretzel Real Estate Inc.', 0, 0);
        $this->Cell(59, 5, '', 0, 1);


        $stmt7 = $db->prepare("select user_streetnumber from users WHERE user_id = ?");
        $stmt7->bindParam(1, $userId);
        $stmt7->execute();

        $data7 = $stmt7->fetch(PDO::FETCH_OBJ);

        $this->SetFont('Arial', '', 12);
        $this->Cell(30, 2, '', 0, 1);
        $this->Cell(130, 5, 'Bergstrasse ' . $data7->user_streetnumber, 0, 0);
        $this->Cell(59, 5, '', 0, 1);

        $this->Cell(130, 5, '4001 Basel', 0, 0);
        $this->Cell(25, 5, 'Datum:', 0, 0);
        $this->Cell(34, 5, '' . date("j.n.Y"), 0, 1);

        $this->Cell(130, 5, 'Telefon: +41 62 876 90 43', 0, 0);
        $this->Cell(25, 5, 'Kunden-ID:', 0, 0);
        $this->Cell(34, 5, '' . $_GET['fk_user_id'], 0, 1);

        $this->Cell(130, 5, 'Fax: +41 62 876 90 40', 0, 0);
        $this->Cell(25, 5, '', 0, 0);
        $this->Cell(34, 5, '', 0, 1);

        $this->Cell(130, 5, 'info@pretzelrealestate.ch', 0, 0);
        $this->Cell(25, 5, '', 0, 0);
        $this->Cell(34, 5, '', 0, 1);

        //empty cell, vertical
        $this->Cell(189, 15, '', 0, 1);

        //"Rechnung"-Titel
        $this->SetFont('Arial', 'B', 15); //Font
        $this->Cell(130, 5, 'Rechnung', 0, 0);
        $this->Cell(25, 5, '', 0, 0);
        $this->Cell(34, 5, '', 0, 1);
        $this->Cell(189, 5, '', 0, 1); //empty cell vertical

        $this->SetFont('Arial', '', 12); //Font   
    }

    function useradress($db, $userId) {
        $stmt2 = $db->prepare("select user_firstname from users WHERE user_id = ?");
        $stmt2->bindParam(1, $userId);
        $stmt2->execute();
        $data2 = $stmt2->fetch(PDO::FETCH_OBJ);

        $stmt3 = $db->prepare("select user_surname from users WHERE user_id = ?");
        $stmt3->bindParam(1, $userId);
        $stmt3->execute();

        $data3 = $stmt3->fetch(PDO::FETCH_OBJ);

        $this->Cell(30, 5, 'An: ', 0, 0);
        $this->Cell(15, 5, $data2->user_firstname . ' ' . $data3->user_surname, 0, 1);
        $this->Cell(30, 5, '', 0, 0);
        $this->Cell(189, 13, '', 0, 1); //empty cell
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

    //page number
    function footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Seite ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

}

//generating PDF

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P', 'A4', 0);
$pdf->header1($db, $userId);
$pdf->useradress($db, $userId);
$pdf->tableHead();
$pdf->tableBody($db, $userId);
$pdf->sum($db, $userId);
$pdf->Output();
?>

