<?php
require_once 'IApiUsable.php';
//require_once 'AutentificadorJWT.php';
include_once("Empleado.php");

class EmpleadoApi {

 	public function TraerUno($request, $response, $args)
  {
     	$id=$args['id'];
      $empleado=Empleado::TraerUno($id);
      $objRespuesta= new stdclass();
      if(!$empleado)
      {           
            $objRespuesta->error="No existe el empleado";
            $Respuesta = $response->withJson($objRespuesta, 500); 
      }else
      {
            $respuesta["empleado"] = $empleado;
            $Respuesta = $response->withJson($respuesta, 200); 
     }     
        return $Respuesta;
  }

  public function TraerTodos($request, $response, $args)
  {      
        $arrayEmpleados=Empleado::TraerTodos();
        $objRespuesta= new stdclass();
        if(!$arrayEmpleados)
        {         
            $objRespuesta->error="No hay registros para mostrar";
            $Respuesta = $response->withJson($objRespuesta, 500); 
        }else
        {
            $respuesta["empleados"] = $arrayEmpleados;              
            $Respuesta = $response->withJson($respuesta,200);  
        }
        
        return $Respuesta;
       
  }    

  public function IngresarUno($request, $response, $args) 
  {   
          $ArrayDeParametros = $request->getParsedBody();
          $objRespuesta = new stdclass(); 

          //var_dump($ArrayDeParametros);
          $usuario = $ArrayDeParametros['usuario'];
          $clave= $ArrayDeParametros['clave'];
          $sector= $ArrayDeParametros['sector'];        
          $perfil= $ArrayDeParametros['perfil'];
          $nombre= $ArrayDeParametros['nombre'];
          $apellido= $ArrayDeParametros['apellido'];

          $miEmpleado= new Empleado();
          $miEmpleado->usuario=$usuario;
          $miEmpleado->clave=$clave;
          $miEmpleado->sector=$sector;
          $miEmpleado->perfil=$perfil;
          $miEmpleado->nombre=$nombre;
          $miEmpleado->apellido=$apellido;

          $ultimoId=$miEmpleado->IngresarUno();    
           //$response->getBody()->write("se guardo el empleado");
          if (!$ultimoId)
          {
            $objRespuesta->error="Error al ingresar el empleado";
            $Respuesta = $response->withJson($objRespuesta, 500);           
          }
          else 
          {
            $objRespuesta->respuesta="Se guardo el Empleado.";
            $objRespuesta->ultimoIdGrabado=$ultimoId;  
            $Respuesta = $response->withJson($objRespuesta, 200);
          }

          return $Respuesta;
    }

 


  public function BorrarUno($request, $response, $args)
   {
      $ArrayDeParametros = $request->getParsedBody();
      $newResponse = $response;
         
      $id=$ArrayDeParametros['id'];
      $empleado = new Empleado();
      if(empty(Empleado::TraerUno($id))){
         $newResponse = $newResponse->withAddedHeader('alertType', "danger");
      $rta = "No se encontró el empleado";
      } else
      {      
        $cantidadDeBorrados = Empleado::BorrarEmpleado($id);
        if($cantidadDeBorrados>0)
        {
           $newResponse = $newResponse->withAddedHeader('alertType', "success");
           $rta = "Elementos borrados: ".$cantidadDeBorrados;
        } else {
           $newResponse = $newResponse->withAddedHeader('alertType', "danger");
           $rta = "No se pudo borrar el empleado";  
        }
      }
    $newResponse->getBody()->write($rta);
    return $newResponse;
  }
   
