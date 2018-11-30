<?php
/**
 * updateUser.php
 *
 * Stellt ein Formular für das Ändern eines Benutzers zur Verfügung.
 * Beim Absenden des Formular wird in der Datenbank die entsprechende Funktion aufgerufen.
 *
 * @category   Controller, View
 * @author     Halil
 */
        include '../sessionHandling.php';
        include '.././DAO.php';
        $sh = sessionHandling::Instance();
        $sh->open_session(); //vorhandene session übernehmen
        $sh->regenerate_session_id();
        $sh->isCorrectPape("abwart");
        
        $dbc = DAO::Instance();
        $dbc->connect();
        $_SESSION['dbconnection'] = $dbc;
        

if (isset($_GET['user_id'])) {
  
    $_SESSION['user_id'] = $_GET['user_id'];
}
else
{
    echo "geht nicht";
}


    
    function update(){
        
            $name = $_POST["nname"];
            $password = $_POST["password"];
            $password = password_hash($password, PASSWORD_DEFAULT);
            $benutzertyp = $_POST["benutzertyp"];
            $_SESSION['dbconnection']->update($_SESSION['user_id'],$name, $password, $benutzertyp);
             header("Location:manageUsers.php");
    };
            
   if(isset($_POST['submit']))
        {
           update();
        } 

?>
<html>
    <head>
               <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    
        <!------ Include the above in your HEAD tag ---------->


        <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>       
          <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../Header-Picture.css">
        <link rel="stylesheet" href="../style.css">


    </head>
    <body>
 <!-- Der Nav-Bar wurde von hier entnommen: https://demo.tutorialzine.com/2016/09/freebie-5-beautiful-bootstrap-headers/#Header-Picture-->
          <nav class="navbar navbar-default" id="navigation-purple">
        <div class="container">
            <a href="#"><img class="img-responsive img-circle avatar" src="../pictures/pretzelIcon.png" alt="Avatar"></a>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="../index.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
      
            <div class="insertForm rounded container">
                  <h3>Benutzerangeben ändern</h3>
            <form method="post" action="updateUser.php">
                        <div class="form-group row"> 
            <label for="nname" class="col-sm-10 col-form-label">Name</label>
            <div class="col-sm-10">
                 <input class="form-control" id="nname" name="nname" type="text" required="true"/><br/>
             </div>
        </div>
         <div class="form-group row"> 
            <label for="password" class="col-sm-10 col-form-label">Password</label>
            <div class="col-sm-10">
                 <input class="form-control" id="password" name="password" type="password" required="true"/><br/>
             </div>
        </div> 
          <div class="form-group">
            <label for="benutzertyp">Benutzertyp</label>
            <select class="form-control" name="benutzertyp" id="benutzertyp">
              <option checked value="mieter">Mieter</option>
              <option value="abwart">Abwart</option>

            </select>
        </div> 

              <input name="submit" class="btn btn-primary" type="submit"><input class="btn" type="reset"><br/>
        </form>
    </div>
        
    </body>
</html>