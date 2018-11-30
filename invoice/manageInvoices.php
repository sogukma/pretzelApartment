<?php
/**
 * manageInvoices.php
 *
 * Ansichtsseite zum Verwalten von Rechnungen eines Benutzers.
 * Von hier aus können Rechnungen angesehen, erstellt, bearbeitet und gelöscht werden.
 *
 * @category   View, Model
 * @author     Malik (code), Halil (design)
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
$_SESSION['dbconnection'] = $dbc;
$_SESSION['user_id'] = $_GET['user_id'];
?>

<html>
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

        <!------ Include the above in your HEAD tag ---------->


        <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>       
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../Header-Picture.css">


        <script type='text/javascript'>
            $(document).ready(function () {
                //hiermit werden die gesamten offenen Kosten berechnet und in die View eingefügt.
                var totalCosts = 0;
                $('#manageInvoices tr').each(function () {

                    if ($(this).find(".status").html() == "offen")
                    {
                        totalCosts += parseFloat($(this).find(".cost").attr("name"));
                    }

                });
                $('#totalcosts').append(totalCosts);

                $('.updateInvoice').click(function () {

                    var invoiceId = $(this).parent().parent().parent().attr('id');
                    var fkUserId = $(this).parent().parent().parent().find(".fkUserId").html();
                    window.location.href = "updateInvoice.php?invoice_id=" + encodeURIComponent(invoiceId) + "&fk_user_id=" + encodeURIComponent(fkUserId);
    

                });

                $('.deleteInvoice').click(function () {

                    var invoiceId = $(this).parent().parent().parent().attr('id');
                    var fkUserId = $(this).parent().parent().parent().find(".fkUserId").html();
                    window.location.href = "deleteInvoice.php?invoice_id=" + encodeURIComponent(invoiceId) + "&fk_user_id=" + encodeURIComponent(fkUserId);      
   

                });



            });
        </script>
    </head>
    <body>
        <!-- Der Nav-Bar wurde von hier entnommen: https://demo.tutorialzine.com/2016/09/freebie-5-beautiful-bootstrap-headers/#Header-Picture-->
        <nav class="navbar navbar-default" id="navigation-purple">
            <div class="container">
                <a href="#"><img class="img-responsive img-circle avatar" src="../pictures/pretzelIcon.png" alt="Avatar"></a>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="../index.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="content">



            <div>
                <div class="container">
                    <div class="row">


                        <div class="col-md-12">
                            <div class="table-responsive">    
                                <?php
                                $ergebnis = $_SESSION['dbconnection']->selectUsersNameById($_SESSION['user_id']);

                                while ($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis)) {
                                    echo '<h3 value="' . TemplateView::noHTML($zeile[0]) . '">Rechnungen von ' . TemplateView::noHTML($zeile[0]) . '</h3>';
                                }
                                ?>
                                <table id="manageInvoices" class="table table-bordred table-striped">

                                    <?php
                                    $ergebnis = $_SESSION['dbconnection']->selectInvoicesColumnNames();

                                    echo '<thead>'
                                    . '<th>RechnungId</th>'
                                    . '<th>Rechnungstyp</th>'
                                    . '<th>Status</th>'
                                    . '<th>Betrag</th>'
                                    . '<th>UserId</th>'
                                    . '<th>Gestellt am</th>'
                                    . '<th>Bezahlt am</th>'
                                    . '<th>Löschen</th><th>Status ändern</th>';
                                    echo '</thead><tbody>';
                                    $ergebnis = $_SESSION['dbconnection']->selectInvoicesFromUserById($_SESSION['user_id']);

                                    /* alle Benutzerdaten aus Db werden eingelesen und angezeigt */
                                    while ($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis)) {

                                        echo '<tr id="' . TemplateView::noHTML($zeile[0]) . '">'
                                        . '<th scope="row">' . TemplateView::noHTML($zeile[0]) . '</th>'
                                        . '<td>' . TemplateView::noHTML($zeile[1]) . '</td>'
                                        . '<td class="status">' . TemplateView::noHTML($zeile[2]) . '</td>'
                                        . '<td name="' . TemplateView::noHTML($zeile[3]) . '" class="cost">CHF ' . TemplateView::noHTML($zeile[3]) . '</td>'
                                        . '<td id="fk' . TemplateView::noHTML($zeile[4]) . '" class="fkUserId">' . TemplateView::noHTML($zeile[4]) . '</td>'
                                        . '<td>' . TemplateView::noHTML($zeile[5]) . '</td>'
                                        . '<td>' . TemplateView::noHTML($zeile[6]) . '</td>'
                                        . '<td><p data-placement="top" data-toggle="tooltip" title="Löschen"><button class="btn btn-danger btn-xs deleteInvoice" data-title="Löschen" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>'
                                        . '<td><p data-placement="top" data-toggle="tooltip" title="Bearbeiten"><button class="btn btn-primary btn-xs updateInvoice" data-title="Bearbeiten" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>'
                                        . '</tr>';
                                    }
                                    echo '<tr><th></th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
                                    echo '<tr><th scope="row">Total Offene Kosten</th><td></td><td></td><td id="totalcosts">CHF </td><td></td><td></td><td></td><td></td><td></td></tr>';
                                    echo '</tbody>';
                                    ?>

                                </table>
                                <form action="../pdferstellen.php?fk_user_id=<?= $_GET['user_id'] ?>" method="post">
                                    <input class="btn" type="submit" value="Rechnung als PDF anzeigen">
                                </form>
                                <form action="insertInvoice.php?fk_user_id=<?= $_GET['user_id'] ?>" method="post">
                                    <input class="btn" type="submit" value="Rechnung hinzufügen" />
                                </form>

                            </div></div></div></div>
            </div>
            <br/>


        </div>
    </body>
</html>

