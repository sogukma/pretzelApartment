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
        $sh->regenerate_session_id();
        $sh->isCorrectPape("abwart");
        
            echo "Hallo Abwart. Sie haben vollen Zugriff auf die Daten! <br/>";
            echo "Ihre Session-ID: ".session_id();
            echo "<br/><a href='index.php'>Logout </a>";
            echo "<br/>";
            echo "<a href=\"manageUsers.php\"> Verwalte Personen</a>";
         
        ?>
    </body>
</html>