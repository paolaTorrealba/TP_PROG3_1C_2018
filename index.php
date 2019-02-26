<?php

require 'vendor/autoload.php';
require_once 'datos/AccesoDatos.php';
require_once 'api/loginApi.php';
require_once 'api/usuarioApi.php';
require_once 'api/pedidoApi.php';
require_once 'api/encuestaApi.php';
require_once 'api/sesionApi.php';
require_once 'api/mesaApi.php';
require_once 'entidades/login.php';
require_once 'entidades/usuario.php';
require_once 'entidades/excel.php';
require_once 'entidades/pedido.php';
require_once 'entidades/pedido_plato.php';
require_once 'entidades/encuesta.php';
require_once 'entidades/operaciones.php';
require_once 'entidades/mesa.php';
require_once 'entidades/sesion.php';
require_once 'middleware/MWparaAutentificar.php';
require_once 'middleware/MWparaCORS.php';


$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->post('/login', \loginApi::class. ':obtenerLogin');  

$app->post('/sesion', \sesionApi::class. ':obtenerTodos'); 

/*
 GET  /usuario/         :cargarUno - Socio
 POST /usuario/eliminar :borrarUno - Socio 
 PUT  /usuario/         :modificarUno - Socio 
 GET  /usuario/         :traerTodos - Usuario --> agregar cantidad de operaciones***
 */
$app->group('/usuario', function () {      
  $this->post('/', \usuarioApi::class . ':cargarUno')->add(\MWparaAutentificar::class . ':VerificarSocio');
  $this->post('/eliminar', \usuarioApi::class . ':borrarUno')->add(\MWparaAutentificar::class . ':VerificarSocio');	
  $this->put('/', \usuarioApi::class . ':modificarUno')->add(\MWparaAutentificar::class . ':VerificarSocio');  
  $this->get('/', \usuarioApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':VerificarUsuario'); 

  $this->get('/operacionesPorSector', \usuarioApi::class . ':traerOperacionesPorSector')->add(\MWparaAutentificar::class . ':VerificarUsuario'); 
  $this->get('/operacionesPorSectorYEmpl', \usuarioApi::class . ':traerOperacionesPorSectorYEmpl')->add(\MWparaAutentificar::class . ':VerificarUsuario'); 
  $this->get('/cantidadOperacionesPorEmpl', \usuarioApi::class . ':traerCantidadOperacionesPorEmpl')->add(\MWparaAutentificar::class . ':VerificarUsuario'); 
     $this->get('/actividadEmpleados', \usuarioApi::class . ':traerActividadEmpleados')->add(\MWparaAutentificar::class . ':VerificarUsuario'); 


  
})->add(\MWparaCORS::class . ':HabilitarCORS8080');



/*
  POST /pedido/           :cargarUno  - Mozo
  GET  /pedido/           :traerTodos
  GET  /pedido/cancelados :traerCancelados
  POST /pedido/paraServir :pedidoListoParaServir
  POST /pedido/servido    :pedidoServido
  POST /pedido/aPagar     :pedidoAPagar
  POST /pedido/cerrado    :cerrarPedido
*/

$app->group('/pedido', function () {  
  $this->post('/', \pedidoApi::class . ':cargarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  $this->get('/', \pedidoApi::class. ':traerTodos')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  $this->get('/cancelados', \pedidoApi::class. ':traerCancelados')->add(\MWparaAutentificar::class . ':VerificarUsuario'); 
  $this->get('/pendientes', \pedidoApi::class. ':traerPendientes')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  $this->post('/paraServir', \pedidoApi::class.':pedidoListoParaServir')->add(\MWparaAutentificar::class.':VerificarMozo');
  $this->post('/servido', \pedidoApi::class. ':pedidoServido')->add(\MWparaAutentificar::class . ':VerificarMozo');
  $this->post('/aPagar', \pedidoApi::class. ':pedidoAPagar')->add(\MWparaAutentificar::class . ':VerificarMozo');
  $this->post('/cerrado', \pedidoApi::class. ':cerrarPedido')->add(\MWparaAutentificar::class . ':VerificarSocio');   
  $this->get('/masVendido', \pedidoApi::class. ':traerMasVendido')->add(\MWparaAutentificar::class . ':VerificarUsuario'); 
  $this->get('/menosVendido', \pedidoApi::class. ':traerMenosVendido')->add(\MWparaAutentificar::class . ':VerificarUsuario'); 
    $this->get('/tiempoPedidos', \pedidoApi::class . ':traerTiempoPedidos')->add(\MWparaAutentificar::class . ':VerificarUsuario'); 
  //$this->get('/fueraDeTiempo', \pedidoApi::class. ':traerFueraDeTiempo)->add(\MWparaAutentificar::class . ':VerificarUsuario'); 

})->add(\MWparaCORS::class . ':HabilitarCORS8080');



 /*
 POST /encuesta/       :cargarUno
 GET  /encuesta/       :traerTodos
*/

$app->group('/encuesta', function () {
  $this->post('/', \encuestaApi::class . ':cargarUno')->add(\MWparaAutentificar::class . ':VerificarMozo');
  $this->get('/', \encuestaApi::class. ':traerTodos')->add(\MWparaAutentificar::class . ':VerificarUsuario');
         
})->add(\MWparaCORS::class . ':HabilitarCORS8080');
      


 /*
 GET /mesa/       :traerTodos
 GET /mesa/       :traerPorEstado

*/

$app->group('/mesa', function () {
  $this->get('/', \mesaApi::class. ':traerTodos')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  $this->get('/estados', \mesaApi::class. ':traerPorEstado')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  $this->get('/facturoMenos', \mesaApi::class. ':traerFacturoMenos')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  $this->get('/facturoMas', \mesaApi::class. ':traerFacturoMas')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  $this->get('/masUsada', \mesaApi::class. ':traerMasUsada')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  $this->get('/menosUsada', \mesaApi::class. ':traerMenosUsada')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  $this->get('/mayorImporte', \mesaApi::class. ':traerMayorImporte')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  $this->get('/menorImporte', \mesaApi::class. ':traerMenorImporte')->add(\MWparaAutentificar::class . ':VerificarUsuario');
          
})->add(\MWparaCORS::class . ':HabilitarCORS8080');




$app->group('/excel', function () {

   $this->get('/', \excel::class . ':traerTodosUsuariosExcel')->add(\MWparaAutentificar::class . ':VerificarSocio');
  // $this->get('/login[/]', \excel::class . ':loginExcel');


})->add(\MWparaCORS::class . ':HabilitarCORSTodos');


$app->run();

?>