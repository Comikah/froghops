
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


$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

try {

    $query = "SELECT notiz FROM uploads WHERE id = $id";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $aktuelleNotiz = $row['notiz'];
}
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}



if(isset($_POST['notizFeld'])) {

    try{
        $query = "UPDATE uploads 
                    SET notiz= :notiz
                    WHERE id = $id";
        $stmt = $pdo->prepare($query);
        $notizFeld=htmlspecialchars(strip_tags($_POST['notizFeld']));
        $stmt->bindParam(':notiz', $notizFeld);


        if($stmt->execute()){
            //echo "<div class='alert alert-success'>Datei wurde umbenannt.</div>";
            $_SESSION['msg'] = "Datei wurde umbenannt";

        }else{
            $_SESSION['msg'] = "Da ist etwas schief gelaufen. Bitte probiere es erneut!";
        }

    }

    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}

?>
<h4> Meine Notiz </h4>

<?php if ($aktuelleNotiz != NULL) {?>
    <p> <?php echo $aktuelleNotiz ?></p>
<?php } else {
    echo "Keine Notiz vorhanden";
} ?>
<br> <br>
<h4> Notiz erstellen oder &auml;ndern </h4>
<form name="notiz" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <textarea name="notizFeld"> <?php echo htmlspecialchars($aktuelleNotiz, ENT_QUOTES);  ?> </textarea>
    <input type="submit"  value="speichern">
</form>


</body>
</html>
