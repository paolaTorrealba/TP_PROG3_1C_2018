<?php
require_once './vendor/autoload.php';
require_once './entidades/pedido.php';
require_once './entidades/pedido_plato.php';
require_once './entidades/autentificadorJWT.php';

// OPERACIONES
//-cargarUno($request, $response, $args)
//-traerTodos($request, $response, $args)
//-traerCancelados($request, $response, $args)
//-traerPedidoUsuario($request, $response)
//-pedidoListoParaServir($request, $response, $args)
//-pedidoServido($request, $response, $args)
//-pedidoAPagar($request, $response, $args)
//-cerrarPedido($request, $response, $args) 
    

class pedidoApi{
/* Asi es como hay q pasar los productos por el Postman
        [
            {
                "idProducto": 1,
                "cantidad": 2
            },
            {
                "idProducto": 6,
                "cantidad": 1
            },
            {
                "idProducto": 2,
                "cantidad": 1
            }
        ]
*/

        
    public function cargarUno($request, $response, $args){ 

        echo "cargarUno";
        $arrayDeParametros = $request->getParsedBody();       
        $respuesta = pedido::crearPedido($arrayDeParametros);

        var_dump($arrayDeParametros);

        $fotos = $request->getUploadedFiles();
        $foto_mesa= $fotos['foto'];

        var_dump($fotos);
        
        //guardo la foto
        $destino='./fotos/';
       
        $idFoto = $arrayDeParametros['cliente']."_".$respuesta[0]->codigo;
        $nombreFoto=$foto_mesa->getClientFileName();               
        $tipoArchivo=pathinfo($nombreFoto, PATHINFO_EXTENSION);
        if($tipoArchivo != "jpg" && $tipoArchivo !="jpeg" && $tipoArchivo != "png") {
            echo "S&oacute;lo son permitidas imagenes con extensi&oacute;n JPG, JPEG o PNG.";
        }
        else{
            if(!file_exists($destino)){
                mkdir($destino);
                
                move_uploaded_file($foto_mesa->file, $destino.$idFoto.'.'.$tipoArchivo);
            }
            else{
                move_uploaded_file($foto_mesa->file, $destino.$idFoto.'.'.$tipoArchivo);
            }
          
pedido::registrarFoto($destino.$idFoto.'.'.$tipoArchivo, $respuesta[0]->codigo);
        }

        if(!is_string($respuesta)){
            foreach (json_decode($arrayDeParametros["platos"]) as $objeto) {
          
                 pedido_plato::agregarPlato($objeto, $respuesta[0]->codigo);
            }
        
            $objDelaRespuesta->respuesta="Nuevo pedido creado.";
            $objDelaRespuesta->codigo=$respuesta[0]->codigo;
        }
        else{
          
            $objDelaRespuesta->respuesta=$respuesta;   
        }
        
        return $response->withJson($objDelaRespuesta, 200);
    }



public function traerTiempoPedidos($request, $response, $args){
        $pedidos = pedido::traerTiempoPedidos();
        $newResponse = $response->withJson($pedidos, 200);
        return $newResponse;
    }

    public function traerTodos($request, $response, $args){   
        $pedidos = pedido::traerTodos();
        $newResponse = $response->withJson($pedidos, 200);
        return $newResponse;
    }    
    

    
    
    public function traerPedidoUsuario($request, $response){
        $arrayConToken = $request->getHeader('token');
	    $token=$arrayConToken[0];
        $payload=autentificadorJWT::ObtenerData($token);   
        
        $pedidos = pedido::traerPorUsuario($payload[0]->id);
        $newResponse = $pedidos;
        return $newResponse;
    }


    public function pedidoListoParaServir($request, $response, $args){

        $arrayDeParametros = $request->getParsedBody();
        
        $respuesta = pedido::actualizarPedidoListoParaServir($arrayDeParametros);

        if($respuesta>0){
            $objDelaRespuesta->respuesta="Pedido listo para servir.";
            $objDelaRespuesta->codigo=$arrayDeParametros["codigo"];
        }
        else{
            if($respuesta==0){
                $objDelaRespuesta->respuesta="El pedido aun tiene productos sin terminar";
                $objDelaRespuesta->codigo=$arrayDeParametros["codigo"];
            }else{
                $objDelaRespuesta->respuesta=$respuesta;
            }               
        }
        
        return $response->withJson($objDelaRespuesta, 200);
    }


    public function pedidoServido($request, $response, $args){

        $arrayDeParametros = $request->getParsedBody();
        
        $respuesta = pedido::actualizarPedidoServido($arrayDeParametros);

        if($respuesta>0){
            $objDelaRespuesta->respuesta="Pedido Servido.";
            $objDelaRespuesta->codigo=$arrayDeParametros["codigo"];
        }
        else{
            if($respuesta==0){
                $objDelaRespuesta->respuesta="El pedido aun tiene productos sin terminar";
                $objDelaRespuesta->codigo=$arrayDeParametros["codigo"];
            }else{
                $objDelaRespuesta->respuesta=$respuesta;
            }               
        }        
        return $response->withJson($objDelaRespuesta, 200);
    }


    public function pedidoAPagar($request, $response, $args){

        $arrayDeParametros = $request->getParsedBody();
        
        $respuesta = pedido::actualizarPedidoAPagar($arrayDeParametros);

        if($respuesta>0){
            $objDelaRespuesta->respuesta="Ticket de pago entregado.";
            $objDelaRespuesta->codigo=$arrayDeParametros["codigo"];
        }
        else{
            if($respuesta==0){
                $objDelaRespuesta->respuesta="El pedido aun tiene productos sin terminar";
                $objDelaRespuesta->codigo=$arrayDeParametros["codigo"];
            }else{
                $objDelaRespuesta->respuesta=$respuesta;
            }               
        }        
        return $response->withJson($objDelaRespuesta, 200);
    }



    public function cerrarPedido($request, $response, $args){

        $arrayDeParametros = $request->getParsedBody();
        
        $respuesta = pedido::actualizarPedidoMesaCerrado($arrayDeParametros);

        if($respuesta>0){
            $objDelaRespuesta->respuesta="Pedido cobrado, mesa cerrada y lista para limpiar.";
            $objDelaRespuesta->codigo=$arrayDeParametros["codigo"];
        }
        else{
            if($respuesta==0){
                $objDelaRespuesta->respuesta="El cliente aun no recibio su boleta de pago";
                $objDelaRespuesta->codigo=$arrayDeParametros["codigo"];
            }else{
                $objDelaRespuesta->respuesta=$respuesta;
            }               
        }        
        return $response->withJson($objDelaRespuesta, 200);
    }


    public function traerMasVendido($request, $response, $args){   
        $pedido = pedido::traerMasVendido();
        $newResponse = $response->withJson($pedido, 200);
        return $newResponse;
    }

    public function traerMenosVendido($request, $response, $args){   
        $pedido = pedido::traerMenosVendido();
        $newResponse = $response->withJson($pedido, 200);
        return $newResponse;
    }

    public function traerFueraDeTiempo($request, $response, $args){   
        $pedidos = pedido::traerFueraDeTiempo();
        $newResponse = $response->withJson($pedidos, 200);
        return $newResponse;
    }

    public function traerCancelados($request, $response, $args){   
        $pedidos = pedido::traerCancelados();
        $newResponse = $response->withJson($pedidos, 200);
        return $newResponse;
    }

     public function traerPendientes($request, $response, $args){   
        $pedidos = pedido::traerPendientes();
        $newResponse = $response->withJson($pedidos, 200);
        return $newResponse;
    }

    
}

?>