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


$app->group('/usuario', function () {       
	    	//his->get('/uno/{id}/', \usuarioApi::class . ':traerUno'); 
	        $this->get('/', \usuarioApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':VerificarUsuario'); //OK
	        $this->post('/', \usuarioApi::class . ':cargarUno')->add(\MWparaAutentificar::class . ':VerificarPerfilSocio');//ok
	        $this->post('/eliminar', \usuarioApi::class . ':borrarUno')->add(\MWparaAutentificar::class . ':VerificarPerfilSocio');
	        $this->put('/', \usuarioApi::class . ':modificarUno')->add(\MWparaAutentificar::class . ':VerificarPerfilSocio');        
        })->add(\MWparaCORS::class . ':HabilitarCORS8080');


$app->run();

?>