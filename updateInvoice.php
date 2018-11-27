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
    <form method="post" action="updateInvoice.php">
        Status:
          <input type="radio" name="status" value="offen" checked> offen<br/>
          <input type="radio" name="status" value="geschlossen"> geschlossen<br/>
          <input name="submit" type="submit"><input type="reset"><br/>
    </form>
