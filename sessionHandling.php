<?php

/**
 * sessionHandling.php
 *
 * Objektklasse zum Aufrufen von sicherheitsrelevanten Sessionelementen.
 * Nicht zu verwechseln mit sessionHandler von PHP.
 * 
 * @category   Model
 * @author     Malik
 */
class sessionHandling {

    public static function Instance() {
        static $inst = null;
        if ($inst === null) {
            $inst = new sessionHandling();
        }
        return $inst;
    }

    function __construct() {
        
    }

    public function regenerate_session_id() {
        session_regenerate_id();
    }

    public function open_session() {
        session_start();
        $_SESSION['is_open'] = TRUE;
    }

    function close_session() {
        session_write_close();
        $_SESSION['is_open'] = FALSE;
    }

    function destroy_session() {
        session_destroy();
        $_SESSION['is_open'] = FALSE;
    }

    function session_is_open() {
        return($_SESSION['is_open']);
    }

    function isCorrectPape($usertype) {
        if ($_SESSION['eingeloggt'] == true && $usertype == $_SESSION['benutzertyp']) {
            
        } else {
            echo   " <script>
      window.location.href = 'index.php';
    </script>";
            //header("Location:index.php"); //wenn auf c direkt zugregriffen wird, wird direkt auf login verleitet
        }
    }

}

/*
 * https://stackoverflow.com/questions/3788369/how-to-tell-if-a-session-is-active
 */
?>

