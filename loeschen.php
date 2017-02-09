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
//SESSION Variablen "Username" und "Userid" holen
/*if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}

if(isset($_SESSION['username'])){
    $userid = $_SESSION['userid'];
}
*/
$id=isset($_POST['id']) ? $_POST['id'] : die('ERROR: ID not found.');
$sqli= "SELECT * FROM uploads WHERE id = $id";
$statement = $pdo->prepare($sqli);
$statement->execute();
$statement->setFetchMode(PDO::FETCH_ASSOC);
$row = $statement->fetch();

$sql= "SELECT datei_name FROM uploads WHERE id = $id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$loeschname = $stmt->fetch();

$loeschedatei = $loeschname["datei_name"];
$dir = "/home/sd103/public_html/hochgeladenes/files/";


try {

    //$id=isset($_POST['id']) ? $_POST['id'] : die('ERROR: ID not found.');
    //$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
    $query = "DELETE FROM uploads WHERE id = $id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(1, $id);


    if($stmt->execute() && unlink($dir . "$loeschedatei")){

        header('Location: dashboard.php?action=deleted');

    }else{
        die('Nicht möglich die Datei zu löschen');
    }
}
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>

</body>
</html>