
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

//include("header.php");
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}

if(isset($_SESSION['username'])){
    $userid = $_SESSION['userid'];
}


$id=isset($_POST['id']) ? $_POST['id'] : die('ERROR: ID wurde nicht gefunden.');



if(isset($_POST['notiz'])) {

    try{
        $query = "UPDATE uploads 
                    SET notiz= :notiz
                    WHERE id = $id";
        $stmt = $pdo->prepare($query);
        $notiz=htmlspecialchars(strip_tags($_POST['notiz']));
        $stmt->bindParam(':notiz', $notiz);


        if(!$stmt->execute()){

            $_SESSION['msg'] = "Da ist etwas schief gelaufen. Bitte probiere es erneut!";
            $_SESSION['msg_error'] = true;

        }

    }

    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}

?>

<!--
<h4> Meine Notiz </h4>

<?php if ($aktuelleNotiz != NULL) {?>
    <p> <?php //echo $aktuelleNotiz ?></p>
<?php } else {
    //echo "Keine Notiz vorhanden";
} ?>
<br> <br>
<h4> Notiz erstellen oder &auml;ndern </h4>
<form name="notiz" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <textarea name="notizFeld"> <?php //echo htmlspecialchars($aktuelleNotiz, ENT_QUOTES);  ?> </textarea>
    <input type="submit"  value="speichern">
</form>
-->

</body>
</html>
