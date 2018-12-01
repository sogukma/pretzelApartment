$(document).ready(function () {
    $.jqplot.config.enablePlugins = true;

    var lineURL = ["daoOpenInvoices.php", "daoClosedInvoices.php"];
    var lines = [];
    var serieNames = ["offene Rechnungen", "geschlossene Rechnungen"];
    var seriess = [];
    var remaining = lineURL.length;
    for (i = 0; i < lineURL.length; i++)
    {
        var legendPlace = 1;
        
        getJSON(lineURL[i], serieNames[i], function (response, serieName) {

            lines.push(response);
            seriess.push('{"lineWidth": 4, "label": "' + serieName + '", "showLabel": true}');

         //   $("#plotLegend ul")[i].append(serieName);
         console.log(serieName+"<br/>");
         console.log(legendPlace);
         console.log($("#plotLegend li:nth-child("+legendPlace+")"));
            $("#plotLegend li:nth-child("+legendPlace+")").append(serieName);
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
            url: lineName,
            async: true,
            dataType: "json", //expect html to be returned                
            success: function (response) {
                callback(response, serieName);
            },
            error: "Fehler aufgetreten beim Lesen"

        });
    }

});