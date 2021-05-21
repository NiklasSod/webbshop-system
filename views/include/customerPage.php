<?php
if (!isset($_SESSION['customer_id'])) {
    header("refresh:0; url=index.php");
    die();
}
?>
<pre class="border border-secondary p-4 text-muted rounded">
<h6>Name: <?php echo ucfirst($_SESSION['customer_info'][0]['FirstName']) . " " . ucfirst($_SESSION['customer_info'][0]['LastName']) ?></h6>
<h6>Email: <?php echo $_SESSION['email'] ?></h6>
<h6>Register Date: <?php print_r($_SESSION['customer_info'][0]['RegisterDate']) ?></h6>
</pre>


<table class="table table-hover mt-3">
<h6 class="table mt-5">Your Orders</h6>
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