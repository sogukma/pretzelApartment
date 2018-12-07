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
include '.././TemplateView.php';
include '../dbConnector.php';
$sh = sessionHandling::Instance();
$sh->open_session(); //vorhandene session übernehmen
$sh->regenerate_session_id();
$sh->isCorrectPape("abwart");


?>
<html>
    <head>


    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

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
        <!-- Nav-Bar und alle JavaScript-Libraries werden included  -->
        <?php
        include '../Header.html';
        ?>


        <!-- The design of follwing table is based in this work: https://bootsnipp.com/snippets/featured/bootstrap-snipp-for-datatable-->

        <div class="container">
            <div class="row">


                <div class="col-md-12">
                    <div class="table-responsive">

                        <h3>Benutzerübersicht</h3>

                        <table class="table table-bordred table-striped">

                            <?php
                            /* $ergebnis = $dbc->selectUsersColumnNames();
                              echo '<thead>';


                              while ($zeile = $dbc->iterateResult($ergebnis)) {
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
                            $ergebnis = $dbc->selectUsers();
                            /* alle Benutzerdaten aus Db werden eingelesen und angezeigt */

                            while ($zeile = $dbc->iterateResult($ergebnis)) {

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




