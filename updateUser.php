<?php
     include 'sessionHandling.php';
    include './DAO.php';
        $sh = sessionHandling::Instance();
        $sh->open_session(); //vorhandene session übernehmen
        $sh->regenerate_session_id();
        $sh->isCorrectPape("abwart");
        
        $dbc = DAO::Instance();
        $dbc->connect();
        $_SESSION['dbconnection'] = $dbc;
        

if (isset($_GET['user_id'])) {
    echo $_GET['user_id'];
    $_SESSION['user_id'] = $_GET['user_id'];
}
else
{
    echo "geht nicht";
}


    
    function update(){
        
            $name = $_POST["nname"];
            $password = $_POST["password"];
            $password = password_hash($password, PASSWORD_DEFAULT);
            $benutzertyp = $_POST["benutzertyp"];
            $_SESSION['dbconnection']->update($_SESSION['user_id'],$name, $password, $benutzertyp);
             header("Location:manageUsers.php");
    };
            
   if(isset($_POST['submit']))
        {
           update();
        } 

?>
    <form method="post" action="updateUser.php">
        Name:<input name="nname" type="text" required/><br/>
        Password:<input name="password" type="password" required=""/><br/>
        Benutzername:
          <input type="radio" name="benutzertyp" value="mieter" checked> Mieter
          <input type="radio" name="benutzertyp" value="abwart"> Abwart<br/>
          <input name="submit" type="submit"><input type="reset"><br/>
    </form>
