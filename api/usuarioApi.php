<?php
require_once './vendor/autoload.php';
require_once './entidades/login.php';
require_once './entidades/AutentificadorJWT.php';

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

    
}
?>