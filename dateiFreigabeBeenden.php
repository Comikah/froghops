<html lang="de">
<head>
    <?php
    include("userdata.php");

    if(!isset($_SESSION['userid'])) {
        header('Location: login.php');
        // die('Bitte zuerst <a href="login.php">einloggen</a>!');
    }
    ?>
</head>

<body>
<?php

$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID wurde nicht gefunden.');

try {

    //Wenn die Freigabe beendet wird, wird in der Datenbank die Spalte auf NULL gesetzt.
    $query = "UPDATE uploads SET freigegeben = NULL WHERE id = $id";
    $stmt = $pdo->prepare($query);


    if($stmt->execute()){
        $_SESSION['msg'] = "Freigabe erfolgreich beendet";
        header('Location: dashboard.php');

    }else{
        $_SESSION['msg'] = "Freigabe konnte leider nicht beendet werden";
        $_SESSION['msg_error'] = true;
        header('Location: dashboard.php');
    }
}
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>

</body>
</html>