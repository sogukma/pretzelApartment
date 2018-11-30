<?php
/**
 * deleteUnser.php
 *
 * Nimmt Löschanferoderungen für Benutzer entgegen und 
 * ruft in der Datenbank die entsprechende Funktion auf.
 *
 * @category   Controller
 * @author     Halil
 */
        include '../sessionHandling.php';
        include '.././DAO.php';
        $sh = sessionHandling::Instance();
        $sh->open_session(); //vorhandene session übernehmen
        $sh->regenerate_session_id();
        $sh->isCorrectPape("abwart");
        
        $dbc = DAO::Instance();
        $dbc->connect();

if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];
    $dbc->delete($userId);
}

 header("Location:manageUsers.php");