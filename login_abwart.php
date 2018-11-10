<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    
    <body>
        <?php
        include 'sessionHandling.php';
        $sh = sessionHandling::Instance();
        $sh->open_session(); //vorhandene session übernehmen
        $sh->isCorrectPape("abwart");
        
            echo "Hallo Abwart. Sie haben vollen Zugriff auf die Daten! <br/>";
            echo "Ihre Session-ID: ".session_id();
            echo "<br/><a href='index.php'>Logout </a>";
            
             echo "<a href=\"register.php\"> Verwalte Personen</a>";
            echo "<a href=\"rechnung.php\"> Verwalte Rechnungen</a>";
        ?>
    </body>
</html>