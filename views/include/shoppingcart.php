<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShoppingCart</title>
</head>

<body>

    <?php
    // If not signed in, message to sign in appears
    if (!isset($_SESSION['email'])) {
        echo "<h5 class='col-md-12 mb-3'>Please <a href='?page=login'>log In</a> or <a href='?page=register'>register</a> to proceed</h5>";
    }

    // URL Safety Check
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check'])) {

        // if order does not exist, create an array and order
        if (!isset($_SESSION['order'])) {
            $_SESSION['order'] = array();
        }

        // Check for duplicates, if true: add to amount.
        if (count($_SESSION['order']) > 0) {
            $amountOfOrders = count($_SESSION['order']);
            for ($i = 0; $i < $amountOfOrders; $i++) {
                // Check if card id is already in cart
                if ($_SESSION['order'][$i]['id'] === $_POST['id']) {
                    $updatedAmount = $_SESSION['order'][$i]['amount'] += $_POST['amount'];
                }
            }
        }
        // If no duplicates, push new order
        if (!isset($updatedAmount)) {
            array_push($_SESSION['order'], $_POST);
        }
        header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
        exit();
    }
    ?>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Card name</th>
                <th scope="col">Price one card</th>
                <th scope="col">Amount</th>
                <th scope="col">Total price</th>
            </tr>
        </thead>
        <tbody>
    
    <?php 
    if(isset($_SESSION['order'])){ 
        if(isset($_POST['clear'])){
            unset($_SESSION['order']);
            exit();
        }
        ?>
        <form method="POST" action="#">
            <input value="clear" name="clear" hidden="true">
            <input type="submit" class="btn btn-danger m-5 btn-lg p-2 fixed-bottom" value="Empty Cart">
        </form>
    <?php }

    if (isset($_SESSION['order'])) {
        viewAllOrdersInCart();
    }

    function viewAllOrdersInCart()
    {
        $row = 0;
        $totalt = 0;

        foreach ($_SESSION['order'] as $order) {
            $row += 1;

            $sum = viewOneOrderInCart($order, $row);
            $totalt += $sum;
        }

        if(isset($_SESSION['customer_id'])){
        $html = <<<HTML
        <form class="m-5" method="post" action="?page=orderconfirm">
                <input type="hidden" name="sendOrder" value=true>
                <input type="submit" class="btn btn-lg btn-success m-5 p-2" style="position:absolute;bottom:0px;right:0px;margin:0;padding:6px;" value="Check Out">
            </form>
            
        HTML;
        echo $html;
        echo "<h6>Order totall: $totalt</h6>";
        }
    }

    function viewOneOrderInCart($order, $row)
    {
        $sum = $order['price'] * $order['amount'];

        $html = <<<HTML
        
                <tr>
                <th scope="row">$row</th>
                <td>$order[title]</td>
                <td>$order[price]</td>
                <td>$order[amount]</td>
                <td>$sum</td>
                </tr>

        HTML;
        echo $html;
        return $sum;
    }
    ?>

</body>
</html>