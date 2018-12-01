<?php
include '../sessionHandling.php';
include '.././DAO.php';
$_SESSION['dbconnection'] = DAO::Instance();
$_SESSION['dbconnection']->connect();
?>﻿
<!DOCTYPE html>
<html>
    <head>

        <title></title>
        <meta charset="utf-8" />

    <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]-->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script language="javascript" type="text/javascript" src="jquery.jqplot.min.js"></script>
        <script language="javascript" type="text/javascript" src="plugins/jqplot.logAxisRenderer.js"></script>
        <script language="javascript" type="text/javascript" src="plugins/jqplot.barRenderer.min.js"></script>
        <script language="javascript" type="text/javascript" src="plugins/jqplot.dateAxisRenderer.js"></script>
        <script language="javascript" type="text/javascript" src="plugins/jqplot.highlighter.js"></script>
        <link rel="stylesheet" type="text/css" href="jquery.jqplot.css" />
       <!-- for the legend-->
       <link rel="stylesheet" type="text/css" href="legendStyle.css"/>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>



    </head>
    <body>
        <div id="containerdiv" class="container">
            <div id="textualdiv" class="col-md-4">
                <table  class="table table-hover">

                    <thead class="thead-inverse">
                        <tr>
                            <th>Rechnungsstatus</th>
                            <th>Betrag in CHF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>geöffnete Rechnungen</td>
                            <td id="line1"><?php $_SESSION['dbconnection']->selectSumOfOpenInvoices() ?></td>
                        </tr>
                        <tr>
                            <td>geschlossene Rechnungen</td>
                            <td id="line2">551.9 MB</td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div id="chartdiv" class="col-md-8">
                <!-- This legend is based on following work: https://tilemill-project.github.io/tilemill/docs/guides/advanced-legends/-->
                <div class='my-legend'>
                    
                    <div class='legend-scale'>
                        <ul id="plotLegend" class='legend-labels'>
                            <li><span style='background:#8DD3C7;'></span></li>
                            <li><span style='background:#FFFFB3;'></span></li>
                        </ul>
                    </div>
       
                </div>
                <br/><br/>

                <div id="chart1"></div>
            </div>  

        </div>
        <script type="text/javascript" src="jqplotScript.js">


        </script>

    </body>
</html>
