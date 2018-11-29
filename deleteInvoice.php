<?php
     include 'sessionHandling.php';
    include './DAO.php';
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

 header("Location:manageUsers.php");