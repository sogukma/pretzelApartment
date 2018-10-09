<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    
    <body>
        <?php
        include 'sessionHandler.php';
        sessionHandler.open_session(); //vorhandene session übernehmen
        SessionHandler.isCorrectPape("abwart");
        
            echo "Hallo Abwart. Sie haben vollen Zugriff auf die Daten! <br/>";
            echo "Ihre Session-ID: ".session_id();
            echo "<br/><a href='index.php'>Logout </a>";
       
        ?>
    </body>
</html>