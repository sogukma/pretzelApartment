<?php

        function insertInvoice()
        {
 
            include 'sessionHandling.php';
            include './DAO.php';
            $sh = sessionHandling::Instance();
            $sh->open_session(); //vorhandene session übernehmen
            $sh->regenerate_session_id();
            $sh->isCorrectPape("abwart");

            $dbc = DAO::Instance();
            $dbc->connect();
        
            $userId = $_GET['fk_user_id'];
            $rechnungstyp = $_POST["rechnungstyp"];
            $betrag = $_POST["betrag"];
            $dbc->insertInvoice($userId, $rechnungstyp, "offen", $betrag);
            header("Location:manageInvoices.php?user_id=".$userId);
        }
        
        if(isset($_POST['submit']))
        {
           insertInvoice();
        } 
?>


<html>
    <head>
         <link rel="stylesheet" href="style.css"> 
  
    </head>
    <body>
    
        
    <div class="insertForm rounded">
        
        <h4>Neue Rechnung hinzufügen:</h4>
        
    <form method="post">
       
        <div class="form-group row"> 
            <label for="betrag" class="col-sm-10 col-form-label">Betrag</label>
            <div class="col-sm-10">
                 <input class="form-control" id="betrag" name="betrag" type="text" required=""/><br/>
             </div>
        </div>
        
        
        
          <div class="form-group">
            <label for="rechnungstyp">Rechnungstyp</label>
            <select class="form-control" name="rechnungstyp" id="rechnungstyp">
              <option>Heizung</option>
              <option>Miete</option>
              <option>Reparatur</option>
              <option>Wasser</option>
              <option>Öl</option>
              <option>Abwartleistung</option>
            </select>
          </div>
        
          <input name="submit" class="btn btn-primary" type="submit">
          <input class="btn" type="reset"><br/>
    </form>
         </div>
</body>
</html>