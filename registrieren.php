<?php
session_start();
$dsn = "mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-sd103";

$pdo = new PDO($dsn, 'sd103', 'ooshe9OhNi', array('charset'=>'utf8'));

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrierung</title>
</head>
<body>

<?php
$zeigeFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll

if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }
    if(strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
        if($passwort != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }

    //Überprüfen, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) {
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();

        if($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }
    }

    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

        $statement = $pdo->prepare("INSERT INTO users (user_id, email, vorname, nachname, passwort) VALUES ('', :email, :vorname, :nachname, :passwort)");
        $result = $statement->execute(array(':email' => $email, ':vorname' => $vorname, ':nachname' => $nachname, ':passwort' => $passwort_hash));

        if($result) {
            echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
            $zeigeFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten <br>'.$pdo->errorInfo();
        }
    }
}

if($zeigeFormular) {
    ?>

    <form action="registrieren.php?register=1" method="post">
        E-Mail:<br>
        <input type="email" size="40" maxlength="250" name="email"><br><br>

        Vorname:<br>
        <input type="text" size="40" maxlength="250" name="vorname"><br><br>

        Nachname:<br>
        <input type="text" size="40" maxlength="250" name="nachname"><br><br>

        Dein Passwort:<br>
        <input type="password" size="40"  maxlength="250" name="passwort"><br>

        Passwort wiederholen:<br>
        <input type="password" size="40" maxlength="250" name="passwort2"><br><br>

        <input type="submit" value="Registrieren">
    </form>
    <p> Bereits <a href="login.php">registriert</a>?</p>


    <?php
} //Ende von if($zeigeFormular)
?>

</body>
</html>