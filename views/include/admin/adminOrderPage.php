<?php
if (!isset($_SESSION['isAdmin'])) {
    header("refresh:0; url=index.php");
    die();
}

?>

<table class="table table-hover mt-3">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Order Id</th>
                <th scope="col">Customer Id</th>
                <th scope="col">Order Date</th>
                <th scope="col">Order Status</th>
            </tr>
        </thead>
        <tbody>