   public function ModificarUno($request, $response, $args) {
    $newResponse = $response;

    $ArrayDeParametros = $request->getParsedBody();
   // var_dump($ArrayDeParametros );
    if ($ArrayDeParametros == null or !array_key_exists('id', $ArrayDeParametros))
    {
      $newResponse = $newResponse->withAddedHeader('alertType', "warning");
      $rta = '<p>Ingrese debe ingresar al menos la key "id"</p>';
    } else 
    {

      if ($ArrayDeParametros['id']==null) 
      {
         echo "el id es null";
        $newResponse = $newResponse->withAddedHeader('alertType', "danger");
        $rta = '<p>ERROR!! Complete el campo de la key "id"</p>';
      }else 
      {
        $miempleado = Empleado::TraerUnEmpleadoId($ArrayDeParametros['id']);
       // var_dump($miempleado);
        if (empty($miempleado)) 
        {
          return $newResponse->getBody()->write('<p>ERROR!! No se encontró el empleado que desea modificar.</p>');
         
        } else 
        {

          $array_usuario = self::comprobar_key("usuario", $ArrayDeParametros);
          if ($array_usuario["esValido"]) 
          {
              if (!empty(Empleado::TraerUnEmpleadoUsuario($ArrayDeParametros['usuario'])) && Empleado::TraerUnEmpleadoUsuario($ArrayDeParametros['usuario'])->id != $miempleado->id)
              {
                return $newResponse->getBody()->write('<p>ERROR!! Ese usuario ya está registrado.</p>');
              }    
              $miempleado->usuario=$ArrayDeParametros['usuario'];  
          } 
          elseif (array_key_exists('msg', $array_usuario))
          {
            return $newResponse->getBody()->write($array_usuario["msg"]);
          }
        

          $array_clave = self::comprobar_key("clave", $ArrayDeParametros);
          if ($array_clave["esValido"]) 
          {
            $miempleado->setClave($ArrayDeParametros['clave']);
          } elseif (array_key_exists('msg', $array_clave))
          {
            return $newResponse->getBody()->write($array_clave["msg"]);
          }

          $array_perfil = self::comprobar_key("perfil", $ArrayDeParametros);
          if ($array_perfil["esValido"]) {
            if ($ArrayDeParametros['perfil'] != "usuario" 
            && $ArrayDeParametros['perfil'] != "administrador"
            && $ArrayDeParametros['perfil'] != "suspendido") {
              return $newResponse->getBody()->write('<p>ERROR!! Sólo puede ingresar "usuario", "administrador" o "suspendido" en el perfil.</p>');
            }
  
            $miempleado->perfil=$ArrayDeParametros['perfil'];
          } elseif (array_key_exists('msg', $array_perfil)) {
            return $newResponse->getBody()->write($array_perfil["msg"]);
          }

          $array_sector = self::comprobar_key("sector", $ArrayDeParametros);
          if ($array_sector["esValido"]) {
            if ($ArrayDeParametros['sector'] != "vinos" 
            && $ArrayDeParametros['sector'] != "cervezas"
            && $ArrayDeParametros['sector'] != "cocina"
            && $ArrayDeParametros['sector'] != "bar") {
              return $newResponse->getBody()->write('<p>ERROR!! Sólo puede ingresar "vinos", "cervezas","bar" o "cocina" en el sector.</p>');
            }
  
            $miempleado->sector=$ArrayDeParametros['sector'];
          } elseif (array_key_exists('msg', $array_sector)) {
            return $newResponse->getBody()->write($array_sector["msg"]);
          }
          
          $array_nombre = self::comprobar_key("nombre", $ArrayDeParametros);
          if ($array_nombre["esValido"]) {
            $miempleado->nombre=$ArrayDeParametros['nombre'];
          } elseif (array_key_exists('msg', $array_nombre)) {
            return $newResponse->getBody()->write($array_nombre["msg"]);
          }
  
          $array_apellido = self::comprobar_key("apellido", $ArrayDeParametros);
          if ($array_apellido["esValido"]) {
            $miempleado->apellido=$ArrayDeParametros['apellido'];
          } elseif (array_key_exists('msg', $array_apellido)) {
            return $newResponse->getBody()->write($array_apellido["msg"]);
          }
  
          /*
          $miempleado->nombre=$ArrayDeParametros['nombre'];
          $miempleado->apellido=$ArrayDeParametros['apellido'];
          $miempleado->mail=$ArrayDeParametros['mail'];
          $miempleado->turno=$ArrayDeParametros['turno'];
          $miempleado->perfil=$ArrayDeParametros['perfil'];
  
          $miempleado->setClave($ArrayDeParametros['clave']);
          */
  
          $newResponse = $newResponse->withAddedHeader('alertType', "success");
          if ($miempleado->ModificarEmpleado()>0) {
            $rta = "Empleado modificado";
            $newResponse = $newResponse->withAddedHeader('alertType', "success");
          } else {
            $rta = "No se modificó el empleado";
          }       
        }
      } 
    }
    $newResponse->getBody()->write($rta);
        return $newResponse;  
    }



   

