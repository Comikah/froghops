<div class="container">

    <div id="center" class="page-header">
        <h1>INFORMATIONEN ÜBER DER LINE</h1>
    </div>

    <p id="center" class="lead">
        <a href="impressum.php">Impressum</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="Kontaktformular.php">Kontakt</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="Aktuelles.php">Aktuelles</a>

    </p>

    <p id="center">Facebook etc.</p>
</div>

<footer class="center">
    <div class="container">
        <p id="center" class="text-muted">ALL RIGHTS RESERVED UND SO</p>
    </div>
</footer>

<!-- Pop Up Bereich - Funktion-->
<script>
    <?php

    if(isset($_SESSION['msg'])) {
        echo "bootbox.alert({message: '" . $_SESSION['msg'] . "', backdrop: true});";
        unset($_SESSION['msg']);
    }

    ?>
</script>

