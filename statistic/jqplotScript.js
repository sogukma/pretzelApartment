/** 
 * jqplotScript.php
 *
 * Erstellt das Liniendiagramm für statisticView.php mithilfe jqPlot
 * Daten zum Liniendiagramm werden mit asynchronen AJAX-Calls aufgenommen
 *
 * @category   Model
 * @author     Malik
 *
 * 
 */
$(document).ready(function () {
    $.jqplot.config.enablePlugins = true;
    //lineURL beinhaltet die beiden Files, von wo aus Daten für Liniendiagramm gelesen werden
    var lineURL = ["daoOpenInvoices.php", "daoClosedInvoices.php"];
    //lines beinhaltet ein JSON, mit welcher das Liniendiagramm erstellt wird 
    var lines = [];
    //serieNames beinhaltet die Namen der beiden Rechnungstypen 
    var serieNames = ["offene Rechnungen", "geschlossene Rechnungen"];
    var remaining = lineURL.length;
   
    for (i = 0; i < lineURL.length; i++)
    {
        var legendPlace = 1;

        getJSON(lineURL[i], serieNames[i], function (response, serieName) {
            lines.push(response);
            //Legende zum Liniendiagramm wird beschriftet
            $("#plotLegend li:nth-child(" + legendPlace + ")").append(serieName);
            //erst wenn die Daten beider URLs gelesen wurden (also remaining-URLs = 0 ist) wird Liniendiagramm erstellt
            --remaining;
            if (remaining == 0)
            {

                var plot2 = $.jqplot('chart1', lines, {

                    show: true,
                    axes: {
                        xaxis: {
                            label: 'Datum',
                            renderer: $.jqplot.DateAxisRenderer,
                            tickOptions: {formatString: '%#d.%#m.%y'},

                            tickInterval: '12 weeks'
                        },
                        yaxis: {label: 'Betrag in CHF', showLabel: true},
                    },

                    legend: {show: false},
                    highlighter: {show: true, formatString: "%s, CHF %d", sizeAdjust: 7.5}

                });


            }

            legendPlace++;
        });

    }

    function getJSON(lineName, serieName, callback)
    {
        $.ajax({//create an ajax request to display.php
            type: "GET",
            url: lineName + "/",
            async: true,
            dataType: "json", //expect html to be returned                
            success: function (response) {
                callback(response, serieName);
            },
            error: "Fehler aufgetreten beim Lesen"

        });
    }

});