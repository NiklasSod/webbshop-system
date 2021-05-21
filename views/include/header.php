<?php session_start(); 

if (isset($_GET['page']) && $_GET['page'] === "about") {
  $bootstrap = "";
  $css = "./styles/style2.css";
} else {
  $bootstrap = "text-center m-5 p-3";
  $css = "./styles/styles.css";
  $divRow = "<div class='row'>";
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/bootstrap.css">
  <link rel="stylesheet" href="<?=$css;?>">
  <title><?php echo $title; ?> - Magic Card Shop</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="?page=default">Magic Card Shop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="?page=default">Shop <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?page=about">About us</a>
        </li>
        <?php if (isset($_SESSION['customer_id'])) { ?>
        <li class="nav-item">
          <a class="nav-link" href="?page=customerpage">Profile</a>
        </li>
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link" href="?page=shoppingcart">Shopping Cart</a>
        </li>
        <?php if (isset($_SESSION['isAdmin'])) { ?>
          <li class="nav-item">
            <a class="nav-link" href="?page=adminorderpage">Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?page=adminproductpage">Products</a>
          </li>
        <?php } ?>
        

      </ul>
      <span class="navbar-text">
        <?php
        if (isset($_SESSION['email'])) {
          echo $_SESSION['email'] . "<a href='?page=logout'> Log Out</a>";
        } else {
          echo "<a href='?page=login'> Log In /</a>" . "<a href='?page=register'> Register</a>";
        } 
        ?>
      </span>
    </div>
  </nav>
  <h2 class="<?=$bootstrap;?>"><?php echo $title; ?></h2>
  <div class="container">
    <?php echo $divRow ?? "";