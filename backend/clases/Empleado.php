<?php
include_once "../database/AccesoDatos.php";

class Empleado
{
	public $id;
	public $usuario;
  	public $clave;
	public $sector;
	public $perfil;
	public $estado;
	public $nombre; 
	public $apellido;

	//METODOS GETTERS
	public function GetId()
	 {
	     return $this->id;
	 }
	 public function SetId($id)
	 {
	     $this->id = $id;
	 }

	 public function GetUsuario()
	 {
	     return $this->usuario;
	 }
	 public function SetUsuario($usuario)
	 {
	     $this->usuario = $usuario;
	 }

	  public function GetClave()
	 {
	     return $this->clave;
	 }
	 public function SetClave($clave)
	 {
	     $this->clave = $clave;
	 }

	  public function GetSector()
	 {
	     return $this->sector;
	 }
	 public function SetSector($sector)
	 {
	     $this->sector = $sector;
	 }

	 public function GetPerfil()
	 {
	     return $this->perfil;
	 }
	 public function SetPerfil($perfil)
	 {
	     $this->perfil = $perfil;
	 }

	 public function GetEstado()
	 {
	     return $this->estado;
	 }
	 public function SetEstado($estado)
	 {
	     $this->estado = $estado;
	 }

	 public function GetNombre()
	 {
	     return $this->nombre;
	 }
	 public function SetNombre($nombre)
	 {
	     $this->nombre = $nombre;
	 }

	 public function GetApellido()
	 {
	     return $this->apellido;
	 }
	 public function SetApellido($apellido)
	 {
	     $this->apellido = $apellido;
	 }

public function __construct(){}

public static function BorrarEmpleado($id)
{
	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	$consulta =$objetoAccesoDato->RetornarConsulta("DELETE from empleado WHERE id=:id");	
	$consulta->bindValue(':id',$id, PDO::PARAM_INT);	                  		 
	$consulta->execute();
 return $consulta->rowCount();
}

public function InsertarEmpleado()
{

	$this->estado="activo";
	try{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into empleado (usuario, clave, sector, perfil, estado, nombre, apellido) VALUES(:usuario, :clave, :sector, :perfil, :estado, :nombre, :apellido)");

		$consulta->bindValue(':usuario',$this->usuario, PDO::PARAM_STR);
		$consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
		$consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
		$consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);
		$consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
		$consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);

		$consulta->execute();
     } catch (PDOException $ex) {
        echo  $ex->getMessage();
    }

 return $objetoAccesoDato->RetornarUltimoIdInsertado();			

}


public function ModificarEmpleado()
{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE empleado set usuario=:usuario, clave=:clave, perfil=:perfil, 
				estado=:estado, sector=:sector, nombre=:nombre , apellido=:apellido  WHERE id=:id");
			$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
			$consulta->bindValue(':usuario',$this->usuario, PDO::PARAM_STR);
			$consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
			$consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
			$consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
			$consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);	
			$consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);			

  return $consulta->execute();
}

// public function GuardarUno(){
// 	 	if($this->id>0)
// 	 		{
// 	 			$this->ModificarEmpleado();
// 	 		}else {
// 	 			$this->InsertarEmpleado();
// 	 		}
// 	 }
	

// public static function TraerTodos(){
// 	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
// 	$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM empleado");
// 	$consulta->execute();			
//  return $consulta->fetchAll(PDO::FETCH_CLASS, "Empleado");	
// }


public static function TraerUnEmpleadoId($id)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from empleado where id = $id");
    $consulta->bindValue(':id',$id, PDO::PARAM_INT);
    $consulta->execute();
	$EmpleadoBuscado= $consulta->fetchObject('Empleado');
        
 return $EmpleadoBuscado;
}
public static function TraerUnEmpleadoUsuario($usuario)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT  id, usuario, clave, perfil,	estado, sector, nombre , apellido FROM empleado where usuario =  :usuario");
		$consulta->bindValue(':usuario',$usuario, PDO::PARAM_STR); 
        $consulta->execute();
		$EmpleadoBuscado= $consulta->fetchObject('Empleado');
        
 return $EmpleadoBuscado;
   
}



	
// 	// public static function ValidarEmpleado($usuario, $clave) 
// 	// {
		
// 	// 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
// 	// 		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT  * from empleado WHERE usuario=:usuario and clave=:clave");
// 	// 		$consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
// 	// 		$consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
// 	// 		$consulta->execute();
// 	// 		$empleadobuscado= $consulta->fetchObject('Empleado');			

// 	// 			return $empleadobuscado;
			  
// 	// }


// 	 public static function CambiarEstado($id, $estado)
// 	 {
// 	 	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
// 		if($estado=="activo")		
// 		 {			
// 			$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE empleado set estado='activo' WHERE id=:id");
// 		 }
// 		else
// 		 {		 
// 			$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE empleado set estado='suspendido' WHERE id=:id");			
// 		}
// 		$consulta->bindValue(':id',$id, PDO::PARAM_INT);
// 		$consulta->execute();
// 		return $consulta->rowCount();
// 		// if($this->estado=="eliminado")
// 		// {
// 		// 	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
// 		// 	$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE empleado set estado='eliminado' WHERE id=:id");
// 		// 	$consulta->bindValue(':id',$id, PDO::PARAM_INT);

// 		// 	$consulta->execute();
// 		// 	return $consulta->rowCount();
// 		// }

// 	 }

// 	// public static function CantidadDeOperaciones($id)
// 	// {
// 	// 			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
// 	// 			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT count(*) FROM comanda WHERE idEmpleado=:id");
// 	// 			$consulta->bindValue(':id', $id, PDO::PARAM_INT);
// 	// 			 $consulta->execute();
// 	// 			 return $consulta->rowCount();

	      			
//  //    }

//      public function ToString() {
//      return "id: ".$this->id." - usuario: ".$this->usuario." - clave: ".$this->clave." - sector: ".$this->sector." - perfil: ".$this->perfil." - estado: ".$this->estado." - nombre: ".$this->nombre." - apellido: ".$this->apellido."<br>";
//     }



}
?>