<?php

class DAO
{
 private $link;
 private $benutzer; //später in ein db.inc.php
 private $passwort;
 private $dbname;
 
   public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new DAO();
        }
        return $inst;
    }

 
 
 function __construct() {
    $this->benutzer="root";
    $this->passwort="";
    $this->dbname="login";
 }
function connect() {

    $this->link = mysqli_connect("localhost", $this->benutzer, $this->passwort, $this->dbname);
    mysqli_query($this->link, "SET NAMES 'utf-8'");
    
    
    
}

function delete($id){
       $abfrage="delete from users where user_id='$id'";
    
     if (mysqli_query($this->link, $abfrage)) {
        return mysqli_query($this->link, $abfrage);
    } else {
        echo "Error: ";
    }
}

function update($id,$name, $password, $benutzertyp){
       $abfrage="update users set user_name = '$name', user_password = '$password', user_typ = '$benutzertyp' where user_id='$id'";

     if (mysqli_query($this->link, $abfrage)) {
        return mysqli_query($this->link, $abfrage);
    } else {
        echo "Error: ";
    }
}



function updateInvoice($id, $status, $fkid){
        echo "persistence: ". $id." ".$status." ".$fkid;
       $abfrage="update rechnung set status = '$status' where fk_userId='$fkid' and id='$id'";
       
     if (mysqli_query($this->link, $abfrage)) {
        return mysqli_query($this->link, $abfrage);
        echo "<popup>Änderung erfogreich vorgenommen</popup>";
    } else {
        echo "Error: ";
    }
}


public function getLink()
{
        return $this->link;
  
}


function disconnect()
{
      mysqli_close($this->link);
}



function insert($name, $password, $benutzertyp)
{
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (user_name, user_password, user_typ)
    VALUES ('$name', '$password', '$benutzertyp')";

    if (mysqli_query($this->link, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
}

function insertInvoice($userId, $rechnungstyp, $status, $betrag)
{
    echo "persistence here: ".$userId;
    $sql = "INSERT INTO rechnung (rechnungstyp, status, betrag, fk_userId)
    VALUES ('$rechnungstyp', '$status', '$betrag', '$userId')";

    if (mysqli_query($this->link, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
}

function selectUsers(){
    $abfrage="select * from users";
    
     if (mysqli_query($this->link, $abfrage)) {
        return mysqli_query($this->link, $abfrage);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

       
}

function selectUsersNameById($userId){
    $abfrage="select user_name from users where user_id = '$userId'";
    
     if (mysqli_query($this->link, $abfrage)) {
        return mysqli_query($this->link, $abfrage);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

       
}

function selectInvoicesFromUserById($userId){
    $abfrage="select * from rechnung where fk_userId = '$userId'";
    
     if (mysqli_query($this->link, $abfrage)) {
        return mysqli_query($this->link, $abfrage);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    
    
}


function selectInvoices(){
    $abfrage="select * from rechnung";
    
     if (mysqli_query($this->link, $abfrage)) {
        return mysqli_query($this->link, $abfrage);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    
    
}


function selectUsersColumnNames()
{

        $abfrage="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'login' AND TABLE_NAME = 'users'";
    
     if (mysqli_query($this->link, $abfrage)) {
        return mysqli_query($this->link, $abfrage);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
   
}

function selectInvoicesColumnNames()
{

        $abfrage="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'login' AND TABLE_NAME = 'rechnung'";
    
     if (mysqli_query($this->link, $abfrage)) {
        return mysqli_query($this->link, $abfrage);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
   
}


function iterateResult($ergebnis)
{
    return mysqli_fetch_array($ergebnis);
}

    }
    


/* quelle https://stackoverflow.com/questions/4478661/getter-and-setter */