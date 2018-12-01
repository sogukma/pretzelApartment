<?php
/**
 * manageUsers.php
 *
 * Ansichtsseite zum Verwalten von Benutzern.
 * Von hier aus können Benutzer angesehen, erstellt, bearbeitet und gelöscht werden.
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
                $('.delete').click(function () {

                    var data = $(this).parent().parent().parent().attr('id');
                    window.location.href = "deleteUser.php?user_id=" + encodeURIComponent(data)

                });

                $('.update').click(function () {
                    data = $(this).parent().parent().parent().attr('id');
                    window.location.href = "updateUser.php?user_id=" + encodeURIComponent(data)

                });


                $('.rechnung').click(function () {
                    data = $(this).parent().parent().parent().attr('id');
                    window.location.href = "../invoice/manageInvoices.php?user_id=" + encodeURIComponent(data);

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
                        <li><a href="manageUsers.php">Benutzerübersicht</a></li>   
                        <li><a href="../statistic/statisticView.php">Statistik Rechnungen</a></li>
                        <li><a href="../index.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>


        <!-- The design of follwing table is based in this work: https://bootsnipp.com/snippets/featured/bootstrap-snipp-for-datatable-->

        <div class="container">
            <div class="row">


                <div class="col-md-12">
                    <div class="table-responsive">

                        <h3>Benutzerübersicht</h3>

                        <table class="table table-bordred table-striped">

                            <?php
                            /* $ergebnis = $_SESSION['dbconnection']->selectUsersColumnNames();
                              echo '<thead>';


                              while ($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis)) {
                              echo '<th>' . TemplateView::noHTML($zeile[0]) . '</th>';
                              } */
                            echo '<thead>'
                            . '<th>User Id</th>'
                            . '<th>Benutzername</th>'
                            . '<th>Benutzertyp</th>'
                            . '<th>Nachname</th>'
                            . '<th>Vorname</th>'
                            . '<th>Strassen-<br/>nummer</th>'
                            . '<th>Löschen</th>'
                            . '<th>Bearbeiten</th>'
                            . '<th>Rechnungen <br/> einsehen</th>'
                            . '</thead><tbody>';
                            $ergebnis = $_SESSION['dbconnection']->selectUsers();
                            /* alle Benutzerdaten aus Db werden eingelesen und angezeigt */

                            while ($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis)) {

                                echo '<tr id="' . $zeile[0] . '">'
                                . '<th scope="row">' . TemplateView::noHTML($zeile[0]) . '</th>'
                                . '<td>' . TemplateView::noHTML($zeile[1]) . '</td>'
                                . '<td>' . TemplateView::noHTML($zeile[3]) . '</td>'
                                . '<td>' . TemplateView::noHTML($zeile[5]) . '</td>'
                                . '<td>' . TemplateView::noHTML($zeile[6]) . '</td>'
                                . '<td>' . TemplateView::noHTML($zeile[4]) . '</td>'
                                . '<td><p data-placement="top" data-toggle="tooltip" title="Löschen"><button class="btn btn-danger btn-xs delete" data-title="Löschen" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>'
                                . '<td><p data-placement="top" data-toggle="tooltip" title="Bearbeiten"><button class="btn btn-primary btn-xs update" data-title="Bearbeiten" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>'
                                . '<td><p data-placement="top" data-toggle="tooltip" title="Rechnungen einsehen"><button class="btn btn-primary btn-xs rechnung" data-title="Rechnung einsehen" data-toggle="modal" ><span class="glyphicon glyphicon-align-left"></span></button></p></td>';
                            }
                            echo '</tbody>';
                            ?>

                        </table>
                        <form action="insertUser.php" method="post">
                            <input class="btn" type="submit" value="Benutzer hinzufügen" />
                        </form>
                    </div></div></div></div>


    </body>
</html>




