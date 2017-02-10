<html lang="de">
<head>
    <?php
    include("head.php");

    if(!isset($_SESSION['userid'])) {
        header('Location: login.php');
        // die('Bitte zuerst <a href="login.php">einloggen</a>!');
    }
    ?>


</head>

<body id="dashboard" data-spy="scroll" data-target="#navbar">
<?php



include("header.php");



if(isset($_GET['send']) ) {
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $error = "<b>Bitte eine E-Mail-Adresse eintragen</b>";
    } else {
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $_POST['email']));
        $user = $statement->fetch();

        if ($user == false) {
            $error = "<b>Kein Benutzer gefunden</b>";
        } else {

            $empfaenger = $_POST['email'];
            $betreff = "Link für meine Dropbox Datei";
            $from = $user['email'];
            $text = 'Hiermit erhalten Sie den Link zu meiner Datei: '
.$_POST['url'].'';


            if (mail($empfaenger, $betreff, $text, $from)) {

                header('Location: dashboard.php');
            }
        }
    }
}

$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID wurde nicht gefunden.');
?>

<form action="linkverschicken.php?send=1" method="post">
    URL:<br>
    <input type="url"  name="url" value="https://mars.iuk.hdm-stuttgart.de/~sd103/datei_runterladen.php?id=<?php echo $id?>" ><br>
    E-Mail:<br>
    <input type="email" name="email" value="  "><br>
    <input type="submit" value="Link verschicken">
</form>
