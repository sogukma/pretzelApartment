<?php
/**
 * updateUser.php
 *
 * Stellt ein Formular für das Ändern eines Benutzers zur Verfügung.
 * Beim Absenden des Formular wird in der Datenbank die entsprechende Funktion aufgerufen.
 *
 * @category   Controller, View
 * @author     Halil
 */
include '../sessionHandling.php';

$sh = sessionHandling::Instance();
$sh->open_session(); //vorhandene session übernehmen
$sh->regenerate_session_id();
$sh->isCorrectPape("abwart");



if (isset($_GET['user_id'])) {

    $_SESSION['user_id'] = $_GET['user_id'];
} else {
    echo "User Id nicht vorhanden";
}

function update() {
    include '../dbConnector.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $benutzertyp = $_POST["benutzertyp"];
    $nachname = $_POST['nachname'];
    $vorname = $_POST['vorname'];
    $strassennummer = $_POST['strassennummer'];
    $dbc->update($_SESSION['user_id'], $username, $password, $benutzertyp, $nachname, $vorname, $strassennummer);
    header("Location:manageUsers.php");
}

;

if (isset($_POST['submit'])) {
    update();
}
?>
<html>
    <head>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../Header-Picture.css">
        <link rel="stylesheet" href="../style.css">


    </head>
    <body>
        <!-- Nav-Bar und alle JavaScript-Libraries werden included  -->
        <?php
        include '../Header.html';
        ?>
        <div class="insertForm rounded container">
            <h3>Benutzerangeben ändern</h3>
            <form method="post" action="updateUser.php">
                    <div class="form-group row"> 
                        <label for="username" class="col-sm-10 col-form-label">Benutzername</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="username" name="username" type="text" required="true"/><br/>
                        </div>
                    </div>
                    <div class="form-group row"> 
                        <label for="password" class="col-sm-10 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="password" name="password" type="password" required="true"/><br/>
                        </div>
                    </div>
                    <div class="form-group row"> 
                        <label for="nachname" class="col-sm-10 col-form-label">Nachname</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="nachname" name="nachname" type="text" required="true"/><br/>
                        </div>
                    </div>
                    <div class="form-group row"> 
                        <label for="vorname" class="col-sm-10 col-form-label">Vorname</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="vorname" name="vorname" type="text" required="true"/><br/>
                        </div>
                    </div>
                    <div class="form-group row"> 
                        <label for="strassennummer" class="col-sm-10 col-form-label">Strassennummer</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="strassennummer" name="strassennummer" type="text" required="true" pattern="^[0-9]+[a-z]*$"/><br/>
                        </div>
                    </div>
                <div class="form-group">
                    <label for="benutzertyp">Benutzertyp</label>
                    <select class="form-control" name="benutzertyp" id="benutzertyp">
                        <option checked value="mieter">Mieter</option>
                        <option value="abwart">Abwart</option>

                    </select>
                </div> 

                <input name="submit" class="btn btn-primary" type="submit"><input class="btn" type="reset"><br/>
            </form>
        </div>

    </body>
</html>