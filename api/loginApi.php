<?php
require_once './vendor/autoload.php';
require_once './entidades/login.php';
require_once './entidades/sesion.php';
require_once './entidades/autentificadorJWT.php';

//OPERACIONES:
//obtenerLogin($request, $response, $args)

class loginApi{

    public function obtenerLogin($request, $response, $args){
      
        $arrayDeParametros = $request->getParsedBody(); 
        $respuesta = login::consultaLogin($arrayDeParametros);

        if(is_array($respuesta)){
            $newResponse = $response->withJson(autentificadorJWT::crearToken($respuesta), 200);      
            $sesion = sesion::registrarSesion($arrayDeParametros);
        }
        else
            $newResponse = $response->withJson($respuesta, 404);

        return $newResponse;        
    }

}


?>