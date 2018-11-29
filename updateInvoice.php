<?php
 
     include 'sessionHandling.php';
    include './DAO.php';
    $sh = sessionHandling::Instance();
        $sh->open_session(); //vorhandene session übernehmen
        $sh->regenerate_session_id();
        $sh->isCorrectPape("abwart");
        
        $dbc = DAO::Instance();
        $dbc->connect();
        $_SESSION['dbconnection'] = $dbc;

if (isset($_GET['invoice_id'])) {
  
    $_SESSION['invoice_id'] = $_GET['invoice_id'];
    $_SESSION['fk_user_id'] = $_GET['fk_user_id'];
}
else
{
    echo "geht nicht";
}


    
    function updateInvoice(){
        
            $status = $_POST["status"];
            
             echo $status."".$_SESSION['invoice_id']."".$_SESSION['fk_user_id'];
             $dbc = DAO::Instance();
              $dbc->updateInvoice($_SESSION['invoice_id'],$status, $_SESSION['fk_user_id']);
            
            header("Location:manageUsers.php");
    };
            
   if(isset($_POST['submit']))
        {
           updateInvoice();
        } 

?>
<html>
    <head>
        
       <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    
        <!------ Include the above in your HEAD tag ---------->


        <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>       
          <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="Header-Picture.css">
        <link rel="stylesheet" href="style.css">
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
            <div class="insertForm rounded container">
                <h3>Rechnungsstatus ändern</h3>
    <form method="post" action="updateInvoice.php">
        
              <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="rechnungstyp">
              <option value="geschlossen" checked>Geschlossen</option>
              <option value="offen">Offen</option>
            </select>
          </div>
        
          <input name="submit" class="btn btn-primary" type="submit"><input class="btn" type="reset"><br/>
    </form></body>
</html></div>