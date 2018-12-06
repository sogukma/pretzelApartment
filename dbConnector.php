<?php

/**
 * Description of dbConnector
 *
 * Gibt DAO-Instanz zurück und stellt Datenbankverbindung her
 * 
 * @author Malik
 */
include 'DAO.php';


    $dbc = DAO::Instance();
    $dbc->connect();

