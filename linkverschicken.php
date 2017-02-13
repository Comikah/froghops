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

if(isset($_POST['id']) ) {
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $error = "<b>Bitte eine E-Mail-Adresse eintragen</b>";

    } else {
        $statement = $pdo->prepare("SELECT * FROM users WHERE user_id = '".$_SESSION['userid']."' ");
        $result = $statement->execute(array('userid' => $_SESSION['userid']));
        $user = $statement->fetch();

        $_SESSION['msg'] = "SELECT * FROM users WHERE user_id = '".$_SESSION['userid']."' ";
        $sqli= "SELECT datei_name FROM uploads WHERE freigegeben = '".$_POST['id']."'";
        $statement = $pdo->prepare($sqli);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $freigegeben = $statement->fetch();
        $URL = "https://mars.iuk.hdm-stuttgart.de/~sd103/datei_runterladen.php?id=".$freigegeben["freigegeben"];


        if ($user == false) {

            $error = "<b>Kein Benutzer gefunden</b>";
        } else {



            $empfaenger = $_POST['email'];
            $betreff = "Link für meine FrogDrops Datei";
            $from = 'From: ' . $user['email'] . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            $text = 'Hiermit erhalten Sie den Link zu meiner Datei: ' .$URL.'';


            if (mail($empfaenger, $betreff, $text, $from)) {

                $_SESSION['msg'] = "Link erfolgreich versendet";
                //header('Location: dashboard.php');

            }else {
                $_SESSION['msg'] = "Link konnte nicht versendet werden!";
                $_SESSION['msg_error'] = true;
                //header('Location: dashboard.php');
            }
        }
    }
}

?>
