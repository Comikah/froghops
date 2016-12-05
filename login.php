<?php
session_start();
$pdo = new PDO('mars.iuk.hdm-stuttgart.de', 'u-sd103', 'sd103', 'ooshe9OhNi');

if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];

    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['userid'] = $user['user_id'];
        die('Login erfolgreich. Weiter zu <a href="dashboard.php">internen Bereich</a>');
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<?php
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>

<form action="?login=1" method="post">
    E-Mail:<br>
    <input type="email" size="40" maxlength="250" name="email"><br><br>

    Dein Passwort:<br>
    <input type="password" size="40"  maxlength="250" name="passwort"><br>

    <input type="submit" value="Anmelden">

    <p> Noch nicht <a href="registrieren.php">registriert</a>?</p>
</form>
</body>
</html>