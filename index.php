<?php session_start();

require_once("models/Database.php");
require_once("models/Model.php");
require_once("views/View.php");
require_once("./controllers/Controller.php");

$database = new Database("webshop", "root", "root");
$model = new Model($database);
$view = new View();
$controller = new Controller($model, $view);

$controller->main();
print_r($_SESSION);
