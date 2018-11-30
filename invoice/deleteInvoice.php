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
    $_SESSION['fk_user_id'] = $_GET['fk_user_id'];
    $dbc->deleteInvoice($invoiceId);


header("Location:../invoice/manageInvoices.php?user_id=".$_SESSION['fk_user_id']);
}