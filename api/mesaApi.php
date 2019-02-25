<?php
require_once './vendor/autoload.php';
require_once './entidades/mesa.php';

//OPERACIONES
//-traerTodos($request, $response, $args)
//-traerPorEstado($request, $response, $args)
       
class mesaApi{
    
    public function traerTodos($request, $response, $args){
        $mesa = mesa::traerTodos();
        $newResponse = $response->withJson($mesa, 200);
        return $newResponse;
    }

    public function traerPorEstado($request, $response, $args){
        $arrayDeParametros = $request->getParsedBody();
        $mesa = mesa::traerPorEstado($arrayDeParametros);
        $response = $response->withJson($mesa, 200);
        return $response;
    }


    public function traerFacturoMenos($request, $response, $args){
        $arrayDeParametros = $request->getParsedBody();
        $mesa = mesa::traerFacturoMenos($arrayDeParametros);
        $response = $response->withJson($mesa, 200);
        return $response;
    }


    public function traerFacturoMas($request, $response, $args){
        $arrayDeParametros = $request->getParsedBody();
        $mesa = mesa::traerFacturoMas($arrayDeParametros);
        $response = $response->withJson($mesa, 200);
        return $response;
    }

    public function traerMasUsada($request, $response, $args){
        $arrayDeParametros = $request->getParsedBody();
        $mesa = mesa::traerMasUsada($arrayDeParametros);
        $response = $response->withJson($mesa, 200);
        return $response;
    }


    public function traerMenosUsada($request, $response, $args){
        $arrayDeParametros = $request->getParsedBody();
        $mesa = mesa::traerMenosUsada($arrayDeParametros);
        $response = $response->withJson($mesa, 200);
        return $response;
    }


    public function traerMayorImporte($request, $response, $args){
        $arrayDeParametros = $request->getParsedBody();
        $mesa = mesa::traerMayorImporte($arrayDeParametros);
        $response = $response->withJson($mesa, 200);
        return $response;
    }
 

    public function traerMenorImporte($request, $response, $args){
        $arrayDeParametros = $request->getParsedBody();
        $mesa = mesa::traerMenorImporte($arrayDeParametros);
        $response = $response->withJson($mesa, 200);
        return $response;
    }


}
?>