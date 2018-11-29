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
                <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    
        <!------ Include the above in your HEAD tag ---------->


        <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>       
          <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="Header-Picture.css">
        
        <script type='text/javascript'>
         $(document).ready(function(){
   
          $('.updateInvoice').click(function() {
              
              var invoiceId = $(this).parent().parent().parent().attr('id');
              var fkUserId = $(this).parent().parent().parent().find(".fkUserId").html();
              window.open("updateInvoice.php?invoice_id="+ encodeURIComponent(invoiceId)+"&fk_user_id="+encodeURIComponent(fkUserId));
              

            });
            
                
                
            });
        </script>
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
       <div class="content">

        <?php
          $ergebnis = $_SESSION['dbconnection']->selectUsersNameById( $_SESSION['user_id'] );

          while($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis))
          {
             echo '<h3 value="'.TemplateView::noHTML($zeile[0]).'">Rechnungen von '.TemplateView::noHTML($zeile[0]).'</h3>';
          }
        ?>
         
        <div>
        <div class="container">
	<div class="row">
		
        
        <div class="col-md-12">
        <div class="table-responsive">    
        
        <table class="table table-bordred table-striped">
            
                <?php 
                    $ergebnis = $_SESSION['dbconnection']->selectInvoicesColumnNames();
                    
                    echo '<thead class="thead-dark">';
                       while($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis))
                     {        
                        echo '<th>'.  TemplateView::noHTML($zeile[0]).'</th>';
                     }
                        echo '<th>Status ändern</th>';
                    echo '</thead><tbody>';
                     $ergebnis = $_SESSION['dbconnection']->selectInvoicesFromUserById($_SESSION['user_id']);
                
                     while($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis))
                     {        
                     
                      echo '<tr id="'.TemplateView::noHTML($zeile[0]).'">'
                        . '<th scope="row">'. TemplateView::noHTML($zeile[0]).'</th>'
                        . '<td>'.TemplateView::noHTML($zeile[1]) .'</td>'
                        . '<td>'.TemplateView::noHTML($zeile[2]) .'</td>'
                        . '<td>'.TemplateView::noHTML($zeile[3]) .'</td>'
                        . '<td id="fk'.TemplateView::noHTML($zeile[4]).'" class="fkUserId">'.TemplateView::noHTML($zeile[4]) .'</td>'
                        . '<td><p data-placement="top" data-toggle="tooltip" title="Bearbeiten"><button class="btn btn-primary btn-xs updateInvoice" data-title="Bearbeiten" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>'    
                        . '</tr>';
                     
                     }
                     echo '</tbody>';
                ?>
         
        </table>
        </div></div></div></div>
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

