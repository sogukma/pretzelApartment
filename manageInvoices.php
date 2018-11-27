<?php
      
        
        include 'sessionHandling.php';
        include './DAO.php';
        include './TemplateView.php';
        $sh = sessionHandling::Instance();
        $sh->open_session(); //vorhandene session übernehmen
        $sh->regenerate_session_id();
        $sh->isCorrectPape("abwart");
        
        $dbc = DAO::Instance();
        $dbc->connect();
        $_SESSION['dbconnection'] = $dbc;
        $_SESSION['user_id'] = $_GET['user_id'];
            

        ?>

<html>
    <head>
        <script src="assets/js/jquery.min.js"></script>
     <!--   <script src="assets/bootstrap/js/bootstrap.min.js"></script> -->
    <!--    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> -->

    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        <script type='text/javascript'>
         $(document).ready(function(){
   
          $('.updateInvoice').click(function() {
              
              var invoiceId = $(this).parent().parent().attr('id');
              var fkUserId = $(this).parent().parent().find(".fkUserId").html();
              window.open("updateInvoice.php?invoice_id="+ encodeURIComponent(invoiceId)+"&fk_user_id="+encodeURIComponent(fkUserId));
              

            });
            
                
                
            });
        </script>
    </head>
    <body>
       <div class="content">

        <?php
          $ergebnis = $_SESSION['dbconnection']->selectUsersNameById( $_SESSION['user_id'] );

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
                     $ergebnis = $_SESSION['dbconnection']->selectInvoicesFromUserById($_SESSION['user_id']);
                
                     while($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis))
                     {        
                     
                      echo '<tr id="'.TemplateView::noHTML($zeile[0]).'"><th scope="row">'. TemplateView::noHTML($zeile[0]).'</t><td>'.TemplateView::noHTML($zeile[1]) .'</td><td>'.TemplateView::noHTML($zeile[2]) .'</td><td>'.TemplateView::noHTML($zeile[3]) .'</td><td id="fk'.$zeile[4].'" class="fkUserId">'.TemplateView::noHTML($zeile[4]) .'</td><td><button class="updateInvoice">update</button></td></tr>';
                     
                     }
                ?>
         
        </table>
            </div>
           <br/>
            <form action="pdferstellen.php?fk_user_id=<?=$_GET['user_id']?>" method="post">
            <input class="btn" type="submit" value="Rechnung als PDF anzeigen">
            
        </form>
 
           
        <form action="insertInvoice.php?fk_user_id=<?=$_GET['user_id']?>" method="post">
            <input class="btn" type="submit" value="Rechnung hinzufügen" />
        </form>

    
        
       

       </div>
    </body>
</html>

