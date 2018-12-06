<?php
/**
 * statisticView.php
 *
 * Erstellt die Statistikauswertung bestehend aus einem grafischen Liniendiagramm
 * und einer textuellen Auswertung.
 * 
 * @category   View
 * @author     Malik
 */
include '../sessionHandling.php';
include '../dbConnector.php';
include '.././TemplateView.php';

$sh = sessionHandling::Instance();
$sh->open_session(); //vorhandene session übernehmen
$sh->regenerate_session_id();
$sh->isCorrectPape("abwart");


?>﻿
<!DOCTYPE html>
<html>
    <head>

        <title></title>
        <meta charset="utf-8" />

    <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]-->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 
        <script language="javascript" type="text/javascript" src="../assets/jqPlot/jquery.jqplot.min.js"></script>
        <script language="javascript" type="text/javascript" src="../assets/jqPlot/plugins/jqplot.logAxisRenderer.min.js"></script>
        <script language="javascript" type="text/javascript" src="../assets/jqPlot/plugins/jqplot.barRenderer.min.js"></script>
        <script language="javascript" type="text/javascript" src="../assets/jqPlot/plugins/jqplot.dateAxisRenderer.js"></script>
        <script language="javascript" type="text/javascript" src="../assets/jqPlot/plugins/jqplot.highlighter.js"></script>
        <link rel="stylesheet" type="text/css" href="../assets/jqPlot/jquery.jqplot.css" />
        <!-- for the legend-->
        <link rel="stylesheet" type="text/css" href="legendStyle.css"/>
        <link rel="stylesheet" type="text/css" href="../Header-Picture.css">
        <link rel="stylesheet" href="../style.css">
        <!-- Latest compiled and minified CSS -->
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>       
   <!--    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->



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
                        <li><a href="../user/manageUsers.php">Benutzerübersicht</a></li>   
                        <li><a href="../statistic/statisticView.php">Statistik Rechnungen aller Mieter</a></li>
                        <li><a href="../index.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="containerdiv" class="container">
            <h3>Verlauf der Rechungszustände</h3>
            <div id="chartdiv" class="col-md-8 statcont">
                <!-- This legend is based on following work: https://tilemill-project.github.io/tilemill/docs/guides/advanced-legends/-->
                <div class='my-legend'>

                    <div class='legend-scale'>
                        <ul id="plotLegend" class='legend-labels'>
                            <li><span style='background:#8DD3C7;'></span></li>
                            <li><span style='background:#FF8C00;'></span></li>
                        </ul>
                    </div>

                </div>
                <br/><br/>

                <div id="chart1"></div>
            </div>  

            <div id="textualdiv" class="col-md-4">
                <table  class="table table-hover">

                    <thead class="thead-inverse">
                        <tr>
                            <th>Rechnungsstatus</th>
                            <th>Betrag</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>offene Rechnungen</td>
                            <td id="line1">CHF                              
                                <?php
                                $ergebnis = $dbc->selectSumOfOpenInvoices();

                                while ($zeile = $dbc->iterateResult($ergebnis)) {
                                    echo TemplateView::noHTML($zeile[0]);
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>geschlossene Rechnungen</td>
                            <td id="line2">CHF 
                                <?php
                                $ergebnis = $dbc->selectSumOfClosedInvoices();

                                while ($zeile = $dbc->iterateResult($ergebnis)) {
                                    echo TemplateView::noHTML($zeile[0]);
                                }
                                ?>    
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <script type="text/javascript" src="jqplotScript.js">


        </script>

    </body>
</html>
