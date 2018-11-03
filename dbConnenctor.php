<?php

class dbConnector
{
 private $link;
 private $benutzer; //später in ein db.inc.php
 private $passwort;
 private $dbname;
 
 function __construct() {
    $this->benutzer="root";
    $this->passwort="";
    $this->dbname="login";
 }
function connect() {
    $this->link = mysqli_connect("localhost", $this->benutzer, $this->passwort, $this->dbname);
    mysqli_query($this->link, "SET NAMES 'utf-8'");
    
    
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

    
    
}}

/* quelle https://stackoverflow.com/questions/4478661/getter-and-setter */