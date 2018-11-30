
        <?php
        /**
        * index.php
        *
        * Startseite: hier gibt der Benutzer Name und Passwort ein 
        * und bestätigt seine eingeben mit Klick auf den "Sign-In"-Button.
        *
        * @category   View
        * @author     Malik (code), Halil (design)
        */
        include './sessionHandling.php';
        $sh = sessionHandling::Instance();
        $sh->open_session();
        $sh->regenerate_session_id();
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
        
        <link rel="stylesheet" href="loginStyle.css">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
    </head>
    <body>
     
        
        
  
<!-- das Design des Login-Fensters wurde von dieser Seite übernommen: https://bootsnipp.com/snippets/featured/password-strength-meter-->
<div class="container">
  
  <div class="row" id="pwd-container">
    <div class="col-md-4"></div>
    
    <div class="col-md-4">
      <section class="login-form">
        <form action="login.php" method="POST">
            <img src="pictures/pretzelIcon.png" class="img-responsive" alt="" />
          <input type="text" name="benutzername" placeholder="Benutzername" required class="form-control input-lg" />
          <input type="password" class="form-control input-lg" name="kennwort"  placeholder="Password" required="" />
         
          
   
          
          <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Sign in</button>

          
        </form>
        
        <div class="form-links">
      
        </div>
      </section>  
      </div>
      
      <div class="col-md-4"></div>
      

  </div>
  

  
  
</div>
        
        
    </body>
</html>

