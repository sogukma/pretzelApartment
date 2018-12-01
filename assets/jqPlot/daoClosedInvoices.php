<?php

include '../sessionHandling.php';
include '.././DAO.php';
include '.././TemplateView.php';
/*
$sh = sessionHandling::Instance();
$sh->open_session(); //vorhandene session übernehmen
$sh->regenerate_session_id();
$sh->isCorrectPape("abwart");*/

$dbc = DAO::Instance();
$dbc->connect();

$ergebnis = $dbc->selectClosedInvoices();
$jsonInvoices = "[";
while ($zeile = $dbc->iterateResult($ergebnis)) {
//    echo '<h3 value="' . TemplateView::noHTML($zeile[0]) . '">Rechnungen von ' . TemplateView::noHTML($zeile[0]) . '</h3>';

     $jsonInvoices = $jsonInvoices. '["'.$zeile[0].'",'.$zeile[1].'], ';
     
}
//letzter komma wird entfernt, damit es ein gültiger JSON wird
$jsonInvoices=rtrim($jsonInvoices,", ");
$jsonInvoices = $jsonInvoices. "]";
//JSON wird ausgegeben, damit JavaScript ihn einlesen kann
echo $jsonInvoices;
?>