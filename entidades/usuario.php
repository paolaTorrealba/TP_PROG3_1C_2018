<?php
require_once ('./datos/AccesoDatos.php');

// OPERACIONES
//-crearUsuario($arrayDeParametros)
//-borrarUsuario($arrayDeParametros)
//-modificarUsuario($arrayDeParametros)
//-traerTodos()

class Usuario
{
	public $nombre;
 	public $apellido;
  	public $usuario;
	public $perfil;
	public $clave;
	public $estado;
	public $id;
	public $ult_fecha_log;	
	public $fecha_alta;
    public $fecha_baja;

 public static function crearUsuario($arrayDeParametros){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        try{
            $sql =$pdo->RetornarConsulta("INSERT into usuario (usuario,clave,perfil,nombre,apellido)values(:usuario,:clave,:perfil,:nombre,:apellido)");
            $nombre = ucwords(strtolower($arrayDeParametros['nombre']));
            $apellido = ucwords(strtolower($arrayDeParametros['apellido']));  
            $sql->bindValue(':usuario', strtoupper($arrayDeParametros['apellido']).".".strtoupper(str_split($arrayDeParametros['nombre'],4)[0]), PDO::PARAM_STR);
            $sql->bindValue(':clave', $arrayDeParametros['clave'], PDO::PARAM_STR);
            $sql->bindValue(':perfil', strtolower($arrayDeParametros['perfil']), PDO::PARAM_STR);
            $sql->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $sql->bindValue(':apellido', $apellido, PDO::PARAM_STR);
            $sql->execute();            
            return $sql->rowCount();
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    public static function traerTodos(){

        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("select * from usuario");
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "login");       

        return $resultado;
    }





    public function borrarUsuario($arrayDeParametros){
	 
        $pdo = AccesoDatos::dameUnObjetoAcceso();  
        try{
            $sql =$pdo->RetornarConsulta("UPDATE usuario SET  estado='eliminado', fecha_baja=CURRENT_TIMESTAMP WHERE usuario=:usuario");
            
            $sql->bindValue(':usuario', $arrayDeParametros['usuario'], PDO::PARAM_STR);
                     
            $sql->execute();
            return $sql->rowCount();
        }
        catch(Exception $e){
            return $e->getMessage();
        }

       }


    public function modificarUsuario($arrayDeParametros){
	 
        $pdo = AccesoDatos::dameUnObjetoAcceso();  
        try{        	
        	if ($arrayDeParametros['estado']=='activo'){
        		     $sql =$pdo->RetornarConsulta("UPDATE usuario SET  estado=:estado, fecha_alta=CURRENT_TIMESTAMP, fecha_baja=null WHERE usuario=:usuario");

        	}else {
	                 $sql =$pdo->RetornarConsulta("UPDATE usuario SET  estado=:estado, fecha_baja=CURRENT_TIMESTAMP, fecha_alta=null WHERE usuario=:usuario");
	        }
            $sql->bindValue(':usuario', $arrayDeParametros['usuario'], PDO::PARAM_STR);
            $sql->bindValue(':estado', $arrayDeParametros['estado'], PDO::PARAM_STR);
     
            $sql->execute();            
        	return $sql->rowCount();
        }
        catch(Exception $e){
                return $e->getMessage();
        }
    }


/*
	public function MostrarTodosDatos(){
		$objetoPDO = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoPDO->RetornarConsulta("select nombre, apellido, usuario, perfil, area, estado, ult_fecha_log, fecha_alta, fecha_baja, operaciones from id6145613_final.usuario");
		$consulta->execute();		
		$tabla ='<table style="border:1px solid black;"><tr><th>Nombre</th><th>Apellido</th><th>Usuario</th><th>Perfil</th><th>Area</th><th>Estado</th><th>Fecha ult log</th><th>Fecha alta</th><th>Fecha baja</th></tr>';
		while($i=$consulta->fetch()){
			$tabla = $tabla.'<tr><td>'.$i['nombre'].'</td>
					   <td>'.$i['apellido'].'</td>
					   <td>'.$i['usuario'].'</td>
					   <td>'.$i['perfil'].'</td>
					   <td>'.$i['area'].'</td>
					   <td>'.$i['estado'].'</td>
					   <td>'.$i['ult_fecha_log'].'</td>
					   <td>'.$i['fecha_alta'].'</td>
					   <td>'.$i['fecha_baja'].'</td>
					   <td>'.$i['operaciones'].'</td></tr>';
		}
		$tabla =$tabla.'</table>';
		echo $tabla;
	}

	public function MostrarDias(){
		$objetoPDO = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoPDO->RetornarConsulta("select usuario, ult_fecha_log, fecha_alta, fecha_baja from id6145613_final.usuario");
		$consulta->execute();		
		$tabla ='<table style="border:1px solid black;"><tr><th>Usuario</th><th>Fecha ult log</th><th>Fecha alta</th><th>Fecha baja</th></tr>';
		while($i=$consulta->fetch()){
			$tabla = $tabla.'<tr><td>'.$i['usuario'].'</td>
					   <td>'.$i['ult_fecha_log'].'</td>
					   <td>'.$i['fecha_alta'].'</td>
					   <td>'.$i['fecha_baja'].'</td></tr>';
		}
		$tabla =$tabla.'</table>';
		echo $tabla;
	}

	public function MostrarOperacionesArea(){
		$objetoPDO = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoPDO->RetornarConsulta("SELECT area, operaciones from id6145613_final.usuario WHERE area=:area");
		$consulta->bindValue(':area', $this->area, PDO::PARAM_STR);
		$consulta->execute();		
		$tabla ='<table style="border:1px solid black;"><tr><th>Usuario</th><th>Area</th><th>Operaciones</th></tr>';
		while($i=$consulta->fetch()){
			$tabla = $tabla.'<tr><td>'.$i['area'].'</td>
					   <td>'.$i['operaciones'].'</td></tr>';
		}
		$tabla =$tabla.'</table>';
		echo $tabla;
	}

	public function MostrarOperacionesAreaEmpleado(){
		$objetoPDO = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoPDO->RetornarConsulta("SELECT usuario, area, operaciones from id6145613_final.usuario WHERE area=:area");
		$consulta->bindValue(':area', $this->area, PDO::PARAM_STR);
		$consulta->execute();		
		$tabla ='<table style="border:1px solid black;"><tr><th>Usuario</th><th>Area</th><th>Operaciones</th></tr>';
		while($i=$consulta->fetch()){
			$tabla = $tabla.'<tr><td>'.$i['usuario'].'</td>
					   <td>'.$i['area'].'</td>
					   <td>'.$i['operaciones'].'</td></tr>';
		}
		$tabla =$tabla.'</table>';
		echo $tabla;
	}

	public function MostrarOperacionesEmpleado(){
		$objetoPDO = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoPDO->RetornarConsulta("SELECT usuario, operaciones from id6145613_final.usuario WHERE usuario=:usuario");
		$consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
		$consulta->execute();		
		$cantidad= $consulta->fetchObject('Usuario');
		echo "El usuario ".$cantidad->usuario." realizó ".$cantidad->operaciones." operaciones";
	}

	
	public function TraerUnUsuario($usuario, $clave) 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT id_usuario, nombre, apellido, usuario, perfil, area, estado, ult_fecha_log, fecha_alta, fecha_baja from usuario where usuario = '$usuario' AND clave='$clave'");
		$consulta->execute();
		$usuarioBuscado= $consulta->fetchObject('Usuario');
		return $usuarioBuscado;				
	}
	

	public function InsertarUsuario()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into id6145613_final.usuario (nombre, apellido, usuario, clave, perfil, area, estado, fecha_alta)values(:nombre,:apellido, :usuario, :clave, :perfil, :area, 'activo', CURRENT_TIMESTAMP)");
		$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
		$consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
		$consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
		$consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);
		$consulta->bindValue(':area', $this->area, PDO::PARAM_STR);
		$consulta->execute();
	}
*/
	
/*
	public function CambiarEstadoUsuario(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE id6145613_final.usuario SET estado=:estado where usuario=:usuario");
		$consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
		$consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
		$consulta->execute();
	}	*/ 
	 
}