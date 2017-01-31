<?php
session_start();

include_once("userdata.php");

if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];

    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['userid'] = $user['user_id'];
        die('Login erfolgreich. Weiter zu <a href="dashboard.php">internem Bereich</a>');
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script>

    </script>
    <style>

        .jumbotron{

            background-image: url(Backflip_Spielplatz.jpg);
            text-align: center;
        }

        #zusammenfassung{
            text-align: center;
        }

        .card-img-top{
            width:100%;
        }

        #footer{
            background-color:aqua;
            text-align: center;
            padding-top: 50px;
            padding-bottom: 50px;
            margin-top: 50px;
        }

        #hintergrund_login{
            width: 50px;
            height: 50px;
            position: fixed;
            top:0px;
        }

    </style>

</head>
<body data-spy="scroll" data-target="#navbar">

<nav class="navbar navbar-default navbar-fixed-top" id="navbar">
    <div class="container-fluid">
        <!-- Titel und Schalter werden für eine bessere mobile Ansicht zusammengefasst -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Navigation ein-/ausblenden</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="login.php"> <img id="hintergrund_login" alt="Titel" src="images.jpeg"> </a>
        </div>


        <!-- Alle Navigationslinks, Formulare und anderer Inhalt werden hier zusammengefasst und können dann
        ein- und ausgeblendet werden -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#jumbotron">Home <span class="sr-only">(aktuell)</span></a></li>
                <li><a href="#mehrInfo">Über die App</a></li>
                <li><a href="#footer">App herunterladen</a></li>

            </ul>

            <?php
            if(isset($errorMessage)) {
                echo $errorMessage;
            }
            ?>

            <ul class="nav navbar-nav navbar-right">
                <form class="navbar-form navbar-left" role="search" action="login.php?login=1" method="post">
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="email">
                        <input type="password" class="form-control" name="passwort" placeholder="passwort">
                    </div>
                    <button type="submit" class="btn btn-success" value="Anmelden">Anmelden</button>
                </form>
            </ul>

            <p> Noch nicht <a href="registrieren.php">registriert</a>?</p>
            <p>  <a href="passwortvergessen.php">Passwort vergessen?</a>?</p>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="jumbotron" id="jumbotron">
    <div class="container">
        <h1>FrogDrops</h1>
        <p>Leiche deine Daten bei uns ab!</p>
        <hr>

        <p>Möchtest Du mehr über die App erfahren? Dann trage Dich doch in unsere Mailingliste ein.</p>

        <form class="form-inline">
            <div class="input-group">
                <span class="input-group-addon">@</span>
                <input type="email" class="form-control" placeholder="Deine Emailadresse" aria-label="Summe (gerundet zum nächsten ganzen Euro)">
            </div>
            <button class="btn btn-primary">Eintragen</button>


        </form>
    </div>
</div>

<div class="container" id="mehrInfo">

    <div class="row" id="zusammenfassung">

        <h1>Darum ist diese App so toll!</h1>
        <p class="lead">Zusammenfassung der tollen Features!</p>
    </div>

</div>

<div class="row">
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            <img class="card-img-top" src="vorschau.png" alt="...">
            <div class="caption">
                <h3>Mehr Infos zur App</h3>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et</p>


            </div>
        </div>
    </div>

    <div class="container" id="footer">

        <div class="row">

            <h2>Lade die App herunter!</h2>

            <p><a href=""><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0f/Available_on_the_App_Store_%28black%29_SVG.svg/320px-Available_on_the_App_Store_%28black%29_SVG.svg.png"></a></p>

        </div>

        </div>


<!-- Alte Form
<form action="login.php?login=1" method="post">
    E-Mail:<br>
    <input type="email" size="40" maxlength="250" name="email"><br><br>

    Dein Passwort:<br>
    <input type="password" size="40"  maxlength="250" name="passwort"><br>

    <input type="submit" value="Anmelden">

</form>

<p> Noch nicht <a href="registrieren.php">registriert</a>?</p>
<p>  <a href="passwortvergessen.php">Passwort vergessen?</a>?</p>
-->



</body>
</html>