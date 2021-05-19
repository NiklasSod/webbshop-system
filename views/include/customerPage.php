<?php
if (isset($_SESSION['customer_id'])) {
    echo " ORDERS: ";
    echo "<pre> ";
    print_r($orders);
    echo "</pre>";
}