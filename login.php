<html lang="de">
<head>

<?php
include("head.php");
?>

</head>

<body id="login" class="loginkomplett" data-spy="scroll" data-target="#navbar">

<?php


if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];

    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();

    $vornameholen = $pdo->prepare('SELECT vorname FROM users WHERE email = :email');
    $vornamegeholt = $vornameholen->execute(array('email' => $email));
    $username = $vornameholen->fetch();



    //Überprüfung: var_dump($_SESSION);

    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['username'] =  $username['vorname'];
        $_SESSION['userid'] = $user['user_id'];
        header('Location: dashboard.php');
        //Alternative: die('Login erfolgreich. Weiter zu <a href="dashboard.php">internem Bereich</a>');

    } else {
        $_SESSION["msg"] = "E-Mail oder Passwort war ungültig";
    }

}

/*
            if(isset($errorMessage)) {
                echo $errorMessage;
            }
*/

include("header.php");
?>

<div id="jumbotron" class="jumbotron">
    <div id="divjumbotron" class="row">

        <h1>FrogDrops</h1>
        <p>Leiche deine Daten bei uns ab!</p>
        <br>
       <!-- <hr> -->

        <p>Bei FrogDrops erhälst du 50MB, um deine wichtigsten Daten abzulegen.</p>

    </div>
</div>

<div id="jumbotron2" class="jumbotron">
    <div class="row">


    </div>
</div>

<div class="container" id="mehrInfo">

    <div class="row" id="zusammenfassung">

        <h1></h1>
        <p class="lead"></p>
    </div>

</div>






            <?php

            include("footer.php");
            ?>


</body>
</html>