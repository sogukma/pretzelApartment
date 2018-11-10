<?php
      
        
        include 'sessionHandler.php';
        include './dbConnenctor.php';
        include './TemplateView.php';
        sessionHandler.open_session(); //vorhandene session übernehmen
        SessionHandler.isCorrectPape("abwart");
        
        $dbc = dbConnector::Instance();
        $dbc->connect();
        $_SESSION['dbconnection'] = $dbc;
            
?>
<html>
    <head>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
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
   
    <form method="post" action="rechnung.php">
        Benutzer:
        <select name="user">
        <?php
          $ergebnis = $_SESSION['dbconnection']->selectUsers();
                
            while($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis))
            {        

             echo '<option value="'.TemplateView::noHTML($zeile[0]).'">'.TemplateView::noHTML($zeile[1]).'</option>';
            }
        
        ?>
        </select>
        Betrag:<input name="betrag" type="text" required=""/><br/>
        Rechnungstyp:
          <input type="radio" name="rechnungstyp" value="heizung" checked> Heizung<br/>
          <input type="radio" name="rechnungstyp" value="miete"> Miete<br/>
          <input name="submit" type="submit"><input type="reset"><br/>
    </form>
        <table>
            
                <?php 
                    $ergebnis = $_SESSION['dbconnection']->selectInvoicesColumnNames();
                    echo '<tr>';
                       while($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis))
                     {        
                        echo '<th>'.  TemplateView::noHTML($zeile[0]).'</th>';
                     }
                    echo '</tr>';
                     $ergebnis = $_SESSION['dbconnection']->selectInvoices();
                
                     while($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis))
                     {        
                     
                      echo '<tr id="'.TemplateView::noHTML($zeile[0]).'"><td>'. TemplateView::noHTML($zeile[0]).'</td><td>'.TemplateView::noHTML($zeile[1]) .'</td><td>'.TemplateView::noHTML($zeile[2]) .'</td><td>'.TemplateView::noHTML($zeile[3]) .'</td><td id="fk'.$zeile[4].'" class="fkUserId">'.TemplateView::noHTML($zeile[4]) .'</td><td><button class="updateInvoice">update</button></td></tr>';
                     
                     }
                ?>
         
        </table>
        
        <?php
      
        function rechnung()
        {
 
            $userId = $_POST["user"];
            $rechnungstyp = $_POST["rechnungstyp"];
            $betrag = $_POST["betrag"];
            $_SESSION['dbconnection']->insertInvoice($userId, $rechnungstyp, "offen", $betrag);
        }
        
        if(isset($_POST['submit']))
        {
           rechnung();
        } 
        ?>
        

    </body>
</html>

