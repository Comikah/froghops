<html lang="de">
<head>

    <?php
    include("head.php");
    ?>
</head>
<body id="login" data-spy="scroll" data-target="#navbar">

<?php
include("header.php");

if(!isset($_GET['userid']) || !isset($_GET['code'])) {
    die("Leider wurde beim Aufruf dieser Website kein Code zum Zurücksetzen deines Passworts übermittelt");
}

//Variablen für den User und den Code werden per GET geholt aus dem Link
$userid = $_GET['userid'];
$code = $_GET['code'];

//Abfrage des Nutzers
$statement = $pdo->prepare("SELECT * FROM users WHERE user_id = :userid");
$result = $statement->execute(array('userid' => $userid));
$user = $statement->fetch();


//Überprüfe dass ein Nutzer gefunden wurde und dieser auch ein Passwortcode hat
if($userid == null || $user['passwortcode'] == null) {
    die("Es wurde kein passender Benutzer gefunden");
}

//Eventuell Zeitabfrage weglassen!
$codetime=(int) $user['passwortcode_time'];
//echo "Zeit:".$codetime;
//Überprüfe, ob die Zeit abgelaufen ist, und der Code ungültig ist
if($codetime > 2017 ) {   //  (time()-24*3600)
    die("Dein Code ist leider abgelaufen");
}


//Überprüfe den Passwortcode
if($code != $user['passwortcode']) { //sha1($code) davor!
    die("Der übergebene Code war ungültig. Stell sicher, dass du den genauen Link in der URL aufgerufen hast.");
}

//Der Code war korrekt, der Nutzer darf ein neues Passwort eingeben
if(isset($_GET['send'])) {
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];

    if($passwort != $passwort2) {
        $_SESSION['msg'] = 'Bitte identische Passwörter eingeben!';
        $_SESSION['msg_error'] = true;
    } else { //Speichere neues Passwort und lösche den Code
        $passworthash = password_hash($passwort, PASSWORD_DEFAULT);
        $statement = $pdo->prepare("UPDATE users SET passwort = :passworthash, passwortcode = NULL, passwortcode_time = NULL WHERE user_id = :userid");
        $result = $statement->execute(array('passworthash' => $passworthash, 'userid'=> $userid ));

        if($result) {
            die("Dein Passwort wurde erfolgreich geändert");
        }
    }
}
?>


<div class="container">
    <div class="row">

        <div class="col-md-3"> </div>

        <div class="col-md-6" id="rahmen">

            <h1 class="ueberschrift" id="center"> Passwort zurücksetzen </h1>
            <br>
            <p id="center"> Bitte trage ein neues Passwort ein.</p>

            <div id="rahmenInnen">
                <form action="?send=1&amp;userid=<?php echo htmlentities($userid); ?>&amp;code=<?php echo htmlentities($code); ?>" method="post">

                    <input class="form-control" type="password" id="nachrichtKontaktformular" name="passwort" placeholder="Passwort"> <br>
                    <input class="form-control" type="password" id="nachrichtKontaktformular" name="passwort2" placeholder="Passwort wiederholen"> <br>
                    <input class="btn btn-primary" id="submit" type="submit" name="submit" value="Bestätigen">

                </form>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>

</body>
</html>