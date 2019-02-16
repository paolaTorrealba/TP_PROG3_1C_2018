<?php

require_once './entidades/autentificadorJWT.php';
/*require_once './entidades/pedidosApi.php';*/

class MWparaAutentificar
{
 /**
   * @api {any} /MWparaAutenticar/  Verificar Usuario
   * @apiVersion 0.1.0
   * @apiName VerificarUsuario
   * @apiGroup MIDDLEWARE
   * @apiDescription  Por medio de este MiddleWare verifico las credeciales antes de ingresar al correspondiente metodo 
   *
   * @apiParam {ServerRequestInterface} request  El objeto REQUEST.
 * @apiParam {ResponseInterface} response El objeto RESPONSE.
 * @apiParam {Callable} next  The next middleware callable.
   *
   * @apiExample Como usarlo:
   *    ->add(\MWparaAutenticar::class . ':VerificarUsuario')
   */
	
	public function VerificarJWT($request, $response, $next) {
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->respuesta="";	   
		
		$arrayConToken = $request->getHeader('token');
		$token=$arrayConToken[0];			
		
		//var_dump($token);
		$objDelaRespuesta->esValido=true; 
		try 
		{				
			AutJWT::VerificarToken($token);
			$objDelaRespuesta->esValido=true; 
		}
		catch (Exception $e) {      
			//guardar en un log
			$objDelaRespuesta->excepcion=$e->getMessage();
			$objDelaRespuesta->esValido=false;
		}

		if($objDelaRespuesta->esValido)
		{			    
			$response = $next($request, $response);
			
		}    
		else
		{
			$objDelaRespuesta->respuesta="Solo usuarios registrados";
			$objDelaRespuesta->elToken=$token;
		}  
				  
		if($objDelaRespuesta->respuesta!="")
		{
			$nueva=$response->withJson($objDelaRespuesta, 401);  
			return $nueva;
		}
		  
		return $response;   
	}


}