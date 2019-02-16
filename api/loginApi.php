<?php
require_once './vendor/autoload.php';
require_once './entidades/login.php';
require_once './entidades/autentificadorJWT.php';

class loginApi{

    public function obtenerLogin($request, $response, $args){
        echo "obetenrLogin";
        $arrayDeParametros = $request->getParsedBody(); 
        $respuesta = login::consultaLogin($arrayDeParametros);

        if(is_array($respuesta))
            $newResponse = $response->withJson(autentificadorJWT::CrearToken($respuesta), 200);
        else
            $newResponse = $response->withJson($respuesta, 404);

        return $newResponse;        
    }

/*
    public function nuevoUsuario($request, $response, $args){
        $arrayDeParametros = $request->getParsedBody();
        $respuesta = login::creaUsuario($arrayDeParametros);

        if($respuesta>0){
            $objDelaRespuesta->respuesta="Nuevo Usuario guardado.";
        }
        else{
            $objDelaRespuesta->respuesta=$respuesta;  
        }
        
        return $response->withJson($objDelaRespuesta, 200);
    }


    public function darDeBajaUsuario($request, $response, $args){
        $arrayDeParametros = $request->getParsedBody();
        $respuesta = login::actualizarEstadoUsuario($arrayDeParametros);

        if($respuesta>0){
            $objDelaRespuesta->respuesta="El estado del usuario a sido modificado.";
        }
        else{
            $objDelaRespuesta->respuesta=$respuesta;  
        }
        
        return $response->withJson($objDelaRespuesta, 200);
    }


    public function traerTodos($request, $response, $args){
        $usuarios = login::TraerTodos();
        $newResponse = $response->withJson($usuarios, 200);
        return $newResponse;
    }
*/
}


?>