<?php
include 'sessionHandler.php';
// vorhandene session übernehmen
@sessionHandler.open_session();

if(!@sessionHandler.session_is_open())
{
$eingeloggt = false;
}
if(isset($_POST['benutzername']) AND isset($_POST['kennwort']))
{
    //prüfen ob login ok oder nicht
    // if($_POST['benutzername'] == "martin" AND $_POST['kennwort'] == "1234")
    
    $benutzer="root"; //später in ein db.inc.php
    $passwort="";
    $dbname="login";
    $link = mysqli_connect("localhost", $benutzer, $passwort, $dbname);
    mysqli_query($link, "SET NAMES 'utf-8'");
    $abfrage="select * from users";
    $ergebnis = mysqli_query($link, $abfrage) or die(mysqli_error($link));
    
    $login = @$_POST['benutzername'].$_POST['kennwort'];
    echo $login."<br/>";
    
    while($zeile= mysqli_fetch_array($ergebnis))
    {
       
             $login2 = $zeile['user_name'].$zeile['user_password'];
        
            echo $login2."<br/>";
 
           
        
        if($login==$login2) //eingelesenes wird mit benutzer login verglichen
        {
            $eingeloggt = true;
             $benutzertyp = $zeile['user_typ']; //benutzertyp wird ausgelesen und gespeichert
             $benutzertyp = trim($benutzertyp,"\n");
            break;
        }
       
    }
    
    
    
    
     mysqli_close($link);
}


if(@$eingeloggt)
{
    $_SESSION['benutzername']= $_POST['benutzername'];
    $_SESSION['benutzertyp']= $benutzertyp;
    $_SESSION['eingeloggt']=true;
    echo "Ihr Login war erfolgreich";
    echo "<h2>Herzlich willkommen ".$_SESSION['benutzername']."</h2>";
    echo "Ihre Session-ID lautet:".session_id()."<br/>";
    echo $benutzertyp;
    if($_SESSION['benutzertyp'] == 'abwart')
    {
        var_dump($benutzertyp);
    echo "<a href=\"login_abwart.php\"> Jetzt haben Sie auch Zutritt zu dieser Seite</a>";
    }
    if($_SESSION['benutzertyp'] == 'mieter')
    {
        var_dump($benutzertyp);
    echo "<a href=\"login_mieter.php\"> Jetzt haben Sie auch Zutritt zu dieser Seite</a>";  
    }
}

else
{
    echo "kein Zutritt";
}