  // public function ModificarUno($request, $response, $args) {
  //     	$ArrayDeParametros = $request->getParsedBody(); 
  //        //  var_dump($ArrayDeParametros);
  //       $objRespuesta= new stdclass();

  //       $usuario= $ArrayDeParametros['usuario'];
  //       $sector= $ArrayDeParametros['sector'];
  //       $clave= $ArrayDeParametros['clave'];
  //       $perfil= $ArrayDeParametros['perfil'];
  //       $id= $ArrayDeParametros['id'];
  //       $nombre= $ArrayDeParametros['nombre'];
  //       $apellido= $ArrayDeParametros['apellido'];

  //       $miEmpleado= new Empleado();
  //       $miEmpleado->usuario=$usuario;
  //       $miEmpleado->clave=$clave;
  //       $miEmpleado->sector=$sector;
  //       $miEmpleado->perfil=$perfil;
  //       $miEmpleado->id=$id;
  //       $miEmpleado->nombre=$nombre;
  //       $miEmpleado->apellido=$apellido;

	 //    	$cantidadModificados = $miEmpleado->ModificarUno();     
	 //    	$objRespuesta= new stdclass();		
  //       $objRespuesta->cantidad=$cantidadModificados;
     
  //       if($cantidadModificados>0)
  //       {      
  //         $objRespuesta->respuesta="Se modifico el empleado";
  //         $Respuesta = $response->withJson($objRespuesta, 200);
         
  //       }else
  //       {
  //         $objRespuesta->respuesta="No se pudo modificar el empleado";    
  //         $Respuesta = $response->withJson($objRespuesta, 500);
  //       }
		    
       
		// return 	$Respuesta;
  //   }

//  public function Login($request, $response, $args) 
//  {
     	
//      	$ArrayDeParametros = $request->getParsedBody();
	 
// 	    $usuario=$ArrayDeParametros['usuario'];
// 	    $clave=$ArrayDeParametros['clave'];
        
//         $empleado=Empleado::ValidarEmpleado($usuario,$clave);
//         $datos = array('usuario' => $empleado->usuario,'perfil' => $empleado->perfil, 'id'=>$empleado->id);


//        $token= AutentificadorJWT::CrearToken($datos);
//         $respuesta= array('token'=>$token,'datos'=> $datos);
        


// 		return $response->withJson($respuesta, 200);		
// }


public function CambiarEstado($request, $response, $args)
{
     	
  $ArrayDeParametros = $request->getParsedBody(); 
  $id=$ArrayDeParametros['id'];
  $estado=$ArrayDeParametros['estado'];   	
 
  $cantidadModificados= Empleado::CambiarEstado($id,$estado);        
	$objRespuesta= new stdclass();
		//var_dump($resultado);
	$objRespuesta->respuesta=$cantidadModificados;
  if ($cantidadModificados>0)
  {
    $objRespuesta->respuesta="El estado del empleado es ".$estado;
    $Respuesta = $response->withJson($objRespuesta, 200);
  }
  else
  {
   $objRespuesta->respuesta="No se ha modificado el estado";    
   $Respuesta = $response->withJson($objRespuesta, 500);
  }
 
	return $Respuesta;
}

//     public static function CantidadDeOperaciones($request, $response, $args)
//     {
//         $id=$args['id'];
//         $operaciones=Empleado::CantidadDeOperaciones($id);
//         return $response->withJson($operaciones, 200);
// }

public function ToString() {
      return "id: ".$this->id." - usuario: ".$this->usuario." - clave: ".$this->clave." - sector: ".$this->sector.
         " - perfil: ".$this->perfil." - id_restaurante: ".$this->id_restaurante." - puntos_restaurante: ".$this->puntos_restaurante.
         " - id_cocinero: ".$this->id_cocinero." - estado: ".$this->estado." - nombre: ".$this->nombre." - apellido: ".$this->apellido."<br>";
    }

    public static function comprobar_key($tag, $unArray){
        $rta_array = array();
        $rta_array["esValido"] = false;
        //var_dump($tag);
        if (array_key_exists($tag, $unArray)) {
      if ($unArray[$tag]==null) {
                $rta_array["msg"] = '<p>ERROR!! Complete el campo de la key "'.$tag.'" </p>';
      } else {
                $rta_array["esValido"] = true;
            }
        }
        return $rta_array;
    }
}
?>