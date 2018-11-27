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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  
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