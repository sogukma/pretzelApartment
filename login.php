<?php
include 'sessionHandling.php';
include './DAO.php';

$sh = sessionHandling::Instance();
// vorhandene session übernehmen
$sh->open_session();
$sh->regenerate_session_id();

if(!$sh->session_is_open())
{
$eingeloggt = false;
}


    if(isset($_POST['benutzername']) AND isset($_POST['kennwort']))
    {
        //prüfen ob login ok oder nicht
        // if($_POST['benutzername'] == "martin" AND $_POST['kennwort'] == "1234")
        $dbC = DAO::Instance();
        $dbC->connect();
        $abfrage="select * from users";
        $ergebnis = mysqli_query($dbC->getLink(), $abfrage) or die(mysqli_error($dbC->getLink()));

        $login = @$_POST['benutzername'].$_POST['kennwort'];
        echo $login."<br/>";

        while($zeile= mysqli_fetch_array($ergebnis))
        {


                 $login2 = $zeile['user_name'].$zeile['user_password'];

                echo $login2."<br/>";


            if (password_verify($_POST['kennwort'], $zeile['user_password'])) {

                        if($_POST['benutzername']==$zeile['user_name']) //eingelesenes wird mit benutzer login verglichen
                      {
                          $eingeloggt = true;
                           $benutzertyp = $zeile['user_typ']; //benutzertyp wird ausgelesen und gespeichert
                           $benutzertyp = trim($benutzertyp,"\n");
                          break;
                      }
             }
        }


         mysqli_close($dbC->getLink());
    }


if(@$eingeloggt)
{
  /*     session_regenerate_id(true);
            $token = $authService->issueToken();
            $_SESSION["agentLogin"]["token"] = $token;
            if(isset($_POST["remember"])) {
                setcookie("token", $token, (new \DateTime('now'))->modify('+30 days')->getTimestamp(), "/");
            } */
            
    $_SESSION['benutzername']= $_POST['benutzername'];
    $_SESSION['benutzertyp']= $benutzertyp;
    $_SESSION['eingeloggt']=true;
    echo "Ihr Login war erfolgreich";
    echo "<h2>Herzlich willkommen ".$_SESSION['benutzername']."</h2>";
    echo "Ihre Session-ID lautet:".session_id()."<br/>";
    if($_SESSION['benutzertyp'] == 'abwart')
    {
    header("Location: startscreenCaretaker.php");
    }
    if($_SESSION['benutzertyp'] == 'mieter')
    {
    header("Location: startscreenTentant.php");
    }
}

else
{
    echo "kein Zutritt";
}