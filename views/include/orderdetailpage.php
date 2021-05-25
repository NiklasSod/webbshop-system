<?php

echo "<h3 class='col-md-12 mx-auto mb-3 text-warning'>Order Id " . $_GET['id'] . "</h3>";
$colorGenerator = 0;
foreach ($orders as $order) {
    $colorGenerator += 1;
    viewOneOrderDetail($order, $colorGenerator);
}

function viewOneOrderDetail($order, $colorGenerator) {

    $total = (int)$order['price']*(int)$order['amount'];
    $copiesOrCopy = "copy";
    $color = "primary";
    if ($colorGenerator % 2 === 0) {
        $color = "warning";
    }
    if ((int)$order['amount'] > 1) {
        $copiesOrCopy = "copies";
    }

    $html = <<<HTML
    
    <div class="col-md-6 row mb-4">
        <div class="col-md-6">
            <img class="card-img-top img-thumbnail" 
                src="$order[image]" alt="$order[name]">
        </div>
        <div class="col-md-6">
            <h5 class="mt-3 text-$color">You ordered $order[amount] $copiesOrCopy of the card '$order[name]'. Price per card: $$order[price]. Total: $$total</h5>
        </div>
    </div>

    HTML;

    echo $html;
}