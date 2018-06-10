<?php
include_once "AccesoDatos.php";
class Comanda
{
	public $id;
	public $id_mesa;
  	public $id_mozo;
	public $id_empleado;
	public $estado;
	public $tiempo_estimado;
	public $fecha_solicitud; 
	public $hora_solicitud;
	public $hora_entrega;
	public $hora_entrega;


	//METODOS GETTERS
	public function GetId()
	 {
	     return $this->id;
	 }
	 public function SetId($id)
	 {
	     $this->id = $id;
	 }

	 public function GetIdMesa()
	 {
	     return $this->id_mesa;
	 }
	 public function SetIdMesa($id_mesa)
	 {
	     $this->id_mesa = $id_mesa;
	 }

	  public function GetIdMozo()
	 {
	     return $this->id_mozo;
	 }
	 public function SetIdMozo($id_mozo)
	 {
	     $this->id_mozo = $id_mozo;
	 }

	  public function GetIdEmpleado()
	 {
	     return $this->id_empleado;
	 }
	 public function SetIdEmpleado($id_empleado)
	 {
	     $this->id_empleado = $id_empleado;
	 }

	 public function GetEstado()
	 {
	     return $this->estado;
	 }
	 public function SetEstado($estado)
	 {
	     $this->estado = $estado;
	 }

	 
	 public function GetTiempoEstimado()
	 {
	     return $this->tiempo_estimado;
	 }
	 public function SetTiempoEstimado($tiempo_estimado)
	 {
	     $this->tiempo_estimado = $tiempo_estimado;
	 }


	 public function GetFechaSolicitud()
	 {
	     return $this->fecha_solicitud;
	 }
	 public function SetFechaSolicitud($fecha_solicitud)
	 {
	     $this->fecha_solicitud = $fecha_solicitud;
	 }

	  public function GetHoraSolicitud()
	 {
	     return $this->hora_solicitud;
	 }
	 public function SetHoraSolicitud($hora_solicitud)
	 {
	     $this->hora_solicitud = $hora_solicitud;
	 }

	  public function GetFechaEntrega()
	 {
	     return $this->fecha_entrega;
	 }
	 public function SetFechaEntrega($fecha_entrega)
	 {
	     $this->fecha_entrega = $fecha_entrega;
	 }

	  public function GetHoraEntrega()
	 {
	     return $this->hora_entrega;
	 }
	 public function SetHoraEntrega($hora_entrega)
	 {
	     $this->hora_entrega = $hora_entrega;
	 }

  	public function BorrarComanda()
	 {
	 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from comanda 				
				WHERE id=:id");	
				$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
	 }


	public function ModificarComanda()
	 {

			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update comanda 
				set id_mesa='$this->id_mesa',
				id_mozo='$this->id_mozo',
				estado='$this->estado',
				id_empleado='$this->id_empleado',
				tiempo_estimado='$this->tiempo_estimado',
				fecha_solicitud='$this->fecha_solicitud',
				hora_solicitud='$this->hora_solicitud',
				fecha_entrega='$this->fecha_entrega',
				hora_entrega='$this->fecha_entrega'
				WHERE id='$this->id'");
				
			return $consulta->execute();

	 }
	
  
	 public function InsertarComanda()
	 {
		 $this->estado="activo";
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into comanda (id_mesa, id_mozo, id_empleado, estado, estado, tiempo_estimado, fecha_solicitud, hora_solicitud, fecha_entrega, hora_entrega') VALUES(:id_mesa, :id_mozo, :id_empleado, :estado, :estado, :tiempo_estimado, :fecha_solicitud, :hora_solicitud, :fecha_entrega, :hora_entrega)");

		$consulta->bindValue(':id_mesa',$this->id_mesa, PDO::PARAM_STR);
		$consulta->bindValue(':id_mozo', $this->id_mozo, PDO::PARAM_STR);
		$consulta->bindValue(':id_empleado', $this->id_empleado, PDO::PARAM_STR);
		$consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
		$consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
		$consulta->bindValue(':tiempo_estimado', $this->tiempo_estimado, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_solicitud', $this->fecha_solicitud, PDO::PARAM_STR);
        $consulta->bindValue(':hora_solicitud', $this->hora_solicitud, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_entrega', $this->fecha_entrega, PDO::PARAM_STR);
        $consulta->bindValue(':hora_entrega', $this->hora_entrega, PDO::PARAM_STR);
		
		 $consulta->execute();

		 return $objetoAccesoDato->RetornarUltimoIdInsertado();			

	 }

	  public function ModificarComandaParametros()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update comanda 
				set id_mesa=:id_mesa,
				id_mozo=:id_mozo,
				estado=:estado,
				id_empleado=:id_empleado,
				tiempo_estimado=:tiempo_estimado,
				fecha_solicitud=:fecha_solicitud,
				hora_solicitud=:hora_solicitud,
				fecha_entrega=:fecha_entrega,
				hora_entrega=:hora_entrega,
				WHERE id=:id");
			$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
			$consulta->bindValue(':id_mesa',$this->id_mesa, PDO::PARAM_STR);
			$consulta->bindValue(':id_mozo', $this->id_mozo, PDO::PARAM_STR);
			$consulta->bindValue(':id_empleado', $this->id_empleado, PDO::PARAM_STR);
			$consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);	
			$consulta->bindValue(':tiempo_estimado', $this->tiempo_estimado, PDO::PARAM_STR);
            $consulta->bindValue(':fecha_solicitud', $this->fecha_solicitud, PDO::PARAM_STR);
            $consulta->bindValue(':hora_solicitud', $this->hora_solicitud, PDO::PARAM_STR);
	        $consulta->bindValue(':fecha_entrega', $this->fecha_entrega, PDO::PARAM_STR);
	        $consulta->bindValue(':hora_entrega', $this->hora_entrega, PDO::PARAM_STR);
			

			return $consulta->execute();
	 }


	 public function GuardarComanda()
	 {

	 	if($this->id>0)
	 		{
	 			$this->ModificarComanda();
	 		}else {
	 			$this->InsertarComanda();
	 		}

	 }


  	public static function TraerTodasLasComandas()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM comanda");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Comanda");		
	}


	public static function TraerUnComanda($id) 
	{   
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from comanda where id = $id");
			$consulta->execute();
			$comandaBuscado= $consulta->fetchObject('Comanda');
			return $comandaBuscado;				

			
	}

   

}