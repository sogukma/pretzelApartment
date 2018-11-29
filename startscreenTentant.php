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
        $sh->isCorrectPape("mieter");
        
            echo "Hallo Mieter. Wir arbeiten gerade an einer Website für Sie. Bitte um Geduld!<br/>";
            echo "<br/><a href='index.php'>Logout</a>";
       
        ?>
    </body>
</html>