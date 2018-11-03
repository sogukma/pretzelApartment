<?php
        include 'sessionHandler.php';
        sessionHandler.open_session(); //vorhandene session übernehmen
        SessionHandler.isCorrectPape("abwart");
?>
<html>
    <head></head>
    <body>
    <form method="post" action="register.php">
        Name:<input name="nname" type="text" required/><br/>
        Password:<input name="password" type="password" required=""/><br/>
        Benutzername:
          <input type="radio" name="benutzertyp" value="mieter" checked> Mieter
          <input type="radio" name="benutzertyp" value="abwart"> Abwart<br/>
          <input name="submit" type="submit"><input type="reset"><br/>
    </form>
        <?php
        include './dbConnenctor.php';
        function register()
        {
            $name = $_POST["nname"];
            $password = $_POST["password"];
            $benutzertyp = $_POST["benutzertyp"];
            $dbc = new dbConnector();
            $dbc->connect();
            $dbc->insert($name, $password, $benutzertyp);
            if(isset($_POST['submit']))
            {
               echo "hello ".$_POST["benutzertyp"];
            } 
        }
        
        if(isset($_POST['submit']))
        {
           register();
        } 
        ?>
    </body>
</html>

