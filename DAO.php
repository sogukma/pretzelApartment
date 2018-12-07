<?php

/**
 * DAO.php
 *
 * Objektklasse für Datenbankzugriffe
 *
 * Mit mysqli_real_escape_string werden SQL-Injections verhindert
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
        $idSave = mysqli_real_escape_string($this->link, $id);
        $abfrage = "delete from users where user_id='$idSave'";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error" . mysqli_error($this->getLink());
        }
    }

    function deleteInvoice($id) {
        $idSave = mysqli_real_escape_string($this->link, $id);
        $abfrage = "delete from rechnung where id='$idSave'";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error" . mysqli_error($this->getLink());
        }
    }

    function update($id, $username, $password, $benutzertyp, $nachname, $vorname, $strassennummer) {
        $idSave = mysqli_real_escape_string($this->link, $id);
        $usernameSave = mysqli_real_escape_string($this->link, $username);
        $passwordSave = mysqli_real_escape_string($this->link, $password);
        $benutzertypSave = mysqli_real_escape_string($this->link, $benutzertyp);
        $nachnameSave = mysqli_real_escape_string($this->link, $nachname);
        $vornameSave = mysqli_real_escape_string($this->link, $vorname);
        $strassennummerSave = mysqli_real_escape_string($this->link, $strassennummer);



        $abfrage = "update users set user_name = '$usernameSave', user_password = '$passwordSave', user_typ = '$benutzertypSave', user_surname = '$nachnameSave', user_firstname = '$vornameSave', user_streetnumber = '$strassennummerSave' where user_id='$idSave'";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error" . mysqli_error($this->getLink());
        }
    }

    function updateInvoice($id, $status, $fkid) {
        $idSave = mysqli_real_escape_string($this->link, $id);
        $statusSave = mysqli_real_escape_string($this->link, $status);
        $fkidSave = mysqli_real_escape_string($this->link, $fkid);
        //wenn eine geschlossene Rechnung wiedergeöffnet wird, wird der "geschlossen_am" Wert gelöscht
        if ($statusSave == "offen") {
            $abfrage = "update rechnung set status = '$statusSave', geschlossen_am = null where fk_userId='$fkidSave' and id='$idSave'";
        }
        //wenn eine Rechnung geschlossen wird, wird der Wert "geschlossen_am" gesetzt mit dem jetzigen Datum.
        if ($statusSave == "geschlossen") {
            $abfrage = "update rechnung set status = '$statusSave', geschlossen_am = CURDATE() where fk_userId='$fkidSave' and id='$idSave'";
        }

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error" . mysqli_error($this->getLink());
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

        $usernameSave = mysqli_real_escape_string($this->link, $username);
        $passwordSave = mysqli_real_escape_string($this->link, $password);
        $benutzertypSave = mysqli_real_escape_string($this->link, $benutzertyp);
        $nachnameSave = mysqli_real_escape_string($this->link, $nachname);
        $vornameSave = mysqli_real_escape_string($this->link, $vorname);
        $strassennummerSave = mysqli_real_escape_string($this->link, $strassennummer);


        $sql = "INSERT INTO users (user_name, user_password, user_typ, user_surname, user_firstname, user_streetnumber)
    VALUES ('$usernameSave', '$passwordSave', '$benutzertypSave', '$nachnameSave', '$vornameSave', '$strassennummerSave')";

        if (mysqli_query($this->link, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error" . mysqli_error($this->getLink());
        }
    }

    //wenn eine Rechnung erstellt wird wird, wird der Wert "geöffnet_am" gesetzt mit dem jetzigen Datum.
    function insertInvoice($userId, $rechnungstyp, $status, $betrag) {
        $userIdSave = mysqli_real_escape_string($this->link, $userId);
        $rechnungstypSave = mysqli_real_escape_string($this->link, $rechnungstyp);
        $statusSave = mysqli_real_escape_string($this->link, $status);
        $betragSave = mysqli_real_escape_string($this->link, $betrag);

        $sql = "INSERT INTO rechnung (rechnungstyp, status, betrag, fk_userId, gestellt_am)

        VALUES ('$rechnungstypSave', '$statusSave', '$betragSave', '$userIdSave', CURDATE())";

        if (mysqli_query($this->link, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error" . mysqli_error($this->getLink());
        }
    }

    function selectUsers() {
        $abfrage = "select * from users";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error" . mysqli_error($this->getLink());
        }
    }

    function selectUsersNameById($userId) {
        $userIdSave = mysqli_real_escape_string($this->link, $userId);
        $abfrage = "select user_name from users where user_id = '$userIdSave'";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error" . mysqli_error($this->getLink());
        }
    }

    function selectInvoicesFromUserById($userId) {
        $userIdSave = mysqli_real_escape_string($this->link, $userId);
        $abfrage = "select * from rechnung where fk_userId = '$userIdSave'";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error" . mysqli_error($this->getLink());
        }
    }

    function selectInvoices() {
        $abfrage = "select * from rechnung";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error" . mysqli_error($this->getLink());
        }
    }

    function selectUsersColumnNames() {

        $abfrage = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'heroku_264d8c0ac2b1d8d' AND TABLE_NAME = 'users'";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error" . mysqli_error($this->getLink());
        }
    }

    function selectInvoicesColumnNames() {

        $abfrage = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'heroku_264d8c0ac2b1d8d' AND TABLE_NAME = 'rechnung'";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error" . mysqli_error($this->getLink());
        }
    }

    function iterateResult($ergebnis) {
        return mysqli_fetch_array($ergebnis);
    }

    function selectOpenInvoices() {
        $abfrage = "SELECT gestellt_am, sum(betrag) FROM rechnung where gestellt_am is not null and status='offen' group by gestellt_am";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error" . mysqli_error($this->getLink());
        }
    }

    function selectSumOfOpenInvoices() {
        $abfrage = "SELECT sum(betrag) FROM rechnung where status = 'offen'";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error" . mysqli_error($this->getLink());
        }
    }

    function selectClosedInvoices() {
        $abfrage = "SELECT geschlossen_am, sum(betrag) FROM rechnung where geschlossen_am is not null group by geschlossen_am";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error" . mysqli_error($this->getLink());
        }
    }

    function selectSumOfClosedInvoices() {
        $abfrage = "SELECT sum(betrag) FROM rechnung where geschlossen_am is not null";

        if (mysqli_query($this->link, $abfrage)) {
            return mysqli_query($this->link, $abfrage);
        } else {
            echo "Error" . mysqli_error($this->getLink());
        }
    }

}
