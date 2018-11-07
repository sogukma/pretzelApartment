<?php
     include 'sessionHandler.php';
    include './dbConnenctor.php';
        sessionHandler.open_session(); //vorhandene session übernehmen
        SessionHandler.isCorrectPape("abwart");
        
        $dbc = new dbConnector();
        $dbc->connect();
        $_SESSION['dbconnection'] = $dbc;

if (isset($_POST['action'])) {
    $id = $_POST['action'];
    $_SESSION['dbconnection']->delete($id);
}

 header("Location:register.php");