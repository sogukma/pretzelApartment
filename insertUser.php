<?php

    function insertUser()
    {
        include 'sessionHandling.php';
        include './DAO.php';
        $sh = sessionHandling::Instance();
        $sh->open_session(); //vorhandene session übernehmen
        $sh->regenerate_session_id();
        $sh->isCorrectPape("abwart");

        $dbc = DAO::Instance();
        $dbc->connect();

        $name = $_POST["nname"];
        $password = $_POST["password"];
        $benutzertyp = $_POST["benutzertyp"];
        $dbc->insert($name, $password, $benutzertyp);
        header("Location:manageUsers.php"); 
    }

    if(isset($_POST['submit']))
    {
       insertUser();
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="style.css"> 
              <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    
        <!------ Include the above in your HEAD tag ---------->


        <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>       
          <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="Header-Picture.css">
    </head>

    <body>
         <nav class="navbar navbar-default" id="navigation-purple">
        <div class="container">
            <a href="#"><img class="img-responsive img-circle avatar" src="pictures/pretzelIcon.png" alt="Avatar"></a>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
     
     <div class="container center_div">
   
     <div class="insertForm rounded">
    <h4>Benutzer hinzufügen</h4>
    
    <form method="post">
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
    
        <input class="btn btn-primary" name="submit" type="submit">
        <input class="btn" type="reset"><br/>
               
    </form>
    
     </div></div>


    </body>

</html>