<?php
if (!isset($_SESSION['isAdmin'])) {
    header("refresh:0; url=index.php");
    die();
}

?>
<div class="mx-auto">
    <a class="btn btn-lg btn-primary" href="?page=update">Update</a>

    <a class="btn btn-lg btn-success m-5" href="?page=create">Create Product</a>

    <a class="btn btn-lg btn-danger" href="?page=delete">Delete Product</a>
</div>
