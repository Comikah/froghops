<!-- Hier drin stehen LOGOUT PROFIL LOGO(HOMEBUTTON)-->
<?php
//Prüfung, ob SESSION Inhalte hat und in Variablen speichern - Username und User ID
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}

if(isset($_SESSION['username'])){
    $userid = $_SESSION['userid'];
}

?>


<!-- Linke Spalte vom Header - Logo und Name -->
<nav class="navbar navbar-default navbar-fixed-top" id="navbar">
    <div class="container-fluid">
        <!-- Titel und Schalter werden für eine bessere mobile Ansicht zusammengefasst -->
        <div class="navbar-header">
            <a id="homebutton" class="navbar-brand" href="dashboard.php"> <img id="hintergrund_login" alt="Titel" src="Bilder/logo_frosch_bunt.png"> </a>
            <h5 id="FrogDropsSchrift"> FrogDrops</h5>
            <button type="button" onclick="$('#Platzhalter').toggleClass('menu_active');" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Navigation ein-/ausblenden</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <a id="homebutton" class="navbar-brand" href="dashboard.php"> <img id="hintergrund_login" alt="Titel" src="Bilder/logo_frosch_bunt.png"> </a>
                <h5 id="FrogDropsSchrift"> FrogDrops</h5>
            </ul>


            <!-- IF Abfrage, um den richtigen Header auszugeben (Rechte Seite verändert sich im Login und Dashboard Bereich)-->
            <?php
            if (isset($_SESSION["username"])){

            ?>

            <ul class="nav navbar-nav navbar-right">

                <!-- Profilbild Name aus Datenbank herauslesen und in Variable speichern-->
                <?php
                $sqli= "SELECT profilbild FROM users WHERE user_id = $userid";
                $statement = $pdo->prepare($sqli);
                $statement->execute();
                $statement->setFetchMode(PDO::FETCH_ASSOC);
                $row = $statement->fetch();

                //Wenn Profilbild in Datenbank vorhanden, soll es angezeigt werden
                If ($row["profilbild"] != NULL) {
                    ?>
                    <!-- Buttons rechts von der Menüleiste -->
                    <span id="Buttonk"
                       role="button"> <?php echo "<img id='profilbildK' src='hochgeladenes/profile/" . $row["profilbild"] . "'>"; ?> </span>
                    <?php
                    ;}
                ?>



                <!-- Dropdown - Einstellungen
                <a id="Buttongr" class="btn btn-primary btn-lg" href="profilbild_upload.php" role="button"><?php
                    //echo $username;
                    ?></p></a> -->


                <!-- Bootstrap Dropdown Menü für das Userprofil und Logout-->
                <div class="btn-group">
                    <button id="Buttondropdown" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i id="tdicon" class="fa fa-user" aria-hidden="true"></i>    <?php echo $username; ?>   <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="profilbild_upload.php">Profilbild</a></li>
                        <li><a href="passwortaendern.php">Passwort &auml;ndern</a></li>

                    </ul>
                </div>


                <a id="Buttongr" class="btn btn-primary btn-lg" href="logout.php" role="button"><i id="tdicon" class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
            </ul>

            <?php
            }else
            {
            ?>

            <!-- Bootstrap Menü Rechts für das Login Formular inkl. Passwort vergessen und Registrieren-->
            <ul class="nav navbar-nav navbar-right">
                <form class="navbar-form navbar-left" role="search" action="login.php?login=1" method="post">
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="email">
                        <input type="password" class="form-control" name="passwort" placeholder="passwort">
                    </div>
                    <button type="submit" class="btn btn-success" value="Anmelden"><i id="tdicon" class="fa fa-sign-in" aria-hidden="true"></i> Anmelden</button>
                </form>
                <a id="Buttongr" class="btn btn-primary btn-lg" href="passwortvergessen.php" role="button">Passwort vergessen?</a>
                <a id="Buttongr" class="btn btn-primary btn-lg" href="registrieren.php" role="button">Registrieren</a>



            </ul>


                <?php
            }
            ?>



        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<!-- Elemente im Body werden nach dem Platzhalter DIV Element angezeigt (Style) -->
<div id="Platzhalter">

</div>

<div id="page_container" class="container">