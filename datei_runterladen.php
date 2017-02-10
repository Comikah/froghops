<html lang="de">
<head>
    <?php
    include("head.php");
    ?>
</head>

<body id="dashboard" data-spy="scroll" data-target="#navbar">
<?php

include("header.php");

$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID not found.');

?>

<div class="container">
    <div class="row">
        <div class="embed-responsive embed-responsive-4by3">

            <iframe class="embed-responsive-item"  src="download.php?id=<?php echo $id; ?>">  </iframe>

        </div>
    </div>
</div>




<br>
<br>
<?php
include("footer.php");
?>

</body>
</html>
