<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/Database.php';
require '../src/config.php';

$app = new \Slim\App;

require '../src/routes/products.php';

$app->run();
