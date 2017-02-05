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

        #hintergrund_login{
            width: 50px;
            height: 50px;
            position: fixed;
            top:0;
        }

        #homebutton{
            margin-left: -4px;
            width: 50px;
            height: 50px;
            position: fixed;
            top:0;
            left: 0;
        }

        #Buttongr{
            width: 140px;
            height: 33.5px;
            font-size: 14px;
            text-align: center;
            margin-top: 8px;
            margin-right: 4px;
            padding: 0;
            padding-top: 7px;
            vertical-align: middle;
            background-color: #286090;

        }

        #Platzhalter{
            height: 60px;
        }

        #profilbildG {

            width: 200px;
            height: 200px;
        }



    </style>


    <?php
    session_start();

    if(!isset($_SESSION['userid'])) {
    header('Location: login.php');
    // die('Bitte zuerst <a href="login.php">einloggen</a>!');
    }

    include("userdata.php");
    ?>
</head>
