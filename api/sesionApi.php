<?php
require_once './vendor/autoload.php';
require_once './entidades/sesion.php';
require_once './entidades/autentificadorJWT.php';


//OPERACIONES
//obtenerTodos($request, $response, $args)

class  sesionApi{

    public function obtenerTodos($request, $response, $args){
      
        $arrayDeParametros = $request->getParsedBody(); 
        $sesiones = sesion::traerTodos($arrayDeParametros);

        $newResponse = $response->withJson($sesiones, 200);
        return $newResponse;     
    }

}

?>