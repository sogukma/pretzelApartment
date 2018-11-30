<?php

/**
 * DAO.php
 *
 * Objektklasse für Datenbankzugriffe
 *
 * @category   Model
 * @author     Malik
 */
class DAO {

    private $link;
    private $benutzer;
    private $passwort;
    private $dbname;

    public static function Instance() {
        static $inst = null;
        if ($inst === null) {
            $inst = new DAO();
        }
        return $inst;
    }

    function __construct() {
        $this->benutzer = "b46bd03f9f4fdf";
        $this->passwort = "cb61f804";
        $this->dbname = "heroku_264d8c0ac2b1d8d";
    }

    function connect() {

        $this->link = mysqli_connect("eu-cdbr-west-02.cleardb.net", $this->benutzer, $this->passwort, $this->dbname);
        mysqli_query($this->link, "SET NAMES 'utf-8'");
    }

    function delete($id) {
        $abfrage = "delete from users where user_id='$id'";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "<script type='text/javascript'>alert('Fehler: Benutzer hat noch Rechnungen!')</script>";
        }
    }

    function deleteInvoice($id) {
        $abfrage = "delete from rechnung where id='$id'";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error: ";
        }
    }

    function update($id, $username, $password, $benutzertyp, $nachname, $vorname, $strassennummer) {
        $abfrage = "update users set user_name = '$username', user_password = '$password', user_typ = '$benutzertyp', user_surname = '$nachname', user_firstname = '$vorname', user_streetnumber = '$strassennummer' where user_id='$id'";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error: ";
        }
    }

    function updateInvoice($id, $status, $fkid) {
        //wenn eine geschlossene Rechnung wiedergeöffnet wird, wird der "geschlossen_am" Wert gelöscht
        if ($status == "offen") {
            $abfrage = "update rechnung set status = '$status', geschlossen_am = null where fk_userId='$fkid' and id='$id'";
        }
        //wenn eine Rechnung geschlossen wird, wird der Wert "geschlossen_am" gesetzt mit dem jetzigen Datum.
        if ($status == "geschlossen") {
            $abfrage = "update rechnung set status = '$status', geschlossen_am = CURDATE() where fk_userId='$fkid' and id='$id'";
        }

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
            echo "<popup>Änderung erfogreich vorgenommen</popup>";
        } else {
            echo "Error: ";
        }
    }

    public function getLink() {
        return $this->link;
    }

    function disconnect() {
        mysqli_close($this->link);
    }

    function insert($username, $password, $benutzertyp, $nachname, $vorname, $strassennummer) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (user_name, user_password, user_typ, user_surname, user_firstname, user_streetnumber)
    VALUES ('$username', '$password', '$benutzertyp', '$nachname', '$vorname', '$strassennummer')";

        if (mysqli_query($this->link, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    //wenn eine Rechnung erstellt wird wird, wird der Wert "geöffnet_am" gesetzt mit dem jetzigen Datum.
    function insertInvoice($userId, $rechnungstyp, $status, $betrag) {
        $sql = "INSERT INTO rechnung (rechnungstyp, status, betrag, fk_userId, gestellt_am)

        VALUES ('$rechnungstyp', '$status', '$betrag', '$userId', CURDATE())";

        if (mysqli_query($this->link, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    function selectUsers() {
        $abfrage = "select * from users";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    function selectUsersNameById($userId) {
        $abfrage = "select user_name from users where user_id = '$userId'";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    function selectInvoicesFromUserById($userId) {
        $abfrage = "select * from rechnung where fk_userId = '$userId'";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    function selectInvoices() {
        $abfrage = "select * from rechnung";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    function selectUsersColumnNames() {

        $abfrage = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'heroku_264d8c0ac2b1d8d' AND TABLE_NAME = 'users'";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    function selectInvoicesColumnNames() {

        $abfrage = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'heroku_264d8c0ac2b1d8d' AND TABLE_NAME = 'rechnung'";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    function iterateResult($ergebnis) {
        return mysqli_fetch_array($ergebnis);
    }

}
