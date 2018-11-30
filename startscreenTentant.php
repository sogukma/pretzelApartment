<?php
/**
 * startscreenTentant.php
 *
 * Landingpage für Mieter.
 * Momentan ist die Webapplikation nicht für Mieter vorgesehen, was entsprechend hier gemeldet wird.
 *
 * @category   View
 * @author     Malik
 */
include 'sessionHandling.php';
$sh = sessionHandling::Instance();
$sh->open_session(); //vorhandene session übernehmen
$sh->regenerate_session_id();
$sh->isCorrectPape("mieter");
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>

    <body>
        <?php
        echo "Hallo Mieter. Wir arbeiten gerade an einer Website für Sie. Bitte um Geduld!<br/>";
        echo "<br/><a href='index.php'>Logout</a>";
        ?>
    </body>
</html>