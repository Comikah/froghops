<html lang="de">
<head>

    <?php
    include("head.php");
    ?>
</head>
<body id="login" data-spy="scroll" data-target="#navbar">

<?php

include("header.php");


// Funktion, um einen String zu hashen
function random_string() {
    if(function_exists('random_bytes')) {
        $bytes = random_bytes(16);
        $str = bin2hex($bytes);
    } else if(function_exists('openssl_random_pseudo_bytes')) {
        $bytes = openssl_random_pseudo_bytes(16);
        $str = bin2hex($bytes);
    } else if(function_exists('mcrypt_create_iv')) {
        $bytes = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
        $str = bin2hex($bytes);
    } else {
        $str = md5(uniqid('das_ist_der_neue_string123', true)); //string beliebig austauschen >12
    }
    return $str;
}

// showForm Variable wird erstellt, um die Form später ausblenden zu können
$showForm = true;

// Prüfung, ob Werte in das Formular eingetragen wurden (GET)
if(isset($_GET['send']) ) {
    if(!isset($_POST['email']) || empty($_POST['email'])) {
        $error = "<b>Bitte eine E-Mail-Adresse eintragen</b>";

    } else {
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $_POST['email']));
        $user = $statement->fetch();

        //Prüfung, ob ein Benutzer gefunden wurde
        if($user == false) {
            $error = "<b>Kein Benutzer gefunden</b>";
        } else {
            //Überprüfen, ob der User schon einen Passwortcode hat oder ob dieser abgelaufen ist
            $passwortcode = random_string();
            $statement = $pdo->prepare("UPDATE users SET passwortcode = :passwortcode, passwortcode_time = NOW() WHERE user_id = :userid");

            $result = $statement->execute(array(':passwortcode' => $passwortcode, ':userid' => $user['user_id']));
            //print_r($statement->errorInfo());
            //echo "DB -Passcode ".$passwortcode." userid ".$user['user_id'];

            // Werte für Emailfunktion generieren
            $empfaenger = $user['email'];
            $betreff = "Neues Passwort für deinen Account auf Frog Drops";
            $from = "From: Stephen Duscher <ste.duscher@googlemail.com>";
            $url_passwortcode = 'https://mars.iuk.hdm-stuttgart.de/~sd103/passwortzuruecksetzen.php?userid='.$user['user_id'].'&code='.$passwortcode;
            $text = 'Hallo '.$user['vorname'].',
für deinen Account auf Frog Drops wurde nach einem neuen Passwort gefragt. Um ein neues Passwort zu vergeben, rufe innerhalb der nächsten 24 Stunden die folgende Website auf:
'.$url_passwortcode.'
 
Sollte dir dein Passwort wieder eingefallen sein oder hast du dies nicht angefordert, so ignoriere diese E-Mail einfach.
 
Viele Grüße,
dein Frog Drop Team';


            // Email funktion - Email versenden
            mail($empfaenger, $betreff, $text, $from);

            $_SESSION['msg'] = "Ein Link um dein Passwort zurückzusetzen wurde an deine E-Mail-Adresse gesendet.";
            $showForm = false;
        }
    }
}

if($showForm):
    ?>
<!--
    <h1>Passwort vergessen</h1>
    Gib hier deine E-Mail-Adresse ein, um ein neues Passwort anzufordern.<br><br>


    <form action="passwortvergessen.php?send=1" method="post">
        E-Mail:<br>
        <input type="email" name="email" value="<?php //echo isset($_POST['email']) ? htmlentities($_POST['email']) : ''; ?>"><br>
        <input type="submit" value="Neues Passwort">
    </form>
-->

    <!-- Formular für Emailversendung -->
    <div class="container">
        <div class="row">

            <div class="col-md-3"> </div>

            <div class="col-md-6" id="rahmen">

                <h1 class="ueberschrift" id="center"> Passwort vergessen </h1>
                <br>
                <p id="center"> Trage deine E-Mail Adresse ein, um ein neues Passwort anzufordern.</p>

                <div id="rahmenInnen">
                <form action="passwortvergessen.php?send=1" method="post">

                    <input class="form-control" type="email" id="nachrichtKontaktformular" name="email" value="<?php echo isset($_POST['email']) ? htmlentities($_POST['email']) : ''; ?>"> <br>

                    <input class="btn btn-primary" id="submit" type="submit" name="submit" value="Neues Passwort">

                </form>
                </div>
            </div>
        </div>
    </div>


    <?php
    if(isset($error) && !empty($error)) {
        $_SESSION['msg'] = $error;
        $_SESSION['msg_error'] = true;
    }

endif; //Endif von if($showForm)

   include("footer.php");
    ?>


</body>
</html>