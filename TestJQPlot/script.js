$(document).ready(function () {
    $.jqplot.config.enablePlugins = true;

    var lineURL = ["daoOpenInvoices.php","daoClosedInvoices.php"];
    var lines = [];
    var remaining = lineURL.length;
    for(i=0; i < lineURL.length;i++)
    {
        getJSON(lineURL[i], function(response){
           lines.push(response);
           --remaining;
           if(remaining == 0)
           {
                 var plot2 = $.jqplot('chart1', lines, {
        title: 'Rechnungsübersicht',
        show: true,
        axes: {
            xaxis: {
                label: 'Datum',
                renderer: $.jqplot.DateAxisRenderer,
                tickOptions: {formatString: '%#d.%#m.%y'},
                min: 'November 30, 2017 00:20PM',
                max: 'November 30, 2018 00:20PM',
                tickInterval: '4 weeks'
            },
            yaxis: {label: 'Betrag in CHF', showLabel: true},
        },

        legend: {show: true},
        highlighter: {show: true, formatString: "%s, CHF %d", sizeAdjust: 7.5},
        series: [
            {lineWidth: 4, label: 'offene Rechnungen', showLabel: true},
            {lineWidth: 4, label: 'geschlossene Rechnungen', showLabel: true},
        ]
    });
    
    
           }
            
            
        });
    }
    
    function getJSON(lineName, callback)
    {
        $.ajax({//create an ajax request to display.php
        type: "GET",
        url: lineName,
        async: true,
        dataType: "json", //expect html to be returned                
        success: function (response) {
            callback(response);
        },
        error: "Fehler aufgetreten beim Lesen"

    });
    }
/*    
    var line1;
    $.ajax({//create an ajax request to display.php
        type: "POST",
        url: "daoOpenInvoices.php",
        async: false,
        dataType: "json", //expect html to be returned                
        success: function (response) {
            console.log(response);
            line1 = response;
        }

    });

    var line2 =
            $.ajax({//create an ajax request to display.php
                type: "POST",
                url: "daoClosedInvoices.php",
                async: false,
                dataType: "json", //expect html to be returned                
                success: function (response) {
                    console.log(response);
                    line2 = response;
                }

            });

  */

});