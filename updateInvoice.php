<?php
 
     include 'sessionHandling.php';
    include './dbConnenctor.php';
    $sh = sessionHandling::Instance();
        $sh->open_session(); //vorhandene session übernehmen
        $sh->isCorrectPape("abwart");
        
        $dbc = dbConnector::Instance();
        $dbc->connect();
        $_SESSION['dbconnection'] = $dbc;

if (isset($_POST['action2'])) {
  
    echo $_POST['action2'];
    echo "das ist fk_userId". $_POST['action3'];
    $_SESSION['user_id_2'] = $_POST['action2'];
    $_SESSION['fk_user_id'] = $_POST['action3'];
}
else
{
    echo "geht nicht";
}


    
    function updateInvoice(){
        
            $status = $_POST["status"];
            
             echo $status."".$_SESSION['user_id_2']."".$_SESSION['fk_user_id'];
             $dbc = dbConnector::Instance();
              $dbc->updateInvoice($_SESSION['user_id_2'],$status, $_SESSION['fk_user_id']);
            
            header("Location:register.php");
    };
            
   if(isset($_POST['submit']))
        {
           updateInvoice();
        } 

?>
    <form method="post" action="updateInvoice.php">
        Status:
          <input type="radio" name="status" value="offen" checked> offen<br/>
          <input type="radio" name="status" value="geschlossen"> geschlossen<br/>
          <input name="submit" type="submit"><input type="reset"><br/>
    </form>
