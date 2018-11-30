<?php

/**
 * deleteInvoice.php
 *
 * Nimmt Löschanferoderungen für Rechnungen entgegen und 
 * ruft in der Datenbank die entsprechende Funktion auf.
 *
 * @category   Controller
 * @author     Malik
 */
include '../sessionHandling.php';
include '.././DAO.php';
$sh = sessionHandling::Instance();
$sh->open_session(); //vorhandene session übernehmen
$sh->regenerate_session_id();
$sh->isCorrectPape("abwart");

$dbc = DAO::Instance();
$dbc->connect();

if (isset($_GET['invoice_id'])) {
    $invoiceId = $_GET['invoice_id'];
    $dbc->deleteInvoice($invoiceId);
}

header("Location:../user/manageUsers.php");
