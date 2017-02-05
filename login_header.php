<!-- Hier drin stehen LOGOUT PROFIL LOGO(HOMEBUTTON)-->
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <!-- Font Awesome-->
    <link rel="stylesheet" href="https://mars.iuk.hdm-stuttgart.de/~sd103/public_html/CSS/font-awesome.min.css">


    <style>

        .jumbotron{

            background-image: url(bilder/logo_frosch_bunt.png);
            text-align: center;
        }

        #zusammenfassung{
            text-align: center;
        }

        .card-img-top{
            width:100%;
        }

        #Platzhalter{
            height: 50px;
        }

        #footer{
            background-color:lightgrey;
            text-align: center;
            padding-top: 50px;
            padding-bottom: 50px;
            margin-top: 50px;
        }

        #hintergrund_login{
            width: 50px;
            height: 50px;
            position: fixed;
            top:0;
        }

        #Buttongr{
            width: 140px;
            height: 33.5px;
            font-size: 14px;
            text-align: center;
            margin-top: 8px;
            padding: 0;
            padding-top: 7px;
            vertical-align: middle;
            background-color: #286090;
        }

        #homebutton{
            margin-left: -10px;
            width: 50px;
            height: 50px;
            position: fixed;
            top:0;
            left: 0;
        }

        #center{
            text-align: center;
        }

        #FrogDropsSchrift{
            position: relative;
            left: 45px;
            top: 0;
            text-align: center;
            font-size: x-large;
        }

    </style>


    <?php
    session_start();


    include("userdata.php");
    ?>


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

        </div>


        <!-- Alle Navigationslinks, Formulare und anderer Inhalt werden hier zusammengefasst und können dann
        ein- und ausgeblendet werden -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <a id="homebutton" class="navbar-brand" href="login.php"> <img id="hintergrund_login" alt="Titel" src="Bilder/logo_frosch_bunt.png"> </a>
                <h5 id="FrogDropsSchrift"> FrogDrops</h5>
            </ul>



            <ul class="nav navbar-nav navbar-right">
                <form class="navbar-form navbar-left" role="search" action="login.php?login=1" method="post">
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="email">
                        <input type="password" class="form-control" name="passwort" placeholder="passwort">
                    </div>
                    <button type="submit" class="btn btn-success" value="Anmelden">Anmelden</button>
                </form>
                <a id="Buttongr" class="btn btn-primary btn-lg" href="passwortvergessen.php" role="button">Passwort vergessen?</a>
                <a id="Buttongr" class="btn btn-primary btn-lg" href="registrieren.php" role="button">Registrieren</a>



            </ul>


        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div id="Platzhalter">

</div>

