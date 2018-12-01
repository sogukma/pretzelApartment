<?php
/**
 * daoClosedInvoices.php
 *
 * Holt Daten aus der Datenbank zur Erstellung 
 * der Linie "geschlossenen Rechnungen" im Liniendiagramm.
 *
 * @category   Controller
 * @author     Malik
 */

include '../sessionHandling.php';
include '.././DAO.php';
include '.././TemplateView.php';
$sh = sessionHandling::Instance();
$sh->open_session(); //vorhandene session übernehmen
$sh->regenerate_session_id();
$sh->isCorrectPape("abwart");

$dbc = DAO::Instance();
$dbc->connect();

$ergebnis = $dbc->selectClosedInvoices();
$jsonInvoices = "[";
while ($zeile = $dbc->iterateResult($ergebnis)) {

    $jsonInvoices = $jsonInvoices . '["' . TemplateView::noHTML($zeile[0]) . '",' . TemplateView::noHTML($zeile[1]) . '], ';
}
//letzter komma wird entfernt, damit es ein gültiger JSON wird
$jsonInvoices = rtrim($jsonInvoices, ", ");
$jsonInvoices = $jsonInvoices . "]";
//JSON wird ausgegeben, damit JavaScript ihn einlesen kann
echo $jsonInvoices;
?>