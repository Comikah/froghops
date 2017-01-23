<?php
session_start();

include_once("userdata.php");

/*if(isset($_GET['pwaendern'])) {
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];
    $passwortNeu = $_POST['passwort3'];

    $statement = $pdo->prepare('SELECT user_id FROM users WHERE passwort = :passwort');
    $result = $statement->execute(array('passwort' => $passwort));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $statement2 = $pdo->prepare("UPDATE users SET passwort = :'".$passwortNeu."' WHERE user_id = '".$_SESSION['userid']."' ");
        $statement2->execute(array('user_id' => $_SESSION['userid'], 'passwort' => '$passwortNeu'));

    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }
*/
 include_once ("dashboard.php");

    if(isset($_GET['pwaendern'])) {
    $error = false;
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];
    $passwortNeu = $_POST['passwort3'];

/*
    if(strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
*/
        if(($passwort != $passwort2) && ($passwort == $passwortNeu) ) {
        echo 'Die Passwörter stimmen nicht überein oder das neugewählte Passwort ist unverändert! <br>';
        $error = true;
    }


    //Keine Fehler, wir können das Passwort ändern
    if(!$error) {

    $statement2 = $pdo->prepare("UPDATE users SET passwort = '".$passwortNeu."' WHERE user_id = '".$userid."' ");
    $statement2->execute(array(':passwort' => $passwortNeu));


        } else {
            echo 'Beim Ändern ist leider ein Fehler aufgetreten <br>'.$pdo->errorInfo();
        }

}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Passwort ändern</title>
</head>
<body>

<?php
if(isset($errorMessage)) {
    echo $errorMessage;
    echo "<a href=\"".passwortaendern.php."\">Erneut eingeben</a> <br><br>";
}
?>

<form action="passwortaendern.php?pwaendern=1" method="post">
    Passwort:<br>
    <input type="password" size="40" maxlength="250" name="passwort1"><br><br>

    Passwort wiederholen:<br>
    <input type="password" size="40" maxlength="250" name="passwort2"><br><br>

    Neues Passwort:<br>
    <input type="password" size="40"  maxlength="250" name="passwort3"><br>

    <input type="submit" value="Ändern">

</form>
</body>
</html>