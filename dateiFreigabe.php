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

 $URL = md5($id);
    //Wenn die Freigabe ausgeführt wird, wird in der Datenbank die Spalte "freigegeben" mit der Hash ID gefüllt
    $query = "UPDATE uploads SET freigegeben = '$URL' WHERE id = $id";
    $stmt = $pdo->prepare($query);


    if($stmt->execute()){
        $_SESSION['msg'] = "Datei wurde erfolgreich freigegeben";
        header('Location: dashboard.php');

    }else{
        $_SESSION['msg'] = "Datei konnte leider nicht freigegeben werden";
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