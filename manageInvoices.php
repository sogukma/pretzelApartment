<?php
      
        
        include 'sessionHandling.php';
        include './DAO.php';
        include './TemplateView.php';
        $sh = sessionHandling::Instance();
        $sh->open_session(); //vorhandene session übernehmen
        $sh->isCorrectPape("abwart");
        
        $dbc = DAO::Instance();
        $dbc->connect();
        $_SESSION['dbconnection'] = $dbc;
        $_SESSION['id'] = $_GET['id'];
            
?>
<html>
    <head>
        <script src="assets/js/jquery.min.js"></script>
     <!--   <script src="assets/bootstrap/js/bootstrap.min.js"></script> -->
    <!--    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        <script type='text/javascript'>
         $(document).ready(function(){
   
          $('.updateInvoice').click(function() {
              
               var data = $(this).parent().parent().attr('id');
               var fkUserId = $(this).parent().parent().find(".fkUserId").html();
               console.log(fkUserId);
                var thisform = $(this);
                $.ajax({
                 type: "POST",
                 url: "updateInvoice.php",
                 data: { action2: data, action3: fkUserId },               
                success: function(msg) { 
                      thisform.parent().append(msg);
                      //alert(msg);

                        }
             
                });
            });
            
                
                
            });
        </script>
    </head>
    <body>
       

        <?php
          $ergebnis = $_SESSION['dbconnection']->selectUsersNameById( $_SESSION['id'] );

          while($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis))
          {
             echo '<h3 value="'.TemplateView::noHTML($zeile[0]).'">Rechnungen von '.TemplateView::noHTML($zeile[0]).'</h3>';
          }
        ?>
         
        <div>
        <table class="table table-striped">
            
                <?php 
                    $ergebnis = $_SESSION['dbconnection']->selectInvoicesColumnNames();
                    
                    echo '<thead class="thead-dark"><tr>';
                       while($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis))
                     {        
                        echo '<th scope="col">'.  TemplateView::noHTML($zeile[0]).'</th>';
                     }
                    echo '</tr><thead>';
                     $ergebnis = $_SESSION['dbconnection']->selectInvoicesFromUserById($_SESSION['id']);
                
                     while($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis))
                     {        
                     
                      echo '<tr id="'.TemplateView::noHTML($zeile[0]).'"><th scope="row">'. TemplateView::noHTML($zeile[0]).'</t><td>'.TemplateView::noHTML($zeile[1]) .'</td><td>'.TemplateView::noHTML($zeile[2]) .'</td><td>'.TemplateView::noHTML($zeile[3]) .'</td><td id="fk'.$zeile[4].'" class="fkUserId">'.TemplateView::noHTML($zeile[4]) .'</td><td><button class="updateInvoice">update</button></td></tr>';
                     
                     }
                ?>
         
        </table>
            </div>
        <div >
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
              <option>Öl</option>s
              <option>Abwartleistung</option>
            </select>
          </div>
        
          <input name="submit" class="btn btn-primary" type="submit">
          <input class="btn" type="reset"><br/>
    </form>
        <?php echo $_GET['id']; 
        ?>
        <form action="pdferstellen.php?id=<?=$_GET['id']?>" method="get">
            <input class="btn" type="submit" value="PDF">
            
        </form>
        
        </div>
       
        
        
        <?php
      
        function insertInvoice()
        {
 
            $userId = $_GET['id'];
            echo 'not persistence here:'.$userId;
            $rechnungstyp = $_POST["rechnungstyp"];
            $betrag = $_POST["betrag"];
            $_SESSION['dbconnection']->insertInvoice($userId, $rechnungstyp, "offen", $betrag);
        }
        
        if(isset($_POST['submit']))
        {
           insertInvoice();
        } 
        ?>
        

    </body>
</html>

