<?php
     include 'sessionHandling.php';
    include './DAO.php';
        $sh = sessionHandling::Instance();
        $sh->open_session(); //vorhandene session übernehmen
        $sh->isCorrectPape("abwart");
        
        $dbc = DAO::Instance();
        $dbc->connect();
        $_SESSION['dbconnection'] = $dbc;

if (isset($_POST['action'])) {
    $id = $_POST['action'];
    $_SESSION['dbconnection']->delete($id);
}

 header("Location:updateUsers.php");