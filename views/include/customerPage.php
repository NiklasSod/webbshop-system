<?php
if (!isset($_SESSION['customer_id'])) {
    header("refresh:0; url=index.php");
    die();
}
?>


<table class="table table-hover mt-3">
<h6>Your Orders</h6>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Order Date</th>
                <th scope="col">Order Status</th>
            </tr>
        </thead>
        <tbody>


<?php

$row = 0;

foreach ($orders as $order) {
    $row += 1;
    viewOneOrder($order, $row);
}

function viewOneOrder($order, $row){
    $output = "Registered";
    if ($order['orderStatus'] == 1){
        $output = "On its way";
    }

    $html = <<<HTML
    <tr>
        <td>$row</td>
        <td>$order[RegisterDate]</td>
        <td>$output</td>
    </tr>

HTML;

echo $html;
}