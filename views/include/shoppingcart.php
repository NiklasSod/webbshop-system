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


        if (!isset($_SESSION['order'])){
            $_SESSION['order'] = array();
        };

        
        // if(empty($_SESSION['order'])){
        //     $lim = 2;
        // } else {
        //     $lim = count($_SESSION['order']);
        // }

        // for ($i = 0; $i < $lim; $i++) {
        //     if ($_SESSION['order'][$i]['id'] == $_POST['id']) {
        //         $_SESSION['order'][$i]['amount'] += $_POST['amount'];
        //     break;
        //     } else if($i == count($_SESSION['order'])) {
        //         array_push($_SESSION['order'],$_POST);
        //     };
        // };

        

        
        ?>
    <?php

        echo "<pre>";
        print_r($_SESSION['order']);
        echo "</pre>";
    //print_r($_SESSION);
    ?>
</body>
</html>