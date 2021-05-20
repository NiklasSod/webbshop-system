<?php
if (!isset($_SESSION['isAdmin'])) {
    header("refresh:0; url=index.php");
    die();
}

echo "hej";