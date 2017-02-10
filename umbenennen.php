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
?>

<div class="container">
    <div class="row">

    <div class="page-header">
        <h1>Datei umbenennen</h1>
    </div>
    <?php

    $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

    try {

        $query = "SELECT  id, original_name FROM uploads WHERE id = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $name = $row['original_name'];
    }
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }



    if(isset($_POST['name'])) {

    try{
        $query = "UPDATE uploads 
                    SET original_name= :name
                    WHERE id = $id";
        $stmt = $pdo->prepare($query);
        $name=htmlspecialchars(strip_tags($_POST['name']));
        $stmt->bindParam(':name', $name);


        if($stmt->execute()){
            //echo "<div class='alert alert-success'>Datei wurde umbenannt.</div>";

            $headerWert = true;
            $_SESSION['msg'] = "Datei wurde umbenannt";

                header('Location: dashboard.php');


        }else{
            $_SESSION['msg'] = "Da ist etwas schief gelaufen. Bitte probiere es erneut!";
        }

    }

    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" />
<br>
                <input type='submit' value='Änderungen speichern' class='btn btn-primary' />
</form>


    </div>
</div>



<?php

$ordner = "/home/sd103/public_html/hochgeladenes/profile/";
$alledateien = scandir($ordner);

//$dir = '/hochgeladenes/profile/';
$dir = 'https://mars.iuk.hdm-stuttgart.de/~sd103/public_html/hochgeladenes/profile';
//echo $alledateien["3"];

$einedatei = $alledateien["3"];

//echo $alledateien['1'];
//print_r($alledateien);
//var_dump($alledateien['2']);


//$einedatei = "/umbenennen.php?id=".$id.$einedatei;
$download_name = basename($einedatei);
echo $einedatei;

/*
if (isset($einedatei)) {
    header('Content-Type: application/png');
    header('Content-Disposition: attachment; filename=' . $download_name);
    header('X-Sendfile: ' . $einedatei);
    exit;
}*/
/*
if (isset($einedatei)) {
    header('Content-Description: File Transfer');
    header('Content-Type: image/jpeg');
    header('Content-Disposition: attachment; filename="'.basename($einedatei).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($einedatei));
    readfile($dir.$einedatei);
    exit;
}
*/
/*
header("Content-Type: image/jpeg");
header("Content-Disposition: attachment; filename=\"$einedatei\"");

readfile($dir.$einedatei);
*/


include("footer.php");
?>
</body>
</html>

