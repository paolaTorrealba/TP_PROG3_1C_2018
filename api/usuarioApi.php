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

    public function traerTodos($request, $response, $args){
        $usuarios = usuario::traerTodos();
        $newResponse = $response->withJson($usuarios, 200);
        return $newResponse;
    }
    
}


?>