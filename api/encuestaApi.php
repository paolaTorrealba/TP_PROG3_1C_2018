<?php
require_once './vendor/autoload.php';

// ----OPERACIONES---
//-cargarUno($request, $response, $args)
//-traerTodos($request, $response, $args)
       

class encuestaApi{   

    public function cargarUno($request, $response, $args){ //Se carga desde la llamada de Cliente
        $arrayDeParametros = $request->getParsedBody();
        $respuesta = encuesta::crearEncuesta($arrayDeParametros);

        if($respuesta>0){
            $objDelaRespuesta->respuesta="Nueva Encuesta guardada.";
        }
        else{
            $objDelaRespuesta->respuesta=$respuesta;  
        }
        
        return $response->withJson($objDelaRespuesta, 200);
    }
 

    public function traerTodos($request, $response, $args){
        $encuestas = encuesta::traerTodos();
        $newResponse = $response->withJson($encuestas, 200);
        return $newResponse;
    } 
}


?>