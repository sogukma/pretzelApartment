
        <?php
        include './sessionHandling.php';
        $sh = sessionHandling::Instance();
        $sh->open_session();
        //session_start() übernimmt eine bestehende session
        
        $sh->destroy_session(); //löschen aller session variablen
        session_unset();
        
        
           if (ini_get("session.use_cookies")) 
        {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"],
            $params["domain"], $params["secure"], $params["httponly"]);
        }
        ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login-Fenster</title>
    </head>
    <body>
        <h3>Bitte melden Sie sich an: </h3>
        <form action="login_b.php" method="POST">
            <input type="text" name="benutzername" size="30" />Benutzername<br/>
            <input type="password" name="kennwort" size="30" />Passwort<br/>
            <input type="submit" value="einloggen" /><br/>
            <input type="reset" value="nochmals" /><br/>
           
        </form>
        <br/>
        
    </body>
</html>

