<?php
require_once './vendor/autoload.php';
require_once './entidades/login.php';
require_once './entidades/autentificadorJWT.php';

// OPERACIONES
//-cargarUno($request, $response, $args)
//-borrarUno($request, $response, $args)
//-modificarUno($request, $response, $args)
//-traerTodos($request, $response, $args)

class UsuarioApi{   

    public function cargarUno($request, $response, $args){ //OK
        $arrayDeParametros = $request->getParsedBody();
        $respuesta = usuario::crearUsuario($arrayDeParametros);

        if($respuesta>0){
            $objDelaRespuesta->respuesta="Nuevo Usuario guardado.";
        }
        else{
            $objDelaRespuesta->respuesta=$respuesta;  
        }        
        return $response->withJson($objDelaRespuesta, 200);
    }


    public function borrarUno($request, $response, $args){
        $arrayDeParametros = $request->getParsedBody();
        $respuesta = usuario::borrarUsuario($arrayDeParametros);
        if($respuesta>0){
            $objDelaRespuesta->respuesta="Se ha eliminado el usuario";
        }
        else{
            $objDelaRespuesta->respuesta=$respuesta;  
        }        
        return $response->withJson($objDelaRespuesta, 200);
    }


    public function modificarUno($request, $response, $args){
        $arrayDeParametros = $request->getParsedBody();
        $respuesta = usuario::modificarUsuario($arrayDeParametros);

        if($respuesta>0){
            $objDelaRespuesta->respuesta="Se ha modificado el usuario";
        }
        else{
            $objDelaRespuesta->respuesta=$respuesta;  
        }        
        return $response->withJson($objDelaRespuesta, 200);
    }

    public function traerTodos($request, $response, $args){
        $usuarios = usuario::traerTodos();
        $newResponse = $response->withJson($usuarios, 200);
        return $newResponse;
    }
    

     public function traerOperacionesPorSector($request, $response, $args){
        $operaciones = operaciones::traerOperacionesPorSector();
        $newResponse = $response->withJson($operaciones, 200);
        return $newResponse;
    }

     public function traerOperacionesPorSectorYEmpl($request, $response, $args){
        $operaciones = operaciones::traerOperacionesPorSectorYEmpl();
        $newResponse = $response->withJson($operaciones, 200);
        return $newResponse;
    }

     public function traerCantidadOperacionesPorEmpl($request, $response, $args){
        $operaciones = operaciones::traerCantidadOperacionesPorEmpl();
        $newResponse = $response->withJson($operaciones, 200);
        return $newResponse;
    }


}

?>