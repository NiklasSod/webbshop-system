<?php
if (isset($_SESSION['loginInfo'])) {
    echo "CUSTOMER ID: ";
    echo "<pre> ";
    print_r($_SESSION['loginInfo']['loggedInCustomer'][0]['id']);
    echo " </pre>";
    
    echo " ORDERS: ";
    echo "<pre> ";
    print_r($orders);
    echo "</pre>";
}