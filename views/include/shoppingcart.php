<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShoppingCart</title>
</head>
<body>

<?php
// Ej inloggad ger direkt info om att logga in och scriptet stoppas
if (!isset($_SESSION['email'])) {
    echo "Please sign in &nbsp;&nbsp; <a href='?page=login'> Log In &nbsp; / &nbsp; </a> <a href='?page=register'> Register</a>";
    die();
}

// Om man kommer in till sidan via varukorg-länk ska ej array pushas / fel uppstå
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // if order does not exist, create an array and order
    if (!isset($_SESSION['order'])){
        $_SESSION['order'] = array();
    }
    
    // Kontrollerar id för duplicering, isåfall uppdatera antal
    if (count($_SESSION['order']) > 0) {
        $amountOfOrders = count($_SESSION['order']);
        for ($i = 0; $i < $amountOfOrders; $i++) {
            // Kollar om kort redan finns i varukorgen
            if ($_SESSION['order'][$i]['id'] === $_POST['id']) {
                $updatedAmount = $_SESSION['order'][$i]['amount'] += $_POST['amount'];
            }
        }
    }
    // Om vi inte hittar några dupliceringar, pusha ny order
    if (!isset($updatedAmount)) {
        array_push($_SESSION['order'],$_POST);
    }
}
    // temporärt
    echo "<pre>";
    print_r($_POST);
    print_r($_SESSION['order']);
    echo "</pre>";
?>

</body>
</html>