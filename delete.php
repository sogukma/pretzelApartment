<?php
     include 'sessionHandling.php';
    include './dbConnenctor.php';
        $sh = sessionHandling::Instance();
        $sh->open_session(); //vorhandene session übernehmen
        $sh->isCorrectPape("abwart");
        
        $dbc = dbConnector::Instance();
        $dbc->connect();
        $_SESSION['dbconnection'] = $dbc;

if (isset($_POST['action'])) {
    $id = $_POST['action'];
    $_SESSION['dbconnection']->delete($id);
}

 header("Location:register.php");