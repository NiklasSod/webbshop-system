<?php
//Get Heroku ClearDB connection information
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
?>

<?php

require_once("models/Database.php");
require_once("models/Model.php");
require_once("views/View.php");
require_once("./controllers/Controller.php");
require_once("./controllers/AdminController.php");

$database = new Database("webshop2", "root", "root");
$model = new Model($database);
$view = new View();
$adminController = new AdminController($model, $view);
$controller = new Controller($model, $view, $adminController);

$controller->main();