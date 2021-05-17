<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
        if (!isset($_SESSION['email'])) {
          echo "Please sign in &nbsp;&nbsp; <a href='?page=login'> Log In &nbsp; / &nbsp; </a> <a href='?page=register'> Register</a>";
          die();
        }


        if (!$_SESSION['order']){
            $_SESSION['order'] = array();
        };

        // foreach($_SESSION['order'][0]['id'] as $order){
        //     if ($order == $_POST['id']){
        //         $_SESSION['order']['amount'] += $_POST['amount'];
        //     }
        // }

        array_push($_SESSION['order'],$_POST);

        
        ?>
    hej
    <?php

    print_r($_SESSION);
    ?>
</body>
</html>