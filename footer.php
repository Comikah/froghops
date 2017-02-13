    <!-- Footer Container Element, dass Footer am "Bottom" der SEite bleibt  -->
    <div id="footer_container">


    <div class="container">

    <div id="center" class="page-header">
        <h1>Mehr Informationen</h1>
    </div>

    <p id="center" class="lead">
        <a href="impressum.php">Impressum</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="Kontaktformular.php">Kontakt</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="Aktuelles.php">Aktuelles</a>
    </p>


        <!-- Font Awesome Icons mit links zu den jeweiligen Social Media Kanälen -->
    <p id="center">
        <a  href="http://www.facebook.com"><i class="fa fa-facebook fa-2x" aria-hidden="true"></i> </a> &nbsp;
        <a  href="http://www.twitter.com"><i id="tdicon" class="fa fa-twitter fa-2x" aria-hidden="true"></i></a> &nbsp;
        <a  href="http://www.instagram.com"><i id="tdicon" class="fa fa-instagram fa-2x" aria-hidden="true"></i></a> &nbsp;
    </p>
</div>


<footer class="center">
    <div class="container">
        <p id="center" class="text-muted">© 2017 FrogDrops</p>
    </div>
</footer>

<!-- Pop Up Bereich - Funktion-->
<script>
    <?php

    // SESSION für Pop Up benachrichtigung einrichten. Wenn Error Message -> Rote Schrift (Klasse: Error)
    if(isset($_SESSION['msg'])) {
        if (isset($_SESSION['msg_error'])) {
            echo "bootbox.alert({message: '<p class=\"error\"> " . $_SESSION['msg'] . "</p>', backdrop: true});";
        } else{
            echo "bootbox.alert({message: '" . $_SESSION['msg'] . "', backdrop: true});";
        }
        unset($_SESSION['msg']);
        unset($_SESSION['msg_error']);
    }

    ?>
</script>

</div>
</div>
