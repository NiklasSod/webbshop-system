<?php

echo "<h3 class='col-md-12 mx-auto text-center mb-5'>Order Id " . $_GET['id'] . "</h3>";

foreach ($orders as $order) {
    viewOneOrderDetail($order);
}

function viewOneOrderDetail($order) {
        
        $html = <<<HTML
        
        <div class="col-md-5 mx-auto border border-primary mb-4">
            <p>Product Id: $order[productId]</p>
            <p>Amount: $order[amount]</p>
            <p>Price: $order[price]</p>
        </div>

        HTML;

        echo $html;
}

// echo "<pre>";
// print_r($orders);
// echo "</pre>";

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

