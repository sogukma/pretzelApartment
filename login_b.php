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
    $login = @$_POST['benutzername'].$_POST['kennwort'];
    echo $login."<br/>";
    $logins=file("login.csv"); //logins wird zeilenweise aus csv gelesen
    for($i = 0; $i<sizeof($logins);$i++)
    {
        $zeile= explode(';', $logins[$i]);
        echo $zeile[0].$zeile[1].$zeile[2].$zeile[3]."<br/>";
        $login2=$zeile[0].$zeile[1];
       
       
        
        if($login==$login2) //eingelesenes wird mit benutzer login verglichen
        {
            $eingeloggt = true;
             $benutzertyp = $zeile[3]; //benutzertyp wird ausgelesen und gespeichert
             $benutzertyp = trim($benutzertyp,"\n");
            break;
        }
 
    }

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