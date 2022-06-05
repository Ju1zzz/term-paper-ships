<?php

require_once "../vendor/autoload.php";
require_once "../framework/autoload.php";
require_once "../controllers/MainController.php";
require_once "../controllers/ObjectController.php";
require_once "../controllers/SearchController.php";
require_once "../controllers/TypeController.php";
require_once "../controllers/MailController.php";

require_once "../controllers/Controller404.php";


$loader = new \Twig\Loader\FilesystemLoader('../views');

$twig = new \Twig\Environment($loader, [
    "debug" => true 
]);

$twig->addExtension(new \Twig\Extension\DebugExtension());
$url  = $_SERVER["REQUEST_URI"];
$pdo = new PDO("mysql:host=localhost;dbname=ships;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$router = new Router($twig, $pdo);
$router->add("/", MainController::class);
$router->add("/ship/(?P<id>\d+)", ObjectController::class);
$router->add("/search", SearchController::class);
$router->add("/types", TypeController::class);
$router->add("/ship/(?P<id>\d+)/send", MailController::class);

$router->get_or_default(Controller404::class);