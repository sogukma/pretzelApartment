<?php
/**
 * update Invoice.php
 *
 * Stellt ein Formular für das Ändern des Status einer Rechnungen eines Benutzers zur Verfügung.
 * Beim Absenden des Formular wird in der Datenbank die entsprechende Funktion aufgerufen.
 *
 * @category   Controller, View
 * @author     Halil
 */
include '../sessionHandling.php';

$sh = sessionHandling::Instance();
$sh->open_session(); //vorhandene session übernehmen
$sh->regenerate_session_id();
$sh->isCorrectPape("abwart");



if (isset($_GET['invoice_id'])) {

    $_SESSION['invoice_id'] = $_GET['invoice_id'];
    $_SESSION['fk_user_id'] = $_GET['fk_user_id'];
} else {
    echo "Invoice Id nicht vorhanden";
}

function updateInvoice() {
    include '../dbConnector.php';
    $status = $_POST["status"];

    $dbc->updateInvoice($_SESSION['invoice_id'], $status, $_SESSION['fk_user_id']);

    header("Location:../invoice/manageInvoices.php?user_id=" . $_SESSION['fk_user_id']);
}

;

if (isset($_POST['submit'])) {
    updateInvoice();
}
?>
<html>
    <head>


        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
          <!-- Nav-Bar und alle JavaScript-Libraries werden included  -->
        <?php
        include '../Header.html';
        ?>
        <div class="insertForm rounded container">
            <h3>Rechnungsstatus ändern</h3>
            <form method="post" action="updateInvoice.php">

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="rechnungstyp">
                        <option value="geschlossen" checked>Geschlossen</option>
                        <option value="offen">Offen</option>
                    </select>
                </div>

                <input name="submit" class="btn btn-primary" type="submit"><input class="btn" type="reset"><br/>
            </form></body>
</html></div>