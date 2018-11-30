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
                <caption>Date needs for a year</caption>
                <thead class="thead-inverse">
                    <tr>
                        <th>range</th>
                        <th>used memory</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Media Warehouse/Objekt-Datenbank</th>
                        <td id="line1">40.9 MB</td>
                    </tr>
                    <tr>
                        <th>Datastorage/Archive</th>
                        <td id="line2">551.9 MB</td>
                    </tr>

                </tbody>
            </table>
        </div>
        <!--- //div variante
        <div id="textualdiv" class="col-md-4">
            <h1 id="title" class="col-md-12">for a year</h1>
            <div id="line1" class="col-md-12">
                <p class="col-md-6">Media Warehouse/Objekt-Datenbank</p>
                <p class="col-md-6">40.9 MB</p>
            </div>
            <div id="line2" class="col-md-12">
                <p class="col-md-6">Datastorage/Archive</p>
                <p class="col-md-6">551.9 MB</p>
            </div>
            <div id="line3" class="col-md-12">
                <p class="col-md-6">Projektkomponenten</p>
                <p class="col-md-6">2913.0 MB</p>
            </div>
            <div id="line4" class="col-md-12">
                <p class="col-md-6">RCS(Komponenten-Versionen)</p>
                <p class="col-md-6">14.9 MB</p>
            </div>
        </div>--->


       <div id="chartdiv" class="col-md-8">
           <div id="chart1"></div>
       </div>  

    </div>
    <script type="text/javascript" src="script.js">


    </script>

</body>
</html>
