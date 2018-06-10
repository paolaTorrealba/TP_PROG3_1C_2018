<?php
include_once "AccesoDatos.php";
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

  	public function BorrarEmpleado()
	 {
	 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from empleado 				
				WHERE id=:id");	
				$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
	 }


	public function ModificarEmpleado()
	 {

			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update empleado 
				set usuario='$this->usuario',
				clave='$this->clave',
				perfil='$this->perfil',
				sector='$this->sector',
				nombre='$this->nombre',
				apellido='$this->apellido'
				WHERE id='$this->id'");
				
			return $consulta->execute();

	 }
	
  
	 public function InsertarEmpleado()
	 {
		 $this->estado="activo";
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

		 return $objetoAccesoDato->RetornarUltimoIdInsertado();			

	 }

	  public function ModificarEmpleadoParametros()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update empleado 
				set usuario=:usuario,
				clave=:clave,
				perfil=:perfil,
				sector=:sector
				WHERE id=:id");
			$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
			$consulta->bindValue(':usuario',$this->usuario, PDO::PARAM_STR);
			$consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
			$consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
			$consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);	
			$consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
			

			return $consulta->execute();
	 }


	 public function GuardarEmpleado()
	 {

	 	if($this->id>0)
	 		{
	 			$this->ModificarEmpleado();
	 		}else {
	 			$this->InsertarEmpleado();
	 		}

	 }


  	public static function TraerTodoLosEmpleado()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM empleado");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Empleado");		
	}


	public static function TraerUnEmpleado($id) 
	{   
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from empleado where id = $id");
			$consulta->execute();
			$empleadoBuscado= $consulta->fetchObject('Empleado');
			return $empleadoBuscado;				

			
	}

	
	public static function ValidarEmpleado($usuario, $clave) 
	{
		
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT  * from empleado WHERE usuario=:usuario and clave=:clave");
			$consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
			$consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
			$consulta->execute();
			$empleadobuscado= $consulta->fetchObject('Empleado');			

				return $empleadobuscado;
			  
	}


		  public static function Suspender($id, $estado)
	 {
		 
		 if($estado=="activo")
		 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("update empleado set estado='suspendido' WHERE id=:id");
			$consulta->bindValue(':id',$id, PDO::PARAM_INT);

			 $consulta->execute();
			 return "Suspendido";

		 }
		 else
		 
			 return "activado";
		 }

	 }

	public static function CantidadDeOperaciones($id)
	{
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM operaciones WHERE idEmpleado=:id");
				$consulta->bindValue(':id', $id, PDO::PARAM_INT);
				 $consulta->execute();
				 return $consulta->rowCount();

	      			
    }

     public function ToString()
    {
     return "id: ".$this->id." - usuario: ".$this->usuario." - clave: ".$this->clave." - sector: ".$this->sector." - perfil: ".$this->perfil" - estado: ".$this->estado." - nombre: ".$this->nombre." - apellido: ".$this->apellido."<br>";
    }



}