<?php

require 'vendor/autoload.php';
require_once 'datos/AccesoDatos.php';
require_once 'api/loginApi.php';
require_once 'entidades/login.php';
require_once 'middleware/MWparaAutentificar.php';
require_once 'middleware/MWparaCORS.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->post('/login', \loginApi::class. ':obtenerLogin');      


$app->run();

?>