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
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}

if(isset($_SESSION['username'])){
    $userid = $_SESSION['userid'];
}


    $id=isset($_POST['id']) ? $_POST['id'] : die('ERROR: ID wurde nicht gefunden.');


    if(isset($_POST['name'])) {

    try{
        $query = "UPDATE uploads 
                    SET original_name= :name
                    WHERE id = $id";
        $stmt = $pdo->prepare($query);
        $name=htmlspecialchars(strip_tags($_POST['name']));
        $stmt->bindParam(':name', $name);


        if(!$stmt->execute()){
            $_SESSION['msg'] = "Bitte versuche es erneut!";
            $_SESSION['msg_error'] = true;
        }

    }

    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>


</body>
</html>